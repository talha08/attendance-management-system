<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/25/18
 * Time: 9:04 PM
 */

namespace App\Transformers\Api;


use App\Transformers\ApiTransformerAbstract;

class PositionTransformer extends ApiTransformerAbstract
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
            'id' => (int)$entity->id,
            'position_name' => $entity->position,
            'work_hour_per_day' => $entity->work_hour_per_day,
        ];
    }
}
