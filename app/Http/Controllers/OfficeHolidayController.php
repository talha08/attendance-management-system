<?php

namespace App\Http\Controllers;

use App\Responses\ApiResponse;
use App\Services\WorkHolidaysService;
use App\Transformers\Api\WorkHolidayTransformer;
use Illuminate\Http\Request;

class OfficeHolidayController extends Controller
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var WorkHolidaysService
     */
    private $workHolidaysService;

    /**
     * OfficeHolidayController constructor.
     * @param ApiResponse $apiResponse
     * @param WorkHolidaysService $workHolidaysService
     */
    public function __construct(ApiResponse $apiResponse, WorkHolidaysService $workHolidaysService)
    {
        $this->apiResponse = $apiResponse;
        $this->workHolidaysService = $workHolidaysService;
    }

    public function getAllHolidaysByMonth(Request $request)
    {
        try{
            $holidays = $this->workHolidaysService->getAllHolidaysByMonth($request);
            return $this->apiResponse->withCollection($holidays, new WorkHolidayTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }


    public function createHoliday(Request $request)
    {
        try{
            $holiday = $this->workHolidaysService->createHoliday($request);
            return $this->apiResponse->withItem($holiday, new WorkHolidayTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }


    public function updateHoliday(Request $request, $holiday_id)
    {
        try{
            $holiday = $this->workHolidaysService->updateHoliday($request, $holiday_id);
            return $this->apiResponse->withItem($holiday, new WorkHolidayTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }


    public function deleteHoliday($id)
    {
        try{
            $holiday = $this->workHolidaysService->delete($id);
            return $this->apiResponse->success('Successfully Deleted');
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }

}
