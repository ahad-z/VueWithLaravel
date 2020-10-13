<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected  $fillable = ['user_id', 'category_id','title', 'post_slug', 'content', 'thumbnail', 'status'];
    const PUBLISHED_POST = 'published';

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id','category_name','category_slug','status');

    }
    public function user(){
        return $this->belongsTo(User::class)->select('id','name');
    }
}
