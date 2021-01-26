<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Cache;


class BlogPost extends Model
{
  use SoftDeletes,Taggable;
  use HasFactory;


    protected $fillable=['title','content','user_id'];
  
    public function comments(){
     
        return $this->morphMany('App\Models\comments','commentable')->Latest();
        
    }


    public function user(){
      return $this->belongsTo('App\Models\User');
    }


   

    public function image(){
      return $this->morphOne('App\Models\Image','imageable');
    }

 public function scopeLatest(Builder $query){
     return $query->orderBy(static::CREATED_AT,'desc');
 }

 public function scopeLatestWithRelations (Builder $query){
  return $query->latest()->withCount('comments')->with('user')->with('tags');
 }

 public function scopeMostCommented(Builder $query){
 return $query->withCount('comments')->OrderBy('comments_count','desc');
 }


    public static function boot(){
      
      static::addGlobalScope( new DeletedAdminScope);
      parent::boot();
       
        static::deleting(function(BlogPost $blogpost){
       //  dd('i was deleted');
             // $blogpost->image->delete();
             $blogpost->comments()->delete();

             Cache::tags(['blog-post'])->forget("blog-post-{$blogpost->id}");
        });
        static::updating(function(BlogPost $blogPost){
            Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        });

        static::restoring(function(BlogPost $blogpost){
              $blogpost->comments()->restore();
        });
    }
}
