<?php

namespace App\Http\Terranet\Administrator\Presenters;

use Terranet\Presentable\Presenter;

class UserPresenter extends Presenter
{
    /**
     * Decorate email using provided argument.
     *
     * @param $email
     * @return string
     */
    public function adminEmail($email)
    {
        return '<a href="mailto:'.$email.'" target="_blank">'.$email.'</a>';
    }

    /**
     * Decorate phone using Presentable object.
     *
     * @return string
     */
    public function adminPhone()
    {
        return '<a href="tel:'.$this->presentable->phone.'" target="_blank">'.$this->presentable->phone.'</a>';
    }

    public function adminWebSite($url)
    {
        return '<a href="'.$url.'" target="_blank">'.$url.'</a>';
    }
}