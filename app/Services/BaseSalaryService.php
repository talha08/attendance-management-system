<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/1/18
 * Time: 1:18 PM
 */

namespace App\Services;


use App\BaseSettings\AppSettings;
use App\Repositories\BaseSalaryRepository;
use App\Responses\ApiResponse;
use Carbon\Carbon;

class BaseSalaryService extends BaseService
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var BaseSalaryRepository
     */
    private $baseSalaryRepository;

    /**
     * BaseSalaryService constructor.
     * @param ApiResponse $apiResponse
     * @param BaseSalaryRepository $baseSalaryRepository
     */
    public function __construct(ApiResponse $apiResponse, BaseSalaryRepository $baseSalaryRepository)
    {
        $this->apiResponse = $apiResponse;
        $this->baseSalaryRepository = $baseSalaryRepository;
    }


    /**
     * return Repository instance
     *
     * @return mixed
     */
    public function baseRepository()
    {
        return $this->baseSalaryRepository;
    }



    public function updateBaseSalary($request, $id)
    {
        $data = $request->only('user_id','salary','start_date', 'end_date');
        $salary = $this->baseSalaryRepository->update($data, $id);
        return $salary;
    }



    public function createNewSalary($request)
    {
        $data = $request->only('user_id','salary','start_date');
        $salary = $this->baseSalaryRepository->create($data);
        return $salary;
    }


    public function updateUserOtherSalary($request)
    {
        $salaries = $this->baseSalaryRepository->getQuery()
            ->where('user_id', $request->user_id)
            ->where('end_date', '=', null)
            ->get();
        foreach ($salaries as $salary){
            $salary->update(['end_date' => Carbon::now()]);
        }
    }
}
