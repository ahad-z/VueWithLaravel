<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
       $posts =  Post::with('category','user')->get();
       return response()->json(['allPosts' => $posts],200);

    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($postslug)
    {

        try {
            $post = Post::where('post_slug', $postslug);
            $post->delete();
            return response()->json(['status' => true],200);
        }catch (\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()],200);
        }

    }
    public function removesPosts(Request  $request)
    {
        try {
            $sl = 0;
            foreach ($request->selectedID as $id){
                $category = Post::find($id);
                $category->delete();
                $sl++;
            }
            $success = $sl > 0 ? true : false;

            return response()->json(['status'=> $success , 'total' => $sl ], 200);

        }catch (\Exception $e){
            return response()->json(['status'=> $success , 'message' => $e->getMessage() ], 200);
        }

    }
    public function statusChange(Request $request){
       try{
           $items = Post::find($request->selectedId);
           foreach ($items as $id){
               if($id->status === 'draft'){
                   $id->update(['status' => 'published']);
               }else{
                   $id->update(['status' => 'draft']);
               }
           }
           return response()->json(['status' => true , 'total' => count($request->selectedId)], 200);

       }catch (\Exception $e){
           return response()->json(['status' => false, 'message' => $e->getMessage()] , 200);
       }
    }
}
