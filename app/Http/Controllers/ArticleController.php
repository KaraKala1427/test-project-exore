<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleIndexRequest;
use App\Http\Requests\ArticlePostRequest;
use App\Http\Requests\ArticlePutRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $service;
    public function __construct(ArticleService $articleService)
    {
        $this->service = $articleService;
    }

    public function store(ArticlePostRequest $request)
    {
        $model = $this->service->store($request->validated());
        return $this->result($model);
    }
    public function show($id)
    {
        $model = $this->service->get($id);
        return $this->resultResource(ArticleResource::class,$model);
    }

    //это POST запрос с параметром _method=PUT c postman-a в виде form-data
    public function update(ArticlePutRequest $request, $id)
    {
        $model = $this->service->update($request->validated(), $id);
        return $this->result($model);
    }
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $model =  $this->service->destroy($article);
        return $this->result($model);
    }
}
