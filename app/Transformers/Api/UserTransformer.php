<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 8/11/18
 * Time: 5:44 PM
 */

namespace App\Transformers\Api;
use App\Models\RoleUser;
use App\Transformers\Api\Attendance\AttendanceTransformer;
use App\Transformers\ApiTransformerAbstract;
use Carbon\Carbon;

class UserTransformer extends ApiTransformerAbstract
{
    protected $availableIncludes = [ 'attendances', 'baseSalary','baseSalaries' ,'role'];

    protected $defaultIncludes = ['userInfo'];

    public function getTransformableFields($entity)
    {
        $userRole = RoleUser::where('user_id', $entity->id)->first();
        return [
            'id' => (int)$entity->id,
            'name' => $entity->name,
            'email' => $entity->email,
            'created_at' =>  Carbon::parse($entity->created_at)->diffForHumans(),
            'role' => $userRole->role->name
        ];
    }

    public function includeUserInfo($entity)
    {
        $userInfo = $entity->userInfo;
        return $userInfo ?  $this->item($userInfo, new UserInfoTransformer()) : $this->null();
    }

    public function includeAttendances($entity)
    {
        $attendances = $entity->attendances;
        return $attendances ? $this->collection($attendances, new AttendanceTransformer()) : $this->null();
    }

    public function includeBaseSalaries($entity)
    {
        $baseSalaries = $entity->baseSalaries;
        return $this->collection($baseSalaries, new BaseSalaryTransformer());
    }

    public function includeBaseSalary($entity)
    {
        $baseSalary = $entity->baseSalary;
        return $baseSalary ? $this->item($baseSalary, new BaseSalaryTransformer()) : $this->null();
    }

    public function includeRole($entity)
    {
        $roleUser = $entity->roleUser;
        return $this->item($roleUser, new RoleTransformer());
    }

}
