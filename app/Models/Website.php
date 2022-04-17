<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Website extends Model
{
    use HasFactory,SoftDeletes;



    protected $fillable=[
        'name','url','status'
    ];

    protected $hidden=[
//        'id'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->uuid=Str::uuid();
        });
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
