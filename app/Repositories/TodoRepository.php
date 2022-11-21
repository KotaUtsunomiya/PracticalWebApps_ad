<?php

namespace App\Repositories;

use App\User;

class TodoRepository
{
    /**
     * 指定ユーザーの全タスク取得
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return $user->todos()
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}