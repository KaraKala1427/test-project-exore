<?php


namespace App\Services;


use App\Models\User;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Integer;

class ArticleService extends BaseService
{
    protected $repository;
    protected $imageService;

    public function __construct(ArticleRepository $characterRepository, ImageService $imageService)
    {
        $this->repository = $characterRepository;
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

    public function get($id) : ServiceResult
    {
        $model = $this->repository->get($id);

        if(is_null($model)) {
            return $this->errNotFound('Запись не найден');
        }
        return $this->result($model);
    }


    public function store($data) : ServiceResult
    {
        $image = $this->imageService->store($data['image']);
        $data['image_id'] = $image->id;
        $data['user_id'] = Auth::user()->id;
        $this->repository->store($data);
        return $this->ok('Запись сохранен');

    }

    public function update($data, $id)
    {
        $model = $this->repository->get($id);
        if(is_null($model)) {
            return $this->errNotFound('Запись не найден');
        }
        $this->repository->update($id,$data);
        return $this->ok('Запись обновлен');
    }

    public function destroy($article)
    {
        $this->repository->destroy($article);
        return $this->ok('запись удален');
    }

}
