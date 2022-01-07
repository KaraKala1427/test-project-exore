<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleIndexRequest;
use App\Http\Requests\UserPostRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\UserProfileResource;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $userService;
    protected $authService;
    public function __construct(UserService $userService , AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    public function store(UserPostRequest $request)
    {
        $model = $this->userService->store($request->validated());
        return $this->result($model);
    }


    public function getArticles(ArticleIndexRequest $request)
    {
        $characters = $this->userService->indexArticlePaginate($request->validated());
        return $this->resultCollection(ArticleCollection::class,$characters);
    }

    public function profile()
    {
        $model = $this->authService->profile();
        return $this->resultResource(UserProfileResource::class, $model);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $model =  $this->userService->destroy($user);
        return $this->result($model);
    }
}
