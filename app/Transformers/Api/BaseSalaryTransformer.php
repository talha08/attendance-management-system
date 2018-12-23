<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/6/18
 * Time: 2:43 PM
 */

namespace App\Transformers\Api;


use App\Transformers\ApiTransformerAbstract;

class BaseSalaryTransformer extends ApiTransformerAbstract
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
            'salary' => $entity->salary,
            'start' => $entity->start_date,
            'end' => $entity->end_date ? $entity->end_date : 'Current',
        ];
    }

    public function includeUser($entity)
    {
        $user = $entity->user;
        return $this->item($user, new UserTransformer());
    }
}
