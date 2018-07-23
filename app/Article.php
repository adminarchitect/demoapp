<?php

namespace App;

use App\Http\Terranet\Administrator\Presenters\ArticlePresenter;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Terranet\Presentable\PresentableInterface;
use Terranet\Presentable\PresentableTrait;

class Article extends Model implements PresentableInterface
{
    use Sluggable, PresentableTrait;

    protected $fillable = ['title', 'body', 'user_id', 'draft'];

    protected $presenter = ArticlePresenter::class;

    protected $with = ['user', 'tags'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tags');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->whereDraft(false);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDraft($query)
    {
        return $query->whereDraft(true);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => ['source' => 'title'],
        ];
    }
}
