<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ArticlePolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Article $article)
    {
        return $user->id === $article->user_id || ($user->role_id === User::MANAGER && $user->id == $article->user->manager->id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id || ($user->role_id === User::MANAGER && $user->id == $article->user->manager->id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Article $article)
    {
        return $user->id === $article->user_id || ($user->role_id === User::MANAGER && $user->id == $article->user->manager->id);
    }

}
