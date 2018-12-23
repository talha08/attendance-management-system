<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/1/18
 * Time: 1:09 PM
 */

namespace App\Repositories;


use App\Models\RoleUser;

class RoleUserRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return RoleUser::class;
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


    public function userRoleUpdate($user_id, $role_id)
    {
       $roleUser = $this->model->where('user_id',$user_id)->first();
       $roleUser->update(['role_id' => $role_id]);
    }

}
