<?php


namespace App\Services;


use App\Models\User;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Integer;

class UserService extends BaseService
{
    protected $repository;
    protected $imageService;

    public function __construct(UserRepository $userRepository, ImageService $imageService)
    {
        $this->repository = $userRepository;
        $this->imageService = $imageService;
    }

    /**
     * список с пагинацией
     */
    public function indexPaginate($params) : ServiceResult
    {
        $collection = $this->repository->indexPaginate($params);
        return $this->result($collection);
    }
    /**
     * пользователь
     */
    public function get($id) : ServiceResult
    {
        $model = $this->repository->get($id);

        if(is_null($model)) {
            return $this->errNotFound('пользователь не найден');
        }
        return $this->result($model);
    }
    /**
     * Сохранить пользователя
     */
    public function store($data) : ServiceResult
    {
        $data['role_id'] = User::EMPLOYEE;
        $data['password'] = Hash::make($data['password']);
        $data['manager_id'] = Auth::user()->id;
        $this->repository->store($data);
        return $this->ok('сотрудник сохранен');

    }


    /**
     * Удалить пользователя
     */
    public function destroy($user)
    {
        $this->repository->destroy($user);
        return $this->ok('пользователь удален');
    }

    public function indexArticlePaginate($params) : ServiceResult
    {
        $userId = Auth::user()->id;
        $user = $this->repository->get($userId);
        $articleRepository = new ArticleRepository();

        if(Auth::user()->role_id != User::MANAGER) $query = $user->articles();
        else $query = $user->articlesOfEmployees();

        return $this->result($articleRepository->indexPaginate($params, $query));
    }
}
