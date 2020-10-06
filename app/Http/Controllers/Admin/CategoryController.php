<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Carbon\Doctrine\CarbonType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index()
    {
        $categories =  Category::with('posts')->get();
        return response()->json(['categories' => $categories], 200);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
           'category_name' => 'required',
           'status' => 'required',
        ]);
       try{
           Category::create([
               'category_name' =>$request->category_name,
               'category_slug'=>slugify($request->category_name),
               'status'=>$request->status
           ]);
           return response()->json(['status' => true],200);


       }catch (\Exception $e){
           return response()->json(['status' => false, 'message' => 'Category Allready Exists!'],200);
       }
    }


    public function show($slug)
    {
        $category = Category::where('category_slug',$slug)->first();

        return response()->json(['category' =>$category], 200);

    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $slug)
    {
        try {
            $category = Category::where('category_slug' , $slug)->first();
            $category->category_name = $request->category_name;
            $category->category_slug = slugify($request->category_name);
            $category->status = $request->status;
            $category->update();

            return response()->json(['category' => $category], 200);

        }catch (\Exception $e){

            return response()->json(['category' => $category], 400);
        }


    }


    public function destroy($categorySlug)
    {
        try{
            $category = Category::where('category_slug',$categorySlug);
            $category->delete();
            return response()->json(['status' => true], 200);

        }catch (\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
        }

    }
    public function removesCategory(Request $request){

        try
        {
            /*delete this way multiple data*/
            /*$sl = 0;
            foreach ($request->selectedId as $id) {
                $categoriesRemove = Category::find($id);
                $categoriesRemove->delete();
                $sl++;
            }
           $success = $sl > 0 ? true : false;;*/

                    /* Another way without loop*/
            Category::destroy($request->selectedId);
            return response()->json(['status' => true, 'message' =>'Category Delete Successfully', 'total'=> count($request->selectedId) ], 200);
        }catch (\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
        }
    }
    public function changeStatus(Request $request)
    {
        try {
            $items = Category::find($request->selectedId);
            foreach ($items as $id){
                if($id->status === 0){
                    $id->update(['status' => '1']);
                }else{
                    $id->update(['status' => '0']);
                }
            }
            return response()->json(['status' => true, 'total'=> count($request->selectedId)], 200);
        }catch (\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()],200);
        }

    }


   }
