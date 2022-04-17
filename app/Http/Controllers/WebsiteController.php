<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return success_response('Available websites',Website::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated=(object)$request->validate([
            'name'=>'required',
            'url'=>'required|url'
        ]);
        $response=null;

        try {
            $website=Website::create([
                'name'=>$validated->name,
                'url'=>$validated->url
            ]);
            $response=success_response('Website created successfully',$website);
        }catch (\Throwable $e){
            $response=error_response('Something went wrong',$e->getMessage());
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website)
    {
        return success_response('Success',$website);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Website $website)
    {
        $validated=(object)$request->validate([
            'name'=>'required',
            'url'=>'required|url'
        ]);
        $response=null;

        try {
            $website->name=$validated->name;
            $website->url=$validated->url;
            $response=success_response('Website updated successfully',$website);
        }catch (\Throwable $e){
            $response=error_response('Something went wrong',$e->getMessage());
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function destroy(Website $website)
    {
        try{
            $website->delete();
            $response=success_response('Website deleted successfully');
        }catch (\Throwable $e){
            $response=error_response('Something went wrong',$e->getMessage());
        }
        return $response;
    }
}
