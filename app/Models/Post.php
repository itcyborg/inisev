<?php

namespace App\Models;

use App\Events\NewPostCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;



    protected $fillable=[
        'title','content','website_id','slug'
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

        self::created(function($model){
            NewPostCreated::dispatch($model);
        });
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
