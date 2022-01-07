<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserReqisterRequest;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    private $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }
    public function login(UserLoginRequest $request)
    {
        return $this->result($this->service->login($request->validated()));
    }

    public function register(UserReqisterRequest $request)
    {
        return $this->result($this->service->register($request->validated()));
    }
    public function logout(Request $request)
    {
        return $this->result($this->service->logout($request->user()));
    }
}
