<?php

namespace App\Http\Terranet\Administrator\Presenters;

use Terranet\Presentable\Presenter;

class ArticlePresenter extends Presenter
{
    public function adminUserId()
    {
        $user = $this->presentable->user;

        return link_to_route('scaffold.view', $user->name, ['module' => 'users', 'id' => $user->id]);
    }
}