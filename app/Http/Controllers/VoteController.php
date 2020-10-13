<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Vote;

class VoteController extends Controller
{
    public function index(){

    }
    public function create(){

    }
    public function store(Request $request){
        return $request;
        try{
            $request->validate([
                'body' => 'required'
            ]);

            Vote::create([
                'body' => $request->body
            ]);

            return response()->json(['status' => true], 200);
        }catch (\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()], 200);

        }
    }

    public function show($id){

    }
    public function edit($id){

    }
    public function update(Request $request, $id){

    }
    public function destroy($id){

    }

}
