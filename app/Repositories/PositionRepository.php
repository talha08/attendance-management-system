<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/25/18
 * Time: 7:36 PM
 */

namespace App\Repositories;


use App\Models\Position;

class PositionRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
       return Position::class;
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
