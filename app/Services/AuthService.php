<?php


namespace App\Services;


use App\Models\User;
use App\Repositories\UserRepository;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService extends BaseService
{
    protected $repository;

    public function __construct(UserRepository $userRepository){
        $this->repository = $userRepository;
    }
    public function login($data) : ServiceResult
    {
        $user = $this->repository->getUserByEmail($data['email']);
        if(is_null($user)){
            return $this->errValidate('Пользователь с таким email не существует');
        }
        if (! Hash::check($data['password'], $user->password)) {
            return $this->errValidate('Неверный пароль');
        }
        $token = $user->createToken($user->email)->plainTextToken;

        return $this->result([
            'token' => $token,
            'email' => $user->email,
            'user_id' => $user->id,
            'role_id' => $user->role_id,
        ]);
    }
    public function register($data) : ServiceResult
    {
        $data['password'] = Hash::make($data['password']);
        $data['role_id'] = User::MANAGER;
        $this->repository->store($data);
        return $this->ok('Менеджер зарегистрирован');
    }

    public function logout($user): ServiceResult
    {
        $user->currentAccessToken()->delete();
        return $this->ok('Пользователь разлогинен');
    }

    public function profile() : ServiceResult
    {
        return $this->result(Auth::user());
    }

}
