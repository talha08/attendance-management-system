<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/22/18
 * Time: 11:35 PM
 */

namespace App\Transformers\Api\Attendance;


use App\Models\Attendance;
use App\Transformers\Api\UserTransformer;
use App\Transformers\ApiTransformerAbstract;
use Carbon\Carbon;

class AttendanceCalendarTransformer extends ApiTransformerAbstract
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
            'attendance_id' => (int)$entity->id,
            'start' => $entity->work_date,
            'allDay' => true,
            'color' => 'yellow',
            'textColor' => 'black',
            'title' =>   gmdate('H:i', Attendance::getTotalWorkTime($entity)). '-'. $entity->user->name
        ];
    }

    public function includeUser($entity)
    {
        $user = $entity->user;
        return $this->item($user, new UserTransformer());
    }

}
