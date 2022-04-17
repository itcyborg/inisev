<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'subscription_user_id',
        'website_id',
        'isActive'
    ];


    protected static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->uuid=Str::uuid();
        });
    }

    public function sent_posts()
    {
        return $this->hasMany(SubscriptionPostUser::class);
    }

    public function user()
    {
        return $this->belongsTo(SubscriptionUser::class);
    }
}
