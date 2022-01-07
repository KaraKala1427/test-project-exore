<?php


namespace App\Repositories;


use App\Models\Character;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class UserRepository
{
    public function indexPaginate($params, $query = null) : LengthAwarePaginator
    {
        $perPage = $params['per_page'] ?? 4;
        return $this->prepareQuery($params, $query)->paginate($perPage);
    }
    public function index($params): Collection
    {
        return $this->prepareQuery($params)->get();
    }

    private function prepareQuery($params, $query = null)
    {
        if(!$query){
            $query = User::select('*');
        }
        $query = $query->with(['image']);
        return $query;
    }

    public function get(int $id) : ?User
    {
        return User::find($id);
    }

    public function store($data)
    {
        return User::Create($data);
    }

    public function destroy($model)
    {
        return $model->delete();
    }

    public function getUserByEmail($email)
    {
        return User::where('email',$email)->first();
    }

}
