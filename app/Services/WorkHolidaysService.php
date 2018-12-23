<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/5/18
 * Time: 8:19 PM
 */

namespace App\Services;


use App\Repositories\WorkHolidaysRepository;
use Carbon\Carbon;

class WorkHolidaysService extends BaseService
{
    /**
     * @var WorkHolidaysRepository
     */
    private $workHolidaysRepository;

    /**
     * WorkHolidaysService constructor.
     * @param WorkHolidaysRepository $workHolidaysRepository
     */
    public function __construct(WorkHolidaysRepository $workHolidaysRepository)
    {
        $this->workHolidaysRepository = $workHolidaysRepository;
    }


    /**
     * return Repository instance
     *
     * @return mixed
     */
    public function baseRepository()
    {
        return $this->workHolidaysRepository;
    }


    public function getAllHolidaysByMonth($request)
    {
        $role =  auth()->user()->roleUser->role->name;
        $date =  Carbon::parse($request->date)->format('m');

        $query = $this->workHolidaysRepository->getQuery()
            ->whereRaw('MONTH(date) = ?',[$date]);

        if($role == 'admin'){
            $attendance = $query->get();
        }else{
            $attendance = $query->where('holiday_for', auth()->user()->id)
                ->orWhere('holiday_for', 'ALL')
                ->orWhere('holiday_for', null)
                ->get();
        }
        return $attendance;
    }

    public function createHoliday($request)
    {
        $data = $request->only('date','occasion','background_color','text_color', 'holiday_for');
        $holiday = $this->workHolidaysRepository->create($data);
        return $holiday;
    }

    public function updateHoliday($request, $holiday_id)
    {
        $data = $request->only('occasion','background_color','text_color', 'holiday_for');
        $holiday = $this->workHolidaysRepository->update($data, $holiday_id);
        return $holiday;
    }

    public function getCurrentMonthHolidayCount()
    {
        $holidayCount = $this->workHolidaysRepository->getQuery()
            ->whereMonth('date', Carbon::now()->month)
            ->where(function($query) {
                $query->where('holiday_for', auth()->user()->id);
                $query->orWhere('holiday_for', 'ALL');
                $query->orWhere('holiday_for', null);
            })->count();

        return $holidayCount;
    }
}
