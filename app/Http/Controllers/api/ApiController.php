<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Books;
Use App\Models\Assets;
use App\Models\Book_Cactegory;
use App\Models\Categories;
use App\Models\User;
use Validator;

class ApiController extends Controller
{
    // 
    // 
    // 
    // Book manager
    // 
    // 
    protected function bookindex(){
        return Books::all();
    }
    protected function bookcreate(Request $request){
        $validate=Validator::make($request->all(),[
            'name' => 'required',
            'author' => 'required',
            'description' => 'required',
            'category'=>'required',
            'cover'=>'required',
        ]);
        $user=$request->user();
        $input=$request->all();
        $input['created_by']=$user['name'];
        $input['cover']=$this->cover($request);
        $book=Books::create($input);
        return response()->json(
            ['success' =>"Create success",]
        );
    }
    // 
    // 
    //  File manager
    // 
    // Upload anh bia cho sách
    protected function cover(request $request){
        $validate=Validator::make($request -> all(),[
            'cover' =>'required|image:jpeg,png,jpg,gif',
            //  dùng để check định dạng file âm thanh
            // 'cover' => 'required|mimes:audio'  
        ]);
        if($validate->fails()){
            return response()->json(['error' => $validate->errors()
        ], 401);
        }
        //Lưu file vào thư mục
        $path=$request->file('cover')->store('public/cover');
        // lấy tên file
            $name=$request->file('cover')->hashName();
        //lấy url 
            $url=asset('storage/cover/'.$name);
            $user=$request->user();
            $input['name']=$name;
            $input['url']=$url;
            $input['type']='Cover_Image';
            $input['created_by']=$user['name'];
            $asset =Assets::create($input);
        return $asset['id'];
    }
}
