<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;



    protected $fillable=[
        'title','content','website_id'
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

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
