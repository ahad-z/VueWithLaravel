<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\ModelCollection;
use App\Post;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function index(Request  $request)
    {
        $posts =  Post::with('category','user')

           ->orderBy('id',"DESC");

        if(isset($request->search_query)){

            $posts =   $posts->where('title', 'LIKE', '%' . $request->get('search_query') . '%');
        }

     return new ModelCollection($posts->paginate(2));

    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        // This is another way to find extension
       /* $strPos = strops($request->thumbnail, ';');
        $str = substr($request->thumbnail, 0, $strPos);
        $file = explode( '/' , $str);
        $file_Extension = end($file);*/
       $request->validate([
           'title' => 'required|min:5|max:100|unique:posts',
           'status' => 'required'
       ]);

        $file = explode(';', $request->thumbnail);
        $file = explode('/',  $file[0]);
        $file_Extension = end( $file);
        $slug = slugify($request->title);
        $file_Name = $slug . '.' . $file_Extension;

        try {
            $post = Post::create([
                'user_id'          => auth()->user()->id,
                'category_id'      => $request->category_id,
                'title'            => $request->title,
                'post_slug'        => $slug,
                'content'          => $request->description,
                'thumbnail'        => $file_Name,
                'status'           => $request->status
            ]);
            if($post){
                 Image::make($request->thumbnail)->resize(400, 200)->save(public_path('uploads/post/').$file_Name);
            }
            return response()->json(['status' => true, 'message' => 'Post Submitted Successfully'],200);
        }catch (\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()],200);
        }
    }

    public function show(Request $request)
    {
       $post = Post::where('post_slug', $request->slug)->first();
       return response()->json(['post' => $post], 200);
    }


    public function edit($id)
    {

    }


    public function update(Request $request,$slug)
    {

       try{
        $post = Post::where('post_slug', $slug)->first();
        $post->title     = $request->title;
        $post->post_slug = slugify($request->title);
        $post->content   = $request->content;
        $post->status    = $request->status;

        if($request->thumbnail !== $post->thumbnail){
            $file = explode(';', $request->thumbnail);
            $file = explode('/',  $file[0]);
            $file_Extension = end( $file);
            $slug = slugify($request->title);
            $file_Name = $slug . '.' . $file_Extension;
            $post->thumbnail = $file_Name;
            Image::make($request->thumbnail)->resize(400, 200)->save(public_path('uploads/post/').$file_Name);
        }
        $post->update();
       return response()->json(['status' => true], 200);

       }catch(\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
       }

    }


    public function destroy($postslug)
    {

        try {
            $post = Post::where('post_slug', $postslug)->first();
            $file_Name = $post->thumbnail;
           if( $post->delete()){
               if(file_exists(public_path('uploads/post/'.$file_Name))){
                   unlink(public_path('uploads/post/'.$file_Name));
               }
           }
            return response()->json(['status' => true, 'message' => 'Post Delete Successfully'],200);
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

            return response()->json(['status'=> $success , 'total' => $sl, 'message' => 'Post Delete Successfully' ], 200);

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
    public function searchContent(Request $request){
        if($request->get('search_query') !== ''){
            $posts  = Post::with('category','user')->where('title', 'LIKE', '%' . $request->get('search_query') . '%')->get();
        }

        return response()->json(['searchPost' => $posts] ,200);

    }
}
