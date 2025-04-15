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
use Mail, DB, Hash, Validator, Session, File,Exception;

class AttendenceController extends Controller
{
    public function index()
    {
        $totalDays = Carbon::now()->daysInMonth;

        $currentMonthName = Carbon::now()->format('F');

        $currentYear = Carbon::now()->year;

        return view("admin.attendence.index", compact('totalDays', 'currentMonthName', 'currentYear'));
    }
    
    public function add()
    {
        return view("admin.employee.add");
    }

    public function destroy($id)
    {

        try{
            User::where('id',$id)->delete();
            return response()->json([
                'success' => 'success',
                'message' => 'deleted successfully',
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

    }
}
