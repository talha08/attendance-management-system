<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/5/18
 * Time: 8:21 PM
 */

namespace App\Services;


use App\Repositories\UserInfoRepository;

class UserInfoService extends BaseService
{
    /**
     * @var UserInfoRepository
     */
    private $userInfoRepository;

    /**
     * UserInfoService constructor.
     * @param UserInfoRepository $userInfoRepository
     */
    public function __construct(UserInfoRepository $userInfoRepository)
    {
        $this->userInfoRepository = $userInfoRepository;
    }


    /**
     * return Repository instance
     *
     * @return mixed
     */
    public function baseRepository()
    {
        return $this->userInfoRepository;
    }
}
