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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }

    public function createSubscription(Request $request)
    {
        $validated = (object) $request->validate([
            'subscription_user_id'=>'required',
            'website_id'=>'required'
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
