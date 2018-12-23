<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/1/18
 * Time: 1:08 PM
 */

namespace App\Services;


use App\Models\RoleUser;
use App\Repositories\RoleUserRepository;
use App\Responses\ApiResponse;

class RoleUserService extends BaseService
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var RoleUserRepository
     */
    private $roleUserRepository;

    /**
     * RoleUserService constructor.
     * @param ApiResponse $apiResponse
     * @param RoleUserRepository $roleUserRepository
     */
    public function __construct(ApiResponse $apiResponse, RoleUserRepository $roleUserRepository)
    {
        $this->apiResponse = $apiResponse;
        $this->roleUserRepository = $roleUserRepository;
    }


    /**
     * return Repository instance
     *
     * @return mixed
     */
    public function baseRepository()
    {
        // TODO: Implement baseRepository() method.
    }
}
