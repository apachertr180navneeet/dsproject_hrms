<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    User,
    UserAttendances
};
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail, DB, Hash, Validator, Session, File,Exception;

class AttendenceController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $totalDays = $now->daysInMonth;
        $currentMonthName = $now->format('F');
        $currentYear = $now->year;

        // Get attendance for the current month
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();

        $employees = User::where('role', 'user')->where('status', 'active')->orderBy('id', 'desc')->get();

        // Loop through each day of the current month up to today
        for ($day = 1; $day <= $now->day; $day++) {
            $date = Carbon::createFromDate($currentYear, $now->month, $day)->toDateString();

            foreach ($employees as $employee) {
                $alreadyExists = UserAttendances::where('user_id', $employee->id)
                    ->whereDate('date', $date)
                    ->exists();

                if (!$alreadyExists) {
                    UserAttendances::create([
                        'user_id' => $employee->id,
                        'date' => $date,
                        'status' => 'P',
                    ]);
                }
            }
        }

        $attendances = UserAttendances::whereBetween('date', [$startDate, $endDate])
        ->get()
        ->groupBy(function ($item) {
            return $item->user_id . '_' . Carbon::parse($item->date)->day;
        });

        return view("admin.attendence.index", compact('totalDays', 'currentMonthName', 'currentYear', 'employees','startDate','endDate','attendances'));
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

    public function addattendence(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:P,A,L,-'
        ]);

        UserAttendances::updateOrInsert(
            [
                'user_id' => $request->user_id,
                'date' => $request->date,
            ],
            [
                'status' => $request->status,
                'updated_at' => now()
            ]
        );

        return response()->json(['success' => true, 'message' => 'Attendance updated']);
    }

}
