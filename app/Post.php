<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
	 use Searchable;

    protected  $fillable = ['user_id', 'category_id','title', 'post_slug', 'content', 'thumbnail', 'status'];
    const PUBLISHED_POST = 'published';

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id','category_name','category_slug','status');

    }
    public function user(){
        return $this->belongsTo(User::class)->select('id','name');
    }
     public function votes(){
    	
    	return $this->hasMany(Vote::class);
    }
     public function searchableAs()
    {
        return 'title';
    }

    /* public function toSearchableArray()
    {
        $array = $this->toArray();

       $array['category']  = $this->category['name'];

        return $array;
    }*/

}
