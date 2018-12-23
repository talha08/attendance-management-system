<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/6/18
 * Time: 2:43 PM
 */

namespace App\Transformers\Api;


use App\Transformers\ApiTransformerAbstract;

class WorkHolidayTransformer extends ApiTransformerAbstract
{

    public function backgroundColor($color, $occasion)
    {
        if($color){
            return $color;
        }else{
            if($occasion == 'Office Holiday') return 'red';
            else return 'blue';
        }
    }

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
            'holiday_id' => (int)$entity->id,
            'start' => $entity->date,
            'allDay' => true,
            'color' => $this->backgroundColor($entity->background_color, $entity->occasion),
            'textColor' => $entity->text_color ? $entity->text_color :'white',
            'holiday_for' => $entity->holiday_for
                ? ($entity->holiday_for != 'ALL' ? $entity->user->name : 'ALL')
                : 'ALL',
            'title' => $entity->holiday_for != 'ALL' ? $entity->user->name.' : '.$entity->occasion : $entity->occasion,
            'original_title' => $entity->occasion
        ];
    }
}
