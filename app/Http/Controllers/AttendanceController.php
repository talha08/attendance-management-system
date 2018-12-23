<?php

namespace App\Http\Controllers;

use App\Responses\ApiResponse;
use App\Services\AttendanceService;
use App\Transformers\Api\Attendance\AttendanceCalendarTransformer;
use App\Transformers\Api\Attendance\AttendanceTransformer;
use App\Transformers\Api\Attendance\UserAttendancePercentageTransformer;
use Illuminate\Http\Request;


class AttendanceController extends Controller
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var AttendanceService
     */
    private $attendanceService;

    /**
     * AttendanceController constructor.
     * @param ApiResponse $apiResponse
     * @param AttendanceService $attendanceService
     */
    public function __construct(ApiResponse $apiResponse, AttendanceService $attendanceService)
    {
        $this->apiResponse = $apiResponse;
        $this->attendanceService = $attendanceService;
    }



    public function createAttendance(Request $request)
    {
        try{
            $attendance = $this->attendanceService->createAttendance($request);
            return $this->apiResponse->withItem($attendance, new AttendanceTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }



    public function updateAttendance(Request $request, $attendance_id)
    {
        try{
            $attendance = $this->attendanceService->updateAttendance($request,$attendance_id);
            return $this->apiResponse->withItem($attendance, new AttendanceTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }


    public function deleteAttendance($id)
    {
        try{
            $attendance = $this->attendanceService->delete($id);
            return $this->apiResponse->success('Successfully Deleted');
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }

    public function getTodayAttendanceForSpecificUser()
    {
        try{
           return  $attendance = $this->attendanceService->getTodayAttendanceForSpecificUser();
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }

    public function getUserCurrentMonthStatistics()
    {
        try{
           return  $attendance = $this->attendanceService->getUserCurrentMonthStatistics();
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }


    public function getAllAttendancesByMonth(Request $request)
    {
        try{
            $attendances = $this->attendanceService->getAllAttendancesByMonth($request);
            return $this->apiResponse->withCollection($attendances, new AttendanceCalendarTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }

    public function getAllAttendancesByDate(Request $request)
    {
        try{
            $attendances = $this->attendanceService->getAllAttendancesByDate($request);
            return $this->apiResponse->withCollection($attendances, new AttendanceTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }


    public function getAttendanceDetails($attendance_id)
    {
        try{
            $attendances = $this->attendanceService->getAttendanceDetails($attendance_id);
            return $this->apiResponse->withItem($attendances, new AttendanceTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }

    public function getAllAttendancesByUser($user_id)
    {
        try{
            $attendances = $this->attendanceService->getUserWiseAttendance($user_id);
            return $this->apiResponse->withCollection($attendances, new AttendanceCalendarTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }


    public function getUserAttendanceByMonth(Request $request, $user_id)
    {
        try{
            $attendances = $this->attendanceService->getUserAttendanceByMonth($request, $user_id);
            return $this->apiResponse->withCollection($attendances, new AttendanceCalendarTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }


    public function getUserAttendanceStatisticsForToday()
    {
        try{
            return $attendances = $this->attendanceService->getUserAttendanceStatisticsForToday();
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }

    public function getTodayUserAttendancePercentage()
    {
        try{
            $attendances = $this->attendanceService->getTodayUserAttendancePercentage();
            return $this->apiResponse->withPaginator($attendances, new UserAttendancePercentageTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }

}
