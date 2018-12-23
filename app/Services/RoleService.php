<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 11/1/18
 * Time: 1:06 PM
 */

namespace App\Services;


use App\Repositories\RoleRepository;
use App\Repositories\RoleUserRepository;
use App\Responses\ApiResponse;

class RoleService extends BaseService
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var RoleUserRepository
     */
    private $roleUserRepository;

    /**
     * RoleService constructor.
     * @param ApiResponse $apiResponse
     * @param RoleRepository $roleRepository
     * @param RoleUserRepository $roleUserRepository
     */
    public function __construct(ApiResponse $apiResponse, RoleRepository $roleRepository, RoleUserRepository $roleUserRepository)
    {
        $this->apiResponse = $apiResponse;
        $this->roleRepository = $roleRepository;
        $this->roleUserRepository = $roleUserRepository;
    }


    /**
     * return Repository instance
     *
     * @return mixed
     */
    public function baseRepository()
    {
        return $this->roleRepository;
    }

    public function getRolesDropdown()
    {
        return $this->roleRepository->getQuery()
            ->select('name as value', 'name as label')
            ->get();
    }

    public function userRoleUpdate($request)
    {
        return $this->roleUserRepository->userRoleUpdate($request->user_id, $request->role_id);
    }
}
