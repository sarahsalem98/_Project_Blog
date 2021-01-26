<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use App\Models\BlogPost;
use App\Traits\Taggable;

class comments extends Model
{
    use SoftDeletes ,Taggable;
    use HasFactory;
    protected $fillable=['content','user_id'];
    protected $hidden=['deleted_at','commentable_type','commentable_id','user_id'];
     

  public function commentable(){
      return $this->morphTo();
  }

    public function user(){
        return $this->belongsTo('App\Models\User');
      }
  
    public function scopeLatest(Builder $query){
        return $query->orderBy(static::CREATED_AT,'desc');
    }
    

    // public function tags(){
       
    //     return $this->morphToMany('App\Models\Tag','taggable')->withTimestamps();
    //   }
    public static function boot(){
        parent::boot();
        //static::addGlobalScope( new LatestScope);
        static::creating(function(comments $comment){
            if($comment->commentable_type===BlogPost::class){
                Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}");
                Cache::tags(['blog-post'])->forget("mostCommented");
            }
        
        });
      
 
    }
}
