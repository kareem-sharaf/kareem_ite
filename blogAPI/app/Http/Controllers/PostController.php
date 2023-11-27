<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Post as PostResource;

class PostController extends BaseController
{

    public function index()
    {
        $post=Post::all();
        return $this->sendResponse(PostResource::collection($post),'posts retrieved successfuly');
    }




    public function userPosts($id)
    {
        $post=Post::where('user_id',$id)->get();
        return $this->sendResponse(PostResource::collection($post),'posts retrieved successfuly');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'title'=>'required',
            'description'=>'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validate Error',$validator->errors() );
        }

        $user = Auth::user();
        $input['user_id']=$user->id;
        $post=Post::create($input);
        return $this->sendResponse($post, 'post added Successfully!' );
    }




    public function show($id)
    {
        $post=Post::find($id);
        if (is_null($post)) {
            return $this->sendError('post not found');
        }
        return $this->sendResponse(new PostResource($post),'post retrived successfuly');
    }





    public function update(Request $request, Post $post)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'title'=>'required',
            'description'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error',$validator->errors());
        }
        if($post->user_id != Auth::id()){
            return $this->sendError('you can not change any thing');
        }
        $post->title=$input['title'];
        $post->description=$input['description'];
        $post->save();
        return $this->sendResponse(new PostResource($post),'post updated successfuly');

    }









    public function destroy(Post $post)
    {
        if($post->user_id != Auth::id()){
            return $this->sendError('you can not change any thing');
        }
        $post->delete();
        return $this->sendResponse(new PostResource($post),'post deleted successfuly');

    }


}
