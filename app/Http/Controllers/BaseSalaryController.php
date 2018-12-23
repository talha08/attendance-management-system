<?php

namespace App\Http\Controllers;

use App\Responses\ApiResponse;
use App\Services\BaseSalaryService;
use App\Transformers\Api\BaseSalaryTransformer;
use Illuminate\Http\Request;

class BaseSalaryController extends Controller
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var BaseSalaryService
     */
    private $baseSalaryService;

    /**
     * BaseSalaryController constructor.
     * @param ApiResponse $apiResponse
     * @param BaseSalaryService $baseSalaryService
     */
    public function __construct(ApiResponse $apiResponse, BaseSalaryService $baseSalaryService)
    {
        $this->apiResponse = $apiResponse;
        $this->baseSalaryService = $baseSalaryService;
    }




    public function updateBaseSalary(Request $request, $id)
    {
        try{
            $salary = $this->baseSalaryService->updateBaseSalary($request, $id);
            return $this->apiResponse->withItem($salary, new BaseSalaryTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }

    public function createNewSalary(Request $request)
    {
        try{
            $this->baseSalaryService->updateUserOtherSalary($request);
            $salary = $this->baseSalaryService->createNewSalary($request);
            return $this->apiResponse->withItem($salary, new BaseSalaryTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }

    public function deleteSalary($id)
    {
        try{
            $holiday = $this->baseSalaryService->delete($id);
            return $this->apiResponse->success('Successfully Deleted');
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }
}
