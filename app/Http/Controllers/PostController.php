<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Throwable;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return success_response('Available posts',Post::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated=(object) $request->validate([
            'title'=>'required',
            'content'=>'required',
            'website_id'=>'required|numeric|exists:websites,id',
            'slug'=>'required|unique:posts,slug'
        ]);

        try {
            // find the website
            $website=Website::find($validated->website_id);
            $post=$website->posts()->create([
                'title'=>$validated->title,
                'content'=>$validated->content,
                'slug'  =>  Str::slug($validated->slug)
            ]);

            $response=success_response('Post added successfully',$post);
        }catch (Throwable $e){
            $response=error_response('Something went wrong',$e);
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return JsonResponse|Response
     */
    public function show(Post $post)
    {
        return success_response('Success',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function update(Request $request, Post $post)
    {
        $validated=(object) $request->validate([
            'title'=>'required',
            'content'=>'required',
            'slug'=>'required'
        ]);

        try {
            $post->title=$validated->title;
            $post->content=$validated->content;
            $post->slug=$validated->slug;
            $post->save();

            $response=success_response('Post updated successfully',$post);
        }catch (\Throwable $e){
            $response=error_response('Something went wrong',$e);
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return Response
     */
    public function destroy(Post $post)
    {
        try{
            $post->delete();
            $response=success_response('Post deleted successfully');
        }catch (\Throwable $e){
            $response=error_response('Something went wrong');
        }
        return $response;
    }
}
