<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubscriptionUser extends Model
{
    use HasFactory;

    protected $fillable=[
        'name','email','active'
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
}
