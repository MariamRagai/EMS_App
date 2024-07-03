<?php
namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
//use Carbon\CarbonImmutable;

class LeavesController extends Controller
{
public function leaverequest(Request $request)
{
    $validatedData = $request->validate([
        'leave_type' => 'required',
        'date_start' => 'required|date',
        'reason' => 'required',
        'user_id'=> 'required'
    ]);
    // Find the LeaveType by name

    $leaveType = LeaveType::where('name', $validatedData['leave_type'])->first();

    if (!$leaveType) {
        return response()->json(['error' => 'Invalid leave type'], 422);
    }

    // Calculate end date based on leave days from LeaveType

    $date_end = Carbon::parse($validatedData['date_start'])->addDays($leaveType->leave_days)->toDateString();

    // Save LeaveRequest
    $leaveRequest = new LeaveRequest();
    $leaveRequest->leave_type_id = $leaveType->id;
    $leaveRequest->date_start = $validatedData['date_start'];
    $leaveRequest->date_end = $date_end;
    $leaveRequest->reason = $validatedData['reason'];
    $leaveRequest->user_id = $validatedData['user_id'];
    $leaveRequest->leave_days = $leaveType->leave_days;
    $leaveRequest->save();

    return response()->json(['message' => 'Leave request submitted successfully'], 200);
}
public function approvedLeaves($employeeId)
    {
        // استعلام لاسترجاع الأيام المعتمدة بناءً على حالة الطلب و user_id
        $user = User::findOrFail($employeeId);
        $approvedLeaves = $user->leaveRequests()->where('status', 1)->get();

        if ($approvedLeaves->isEmpty()) {
            // التحقق من الحالات المختلفة للطلبات
            $pendingLeaves = $user->leaveRequests()->where('status', 0)->exists();
            $deniedLeaves = $user->leaveRequests()->where('status', 2)->exists();
            $cancelledLeaves = $user->leaveRequests()->where('status', 3)->exists();

            if ($pendingLeaves) {
                return response()->json([
                    'message' => '.لم يتم الموافقة على طلب الأجازة، مازال معلقاً'
                ], 404);
            } elseif ($deniedLeaves) {
                return response()->json([
                    'message' => 'تم رفض الطلب'
                ], 404);
            } elseif ($cancelledLeaves) {
                return response()->json([
                    'message' => 'تم إلغاء الطلب'
                ], 404);
            } else {
                return response()->json([
                    'message' => 'لا يوجد طلب تم قبوله'
                ], 404);
            }
        }

        // تنسيق واستعراض الأيام بناءً على البيانات المسترجعة
        $leaveDays = [];
        foreach ($approvedLeaves as $leave) {
            $startDate = Carbon::parse($leave->date_start);
            $endDate = Carbon::parse($leave->date_end);
            $days = $startDate->diffInDays($endDate) + 1; // +1 لتضمين يوم البداية أيضًا

            $leaveTypeName = $leave->leaveType->name;  //اسم الأجازة
            // إنشاء مصفوفة بتواريخ الأيام
            for ($i = 0; $i < $days; $i++) {
                $leaveDays[] = $startDate->copy()->addDays($i)->toDateString();
            }
        }

        // إرجاع النتيجة كـ JSON أو عرض البيانات بالشكل المناسب
        return response()->json([
            'leave_name'=> $leaveTypeName,
            'leave_days' => $leaveDays]);

    }

}

