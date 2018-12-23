<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/6/18
 * Time: 2:43 PM
 */

namespace App\Transformers\Api\Attendance;


use App\Models\Attendance;
use App\Transformers\Api\UserTransformer;
use App\Transformers\ApiTransformerAbstract;
use Carbon\Carbon;

class AttendanceTransformer extends  ApiTransformerAbstract
{

    protected $availableIncludes = ['user'];
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
            'id' => (int)$entity->id,
            'user_id' => $entity->user_id,
            'work_date' => $entity->work_date,
            'entry_time' => $entity->entry_time,
            'finish_time' => $entity->finish_time,
            'status' => $entity->status,
            'total_worked_time' => gmdate('H:i', Attendance::getTotalWorkTime($entity))
        ];
    }




    public function includeUser($entity)
    {
        $user = $entity->user;
        return $this->item($user, new UserTransformer());
    }

}
