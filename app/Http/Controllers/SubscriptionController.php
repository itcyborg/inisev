<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return success_response('All subscriptions',Subscription::all());
    }

    public function createSubscription(Request $request)
    {
        $validated = (object) $request->validate([
            'subscription_user_id'=>'required|exists:subscription_users,id',
            'website_id'=>'required|exists:websites,id'
        ],[
            'subscription_user_id.exists'=>'The user does not exist',
            'website_id.exists'=>'The website does not exist',
        ]);

        try{
            // check if a subscription already exists
            $exists=Subscription::where('subscription_user_id',$validated->subscription_user_id)
                ->where('website_id',$validated->website_id)->exists();
            throw_if($exists,new \Exception('User already subscribed to website.'));

            $subscription=Subscription::create([
                'subscription_user_id'=>$validated->subscription_user_id,
                'website_id'=>$validated->website_id
            ]);
            $response=success_response('User successfully subscribed',$subscription);
        }catch (\Throwable $e){
            $response=error_response('Something went wrong',$e->getMessage());
        }
        return $response;
    }

    public function removeSubscription(Request $request)
    {
        $validated = (object) $request->validate([
            'subscription_user_id'=>'required',
            'website_id'=>'required'
        ]);

        try{
            // check if a subscription already exists
            $exists=Subscription::where('subscription_user_id',$validated->subscription_user_id)
                ->where('website_id',$validated->website_id)->exists();
            throw_if(!$exists,new \Exception('User subscription not found!.'));

            $subscription=Subscription::where('subscription_user_id',$validated->subscription_user_id)
                ->where('website_id',$validated->website_id)->forceDelete();
            $response=success_response('User subscription successfully removed',$subscription);
        }catch (\Throwable $e){
            $response=error_response('Something went wrong',$e->getMessage());
        }
        return $response;
    }
}
