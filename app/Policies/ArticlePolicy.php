<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function view(?User $user, Article $article): bool
    {
        if ($article->status === 'pubblicato') {
            return true;
        }

        if (! $user) {
            return false;
        }

        return $user->hasRole('Admin', 'Revisor')
            || ($user->hasRole('Writer') && (int) $article->user_id === (int) $user->getKey());
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Writer');
    }

    public function update(User $user, Article $article): bool
    {
        return $user->hasRole('Writer')
            && (int) $article->user_id === (int) $user->getKey();
    }

    public function delete(User $user, Article $article): bool
    {
        return $this->update($user, $article);
    }
}