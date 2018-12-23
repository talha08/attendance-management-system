<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/1/18
 * Time: 1:18 PM
 */

namespace App\Services;


use App\BaseSettings\AppSettings;
use App\Models\Attendance;
use App\Repositories\AttendanceRepository;
use App\Repositories\UserRepository;
use App\Responses\ApiResponse;
use Carbon\Carbon;

class AttendanceService extends BaseService
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var AttendanceRepository
     */
    private $attendanceRepository;
    /**
     * @var WorkHolidaysService
     */
    private $holidaysService;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * AttendanceService constructor.
     * @param ApiResponse $apiResponse
     * @param AttendanceRepository $attendanceRepository
     * @param WorkHolidaysService $holidaysService
     * @param UserRepository $userRepository
     */
    public function __construct(ApiResponse $apiResponse, AttendanceRepository $attendanceRepository, WorkHolidaysService $holidaysService, UserRepository $userRepository
    )
    {
        $this->apiResponse = $apiResponse;
        $this->attendanceRepository = $attendanceRepository;
        $this->holidaysService = $holidaysService;
        $this->userRepository = $userRepository;
    }


    /**
     * return Repository instance
     *
     * @return mixed
     */
    public function baseRepository()
    {
        return $this->attendanceRepository;
    }


    public function getTodayAttendanceForSpecificUser()
    {
        $userID = auth()->user()->id;
        $attendance = $this->attendanceRepository->getQuery()
            ->where('user_id', $userID)
            ->where('work_date',Carbon::now()->toDateString())
            ->first();
        if($attendance){
            return [
                'counter_status' => true,
                'attendance_id' => $attendance->id,
                'status' => $attendance->status,
                'entry_time' => $attendance->entry_time,
                'total_worked_time' => $attendance->total_worked_time,
                'break_entry_time' => $attendance->break_entry_time
            ];
        }else{
            return [
                'counter_status' => false,
            ];
        }
    }


    public function getUserCurrentMonthStatistics()
    {
        $userID = auth()->user()->id;
        $attendanceSumInSeconds = $this->attendanceRepository->getQuery()
            ->where('user_id', $userID)
            ->whereMonth('work_date', Carbon::now()->month)
            ->sum('total_worked_time');

        $holidayCount = $this->holidaysService->getCurrentMonthHolidayCount();

        $totalDaysInCurrentMonth = Carbon::now()->daysInMonth;

        return [
            'office_day' => $totalDaysInCurrentMonth - $holidayCount,
            'holiday' => $holidayCount,
            'spend_hours' => floor($attendanceSumInSeconds /60 /60),
        ];
    }



    public function createAttendance($request)
    {
        $data = $request->only(['work_date','entry_time','finish_time', 'user_id','status','break_entry_time']);
        $data['user_id'] = auth()->user()->id;
        $data['work_date'] = Carbon::now()->toDateString();
        $attendance = $this->attendanceRepository->create($data);
        return $attendance;
    }


    public function updateAttendance($request,$attendance_id)
    {
        $data = $request->only(['work_date','entry_time','total_worked_time','finish_time','status','break_entry_time']);
        $attendance = $this->attendanceRepository->update($data, $attendance_id);
        return $attendance;
    }


    public function getAllAttendancesByMonth($request)
    {
        $role =  auth()->user()->roleUser->role->name;
        $date =  Carbon::parse($request->date)->format('m');

        $query = $this->attendanceRepository->getQuery()
            ->whereRaw('MONTH(work_date) = ?',[$date]);

        if($role == 'admin'){
            $attendance = $query->get();
        }else{
            $attendance = $query->where('user_id', auth()->user()->id)->get();
        }

        return $attendance;
    }

    public function getAllAttendancesByDate($request)
    {
        $role =  auth()->user()->roleUser->role->name;
        //$date =  Carbon::parse($request->date)->format('m');
        $query = $this->attendanceRepository->getQuery()
            ->where('work_date',$request->date);

        if($role == 'admin'){
            $attendance = $query->get();
        }else{
            $attendance = $query->where('user_id', auth()->user()->id)->get();
        }

        return $attendance;
    }


    public function getAttendanceDetails($attendance_id)
    {
        $attendance = $this->attendanceRepository->find($attendance_id);
        return $attendance;
    }


    public function getUserWiseAttendance($user_id)
    {
        $attendance = $this->attendanceRepository->getQuery()->where('user_id', $user_id)->get();
        return $attendance;
    }



    public function getUserAttendanceByMonth($request, $user_id)
    {
        $currentMonth = date('m');
        $attendance = $this->attendanceRepository->getQuery()
            ->where('user_id', $user_id)
            ->whereRaw('MONTH(work_date) = ?',[$currentMonth])
            ->get();
        return $attendance;
    }


    public function getUserAttendanceStatisticsForToday()
    {
        $totalUser = $this->userRepository->getQuery()->count();
        $activeUser = $this->attendanceRepository->getQuery()
            ->whereDay('work_date', Carbon::now()->day)
            ->count();
        return [
            'total' => $totalUser,
            'active' => $activeUser,
            'inactive' => $totalUser - $activeUser
        ];
    }


    public function getTodayUserAttendancePercentage()
    {
      return   $users = $this->userRepository->getQuery('todayAttendance')->paginate(AppSettings::$paginate);
    }
}
