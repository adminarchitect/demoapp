<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    public $timestamps = false;

    protected $fillable = ['tag_id', 'article_id'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
