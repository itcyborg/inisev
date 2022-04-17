<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class SubscriptionUser extends Model
{
    use HasFactory,Notifiable;

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

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
