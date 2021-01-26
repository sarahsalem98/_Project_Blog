<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        ' email_verified_at',
        'email',
        'created_at',
        'updated_at',
        'is_admin'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

public function blogPosts(){
    return $this->hasMany('App\Models\BlogPost');
}

public function comments(){
    return $this->hasMany('App\Models\comments');
}

public function commentsOn(){
     
    return $this->morphMany('App\Models\comments','commentable')->Latest();
    
}

public function image(){
    return $this->morphOne('App\Models\Image','imageable');
  }


public function scopeWithMostBlogPosts(Builder $query){
return $query->withCount('blogPosts')->orderBy('blog_Posts_count','desc');
}
public function scopewithMostBlogPostsLastMonth(Builder $query){
    return $query->withCount(['blogPosts'=>function(Builder $query){
        $query->whereBetween(static::CREATED_AT,[now()->subMonths(1),now()]);

    }])->having('blog_Posts_count','>=',2)->orderBy('blog_Posts_count','desc');
}


}
