<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/5/18
 * Time: 8:21 PM
 */

namespace App\Repositories;


use App\Models\UserInfo;

class UserInfoRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return UserInfo::class;
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
