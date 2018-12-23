<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/5/18
 * Time: 8:20 PM
 */

namespace App\Repositories;


use App\Models\WorkHolidays;

class WorkHolidaysRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return WorkHolidays::class;
    }

    /**
     * Filter data based on user input
     *
     * @param array $filter
     * @param       $query
     */
    public function filterData(array $filter, $query)
    {
        // TODO: Implement filterData() method.
    }
}
