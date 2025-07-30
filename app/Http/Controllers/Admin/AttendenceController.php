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
    public function index(Request $request)
    {
        // Month/year from request or default to current
        $currentMonth = $request->input('month', Carbon::now()->month);
        $currentYear = $request->input('year', Carbon::now()->year);

        $now = Carbon::create($currentYear, $currentMonth, 1);
        $totalDays = $now->daysInMonth;
        $currentMonthName = $now->format('F');

        $startDate = $now->copy()->startOfMonth()->toDateString();
        $endDate = $now->copy()->endOfMonth()->toDateString();

        $employees = User::where('role', 'user')->where('status', 'active')->orderBy('id', 'desc')->get();

        // Attendance insert sirf current month/year ke liye
        if ($currentMonth == Carbon::now()->month && $currentYear == Carbon::now()->year) {
            $lastDay = Carbon::now()->day;
            for ($day = 1; $day <= $lastDay; $day++) {
                $date = Carbon::createFromDate($currentYear, $currentMonth, $day)->toDateString();

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
        }

        $attendances = UserAttendances::whereBetween('date', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($item) {
                return $item->user_id . '_' . Carbon::parse($item->date)->day;
            });

        return view("admin.attendence.index", compact('totalDays', 'currentMonthName', 'currentYear', 'employees','startDate','endDate','attendances','currentMonth'));
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
