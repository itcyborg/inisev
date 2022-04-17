<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionUser;
use Illuminate\Http\Request;

class SubscriptionUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        return success_response('Available subscription users',SubscriptionUser::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated= (object) $request->validate([
            'name'  =>  'required',
            'email' =>  'required|email:rfc|unique:subscription_users,email'
        ]);
        $response=null;

        try {
            $user=SubscriptionUser::create([
                'name'  =>  $validated->name,
                'email' =>  $validated->email
            ]);
            $response = success_response('Subscription User created successfully',$user);
        }catch (\Throwable $e){
            $response = error_response('An error occurred',$e->getMessage());
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubscriptionUser  $subscriptionUser
     * @return \Illuminate\Http\Response
     */
    public function show(SubscriptionUser $subscriptionUser)
    {
        return success_response('Subscription user found',$subscriptionUser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubscriptionUser  $subscriptionUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubscriptionUser $subscriptionUser)
    {
        $validated= (object) $request->validate([
            'name'  =>  'required',
            'email' =>  'required|email:rfc'
        ]);
        $response=null;

        try {
            $subscriptionUser->name=$validated->name;
            $subscriptionUser->email=$validated->email;
            $subscriptionUser->save();
            $response = success_response('Subscription User updated successfully',$subscriptionUser);
        }catch (\Throwable $e){
            $response = error_response('An error occurred',$e->getMessage());
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubscriptionUser  $subscriptionUser
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SubscriptionUser $subscriptionUser)
    {
        try{
            $subscriptionUser->forceDelete();
            return success_response('Subscription user deleted successfully');
        }catch (\Throwable $e){
            return error_response('Something went wrong',$e->getMessage());
        }
    }
}
