<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/6/18
 * Time: 4:16 PM
 */

namespace App\Transformers\Api;


use App\Transformers\ApiTransformerAbstract;

class DropdownTransformer extends ApiTransformerAbstract
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
            'label' => ucfirst($entity->label),
            'value' => $entity->value
        ];
    }
}
