<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/6/18
 * Time: 2:42 PM
 */

namespace App\Transformers\Api;


use App\Transformers\ApiTransformerAbstract;

class UserInfoTransformer extends ApiTransformerAbstract
{


    protected $availableIncludes = ['user','position'];
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
            'position' => $entity->position,
            'phone' => $entity->phone,
            'photo' => $entity->photo ?? "/images/user.svg",
        ];
    }

    public function includeUser($entity)
    {
        $user = $entity->user;
        return $this->item($user, new UserTransformer());
    }

    public function includePosition($entity)
    {
        $position = $entity->position;
        return $this->item($position, new PositionTransformer());
    }
}
