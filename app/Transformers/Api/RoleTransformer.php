<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/6/18
 * Time: 2:42 PM
 */

namespace App\Transformers\Api;


use App\Transformers\ApiTransformerAbstract;

class RoleTransformer extends ApiTransformerAbstract
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
            'name' => $entity->name,
        ];
    }
}
