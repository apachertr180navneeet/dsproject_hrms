<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    User,
    UserDetail,
    UserDocument,
};
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail, DB, Hash, Validator, Session, File, Exception, Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        return view("admin.employee.index");
    }


    public function getall(Request $request)
    {
        $user = Auth::user();

        $employee = User::where('role', 'user')->orderBy('id', 'desc')->get();

        return response()->json(['data' => $employee]);
    }
    
    public function add()
    {
        return view("admin.employee.add");
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Get user and related records
            $user = User::findOrFail($id);
            $userDetails = UserDetail::where('user_id', $id)->first();
            $userDocuments = UserDocument::where('user_id', $id)->get();

            // Delete avatar from storage/profiles/
            if ($user->avatar && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }

            // Delete each document file from storage/employee_documents/
            foreach ($userDocuments as $doc) {
                if ($doc->document_file && Storage::exists($doc->document_file)) {
                    Storage::delete($doc->document_file);
                }
            }

            // Permanently delete records
            UserDetail::where('user_id', $id)->forceDelete();
            UserDocument::where('user_id', $id)->forceDelete();
            User::where('id', $id)->forceDelete();

            DB::commit();

            return response()->json([
                'success' => 'success',
                'message' => 'User and files deleted permanently.',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function saveBasicInfo(Request $request)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:100',
            'dob' => 'required|date',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . $request->employee_id,
            'joining_date' => 'required|date',
            'base_salary' => 'required|numeric|min:0',
            'profile' => 'nullable|image',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            if ($request->employee_id) {
                // Update existing user
                $user = User::find($request->employee_id);
                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User not found.',
                    ]);
                }
            } else {
                // Create new user
                $user = new User();
                $user->role = 'user';
            }

            // Common fields
            $user->full_name = $request->name;
            $user->date_of_birth = $request->dob;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->date_of_joing = $request->joining_date;

            if ($request->hasFile('profile')) {
                $user->avatar = $request->file('profile')->store('profiles', 'public');
            }

            $user->save();

            // Save or update user details
            $details = UserDetail::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'Joing_date' => $request->joining_date,
                    'base_salary' => $request->base_salary,
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $request->employee_id ? 'User updated successfully!' : 'User and user details saved successfully!',
                'user_id' => $user->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function saveEmployeDetail(Request $request)
    {
        // Validation rules
        $rules = [
            'employee_id'     => 'required|integer',
            'refrence_name'   => 'required|string|max:100',
            'refrence_phone'  => 'required|string|max:100',
            'refrence_realtion'=> 'required|string|max:100',
            'ni_number'       => 'required|string|max:100',
            'utr_number'      => 'required|string|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();

        try {
            // Find or create user detail record
            $userDetail = UserDetail::firstOrNew(['user_id' => $request->employee_id]);

            // Update fields
            $userDetail->ni_number       = $request->ni_number;
            $userDetail->utr_number      = $request->utr_number;
            $userDetail->refrence_name   = $request->refrence_name;
            $userDetail->refrence_realtion   = $request->refrence_realtion;
            $userDetail->refrence_phone  = $request->refrence_phone;
            $userDetail->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Employee details saved successfully!',
                'user_id' => $request->employee_id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function saveEmployeDocument(Request $request)
    {
        DB::beginTransaction();

        try {
            $employeeId = $request->doc_employee_id;

            $documents = [
                'Passport'          => ['expiry' => 'passport_expiry_date', 'file' => 'passport_document_file'],
                'BRP/Visa'          => ['expiry' => 'visa_expiry_date', 'file' => 'visa_document_file'],
                'License'           => ['expiry' => 'license_expiry_date', 'file' => 'license_document_file'],
                'DBS'               => ['expiry' => 'dbs_expiry_date', 'file' => 'dbs_document_file'],
                'CSCS card'         => ['expiry' => 'cscscard_expiry_date', 'file' => 'cscscard_document_file'],
                'NPORS/CPCS card'   => ['expiry' => 'nrors_cpcs_expiry_date', 'file' => 'nrors_cpcs_document_file'],
            ];

            foreach ($documents as $docName => $info) {
                $expiryField = $info['expiry'];
                $fileField   = $info['file'];

                // 🔍 Check if document already exists
                $document = UserDocument::where('user_id', $employeeId)
                    ->where('document_name', $docName)
                    ->first();

                // ✏️ If not exists, create new
                if (!$document) {
                    $document = new UserDocument();
                    $document->user_id = $employeeId;
                    $document->document_name = $docName;
                }

                // 🗓️ Update expiry date
                $document->expiring_date = $request->$expiryField;

                // 📁 If file is uploaded, update it
                if ($request->hasFile($fileField)) {
                    $file = $request->file($fileField);
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('employee_documents', $filename, 'public');
                    $document->document_file = $filePath;
                }

                $document->save();
            }

            DB::commit();
            return redirect()->route('admin.employee.index')->with('success', 'Documents saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with("error", $e->getMessage());
        }
    }

    public function edit($id)
    {
        $getUser = User::where('id', $id)->first();
        $getUserdetail = UserDetail::where('user_id', $id)->first();
        $getUserdocuments = UserDocument::where('user_id', $id)->get();

        // Prepare document array with document_name (spaces removed) as the key
        $documents = [];
        foreach ($getUserdocuments as $doc) {
            $key = str_replace(' ', '', $doc->document_name); // Remove all spaces
            $documents[$key] = [
                'doc' => $doc->document_name,
                'expirydate' => $doc->expiring_date,
                'file' => $doc->document_file,
                'doc_id' => $doc->id,
            ];
        }

        return view("admin.employee.edit", compact('getUser', 'getUserdetail', 'documents'));
    }
}
