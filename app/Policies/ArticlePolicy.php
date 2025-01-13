<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class ArticlePolicy
{
    public function edit(User $user, Article $article){
        Log::info($article->user);
        Log::info($user);
        return $article->user->is($user);
    }
}
