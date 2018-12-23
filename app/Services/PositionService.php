<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/25/18
 * Time: 7:35 PM
 */

namespace App\Services;


use App\BaseSettings\AppSettings;
use App\Repositories\PositionRepository;

class PositionService extends BaseService
{
    /**
     * @var PositionRepository
     */
    private $positionRepository;

    /**
     * PositionService constructor.
     * @param PositionRepository $positionRepository
     */
    public function __construct(PositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }


    /**
     * return Repository instance
     *
     * @return mixed
     */
    public function baseRepository()
    {
        return $this->positionRepository;
    }


    public function getPositionDropdown()
    {
        return $this->positionRepository->getQuery()
            ->select('id as value', 'position as label')
            ->get();
    }


    public function getAllPositions()
    {
        return $this->positionRepository->getQuery()->paginate(AppSettings::$paginate);
    }


    public function createNewPosition($request)
    {
        $data = $request->only('position','work_hour_per_day');
        $position = $this->positionRepository->create($data);
        return $position;
    }



    public function updatePosition($request, $id)
    {
        $data = $request->only('position','work_hour_per_day');
        $position = $this->positionRepository->update($data, $id);
        return $position;
    }
}
