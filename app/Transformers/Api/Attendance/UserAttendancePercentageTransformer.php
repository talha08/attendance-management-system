<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/23/18
 * Time: 11:44 AM
 */

namespace App\Transformers\Api\Attendance;


use App\Models\Attendance;
use App\Transformers\ApiTransformerAbstract;
use Carbon\Carbon;

class UserAttendancePercentageTransformer extends ApiTransformerAbstract
{

    /**
     * Get the fields to be transformed.
     *
     * @param $entity
     *
     * @return mixed
     */
    public function getTransformableFields($entity)
    {
        return [
            'user_id' => (int)$entity->id,
            'photo' => $entity->userInfo->photo ?? '/images/user.svg',
            'name' => $entity->name,
            'email' => $entity->email,
            'work_date' => $entity->todayAttendance ? $entity->todayAttendance->work_date : null,
            'entry_time' =>$entity->todayAttendance ? $entity->todayAttendance->entry_time: null,
            'status' => $entity->todayAttendance ? $entity->todayAttendance->status: 'inactive',
            'total_worked_time' => $entity->todayAttendance ?
                gmdate('H:i', Attendance::getTotalWorkTime($entity->todayAttendance)):
                '00:00',
        ];
    }

}
