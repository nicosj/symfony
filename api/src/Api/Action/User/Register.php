<?php
namespace App\Api\Action\User;

use App\Entity\User;
use App\Service\User\UserRegisterService;
use Symfony\Component\HttpFoundation\Request;

class Register
{
    private UserRegisterService $userRegisterService;

    public function __construct(UserRegisterService $data)
    {
        return $this->userRegisterService= $data;
    }

    public function __invoke(Request $request): User
    {
        return $this->userRegisterService->create($request);
    }


}
