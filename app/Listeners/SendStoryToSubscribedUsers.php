<?php

namespace App\Listeners;

use App\Models\Post;
use App\Models\Subscription;
use App\Models\SubscriptionPostUser;
use App\Models\SubscriptionUser;
use App\Models\User;
use App\Notifications\NewStoryPosted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendStoryToSubscribedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $subscriptions=$event->story->website->subscriptions;
        if($subscriptions){
            foreach ($subscriptions as $subscription) {
                // foreach subscription find unsent posts
                $sent=$subscription->sent_posts;
                $unsent=Post::where('website_id',$subscription->website_id)->whereNotIn('id',$sent->pluck('id'))->get();
                foreach ($unsent as $story) {
                    $user=SubscriptionUser::find($subscription->subscription_user_id);
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
