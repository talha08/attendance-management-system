<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/1/18
 * Time: 1:16 PM
 */

namespace App\Repositories;


use App\Models\Attendance;

class AttendanceRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
       return Attendance::class;
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
