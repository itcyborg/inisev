<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPostUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_post_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\SubscriptionUser::class);
            $table->foreignIdFor(\App\Models\Subscription::class);
            $table->foreignIdFor(\App\Models\Post::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_post_users');
    }
}
