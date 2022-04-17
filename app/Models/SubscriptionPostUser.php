<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPostUser extends Model
{
    use HasFactory;

    protected $fillable=[
        'subscription_user_id',
        'subscription_id',
        'post_id'
    ];
}
