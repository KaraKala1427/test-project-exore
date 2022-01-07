<?php


namespace App\Repositories;


use App\Models\Character;
use App\Models\Image;
use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ArticleRepository
{
    public function indexPaginate($params, $query = null) : LengthAwarePaginator
    {
        $perPage = $params['per_page'] ?? 10;
        return $this->prepareQuery($params, $query)->paginate($perPage);
    }
    public function index($params): Collection
    {
        return $this->prepareQuery($params)->get();
    }

    private function prepareQuery($params, $query = null)
    {
        if(!$query){
            $query = Article::select('*');
        }
        $query = $query->with(['image']);
        $query = $this->queryApplyFilter($query,$params);
        return $query;
    }

    private function queryApplyFilter($query,$params)
    {
        if(isset($params['title'])){
            $query->where(function ($subQuery) use ($params){
                $subQuery->where('title','LIKE',"%{$params['title']}%");
            });
        }
        if(isset($params['category_id'])){
            $query->where('category_id',$params['category_id']);
        }
        return $query;
    }

    public function get(int $id) : ?Article
    {
        return Article::find($id);
    }

    public function store($data)
    {
        return Article::Create($data);
    }

    public function update($id, $data)
    {
        return $this->get($id)->update($data);
    }

    public function destroy($model)
    {
        return $model->delete();
    }

}
