<?php

namespace App;

use App\Http\Terranet\Administrator\Presenters\UserPresenter;
use Czim\Paperclip\Contracts\AttachableInterface;
use Czim\Paperclip\Model\PaperclipTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Terranet\Presentable\PresentableInterface;
use Terranet\Presentable\PresentableTrait;

class User extends Authenticatable implements AttachableInterface, PresentableInterface
{
    use PaperclipTrait, PresentableTrait;

    use Notifiable;

    protected $presenter = UserPresenter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'phone', 'web_site', 'is_active', 'photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('photo', [
            'variants' => [
                'large' => [
                    'auto-orient' => [],
                    'resize' => ['dimensions' => '800x800'],
                ],
                'medium' => '300x300',
                'small' => '100x100',
            ],
            'attributes' => [
                'variants' => true,
            ],
        ]);

        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->whereIsActive(true);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeLocked($query)
    {
        return $query->whereIsActive(false);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWithoutArticles($query)
    {
        return $query->has('articles', '=', 0);
    }
}
