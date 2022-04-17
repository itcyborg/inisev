<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\SubscriptionPostUser;
use App\Notifications\NewStoryPosted;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSubscriptionPostsToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users)
    {
        $this->users=$users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->users as $user) {
            //get all user subscriptions
            $subscriptions=$user->subscriptions;
            if($subscriptions){
                foreach ($subscriptions as $subscription) {
                    // foreach subscription find unsent posts
                    $sent=$subscription->sent_posts;
                    $unsent=Post::where('website_id',$subscription->website_id)->whereNotIn('id',$sent->pluck('id'))->get();
                    foreach ($unsent as $story) {
                        $user->notify(new NewStoryPosted($story));
                        // mark story as sent
                        SubscriptionPostUser::create([
                            'subscription_user_id'=>$user->id,
                            'subscription_id'=>$subscription->id,
                            'post_id'=>$story->id
                        ]);
                    }
                }
            }
        }
    }
}
