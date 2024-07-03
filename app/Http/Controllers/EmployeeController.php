<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\EmployeeMeta;
use App\Models\Department;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function getInfo($employeeId)
    {
        // استرجاع معلومات الموظف من جدول users
        $user = User::find($employeeId);

        // استرجاع معلومات إضافية من جدول employee_meta
        $employeeMeta = EmployeeMeta::where('user_id', $employeeId)->get()->pluck('meta_value', 'meta_field');

        // استرجاع القسم
        $departmentId = $employeeMeta['department_id'] ?? null;
        $department = $departmentId ? Department::find($departmentId)->name : 'N/A';

        // استرجاع آخر 5 تسجيلات للحضور والانصراف
        $attendances = Attendance::where('user_id', $employeeId)
            ->orderBy('Day_date', 'desc')
            ->take(5)
            ->get(['Day_date', 'Attendance_time', 'Departure_time']);
         $formatted_attendances = $attendances->map(function ($attendance) {
            $carbonDay = Carbon::parse($attendance->Day_date);
            setlocale(LC_TIME, 'ar');
            return [
                'Day_date' => $carbonDay->translatedFormat('Y-m-d l'),
                'Attendance_time' => Carbon::parse($attendance->Attendance_time)->toTimeString(),
                'Departure_time' => Carbon::parse($attendance->Departure_time)->toTimeString(),
            ];});
        // إعداد البيانات للإرجاع
        $data = [
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'salary' => $user->salary,
            'department_name' => $department,
            'attendances' => $formatted_attendances
        ];

        return response()->json($data);
    }
}






