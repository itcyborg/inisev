<?php

namespace App\Console\Commands;

use App\Jobs\SendSubscriptionPostsToUsers;
use App\Models\SubscriptionUser;
use Illuminate\Console\Command;

class SendSubscriptionPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email stories to users who are subscribed to websites';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SendSubscriptionPostsToUsers::dispatch(SubscriptionUser::with(['subscriptions','subscriptions.sent_posts'])->get());
        return 0;
    }
}
