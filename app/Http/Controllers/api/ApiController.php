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
  
    //////////////////////////////////////////
    // hàm để show dữ liệu (dùng get)
    /////////////////////////////////////////
    protected function bookindex(){
        return Books::all();
    }
    protected function bookinfo(request $request,$id){
        Books::where('id',$id)->first();
        return ['book'=>Books::where('id',$id)->first(),
    ];
    }
    //////////////////////////////////////////////////////////////
    // hàm tạo sách dựa trên category có sẵn
    /////////////////////////////////////////////////////////////
    protected function bookcreate(Request $request){
        $validate=Validator::make($request->all(),[
            'name' => 'required',
            'author' => 'required',
            'description' => 'required',
            'cover'=>'required',
            'category' => 'required'
        ]);
        if($validate->fails()){
            return response()->json(['error' => $validate->errors()
        ], 401);
        }
        $user=$request->user();
        $input=$request->all();
        $input['created_by']=$user['name'];
        $input['cover']=$this->uploadcover($request);
        $book=Books::create($input);
        //  thêm vào category
        $bookcate['book_id']=$book['id'];
        $bookcate['category_id']=$request->category;
        $newcategory=$this->createbookcategory($bookcate);
        // 
        return response()->json(
            ['success' =>"Create success",]
        );
    }
    protected function createcategory(request $request){
        $validate=Validator::make($request -> all(),[
            'name' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);
        if($validate->fails()){
            return response()->json(['error' => $validate->errors()
        ], 401);
        }
        $input=request()->all();
        $user=$request->user();
        $input['created_by']=$user['name'];
        $category=Categories::create($input);
        return response()->json(
            ['success' =>"Create success",]
        );
    }
    protected function createbookcategory(request $request){
        // Biến book_id và catalog_id
        $input=$request->all();
        $bookcategory=Book_Cactegory::create($input);
    }
    protected function chaptercreate(Request $request){
        $validate=Validator::make($request->all(),[
            'name' => 'required',
            'author' => 'required',
            'description' => 'required',
            'cover'=>'required',
            'category' => 'required'
        ]);
        if($validate->fails()){
            return response()->json(['error' => $validate->errors()
        ], 401);
        }
    }

    ////////////////////////////////////////////////////  
    //  File manager
    ///////////////////////////////////////////////////
    // Upload anh bia 
    // ////////////////////////////////////////////////
    protected function uploadcover(request $request){
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
    /////////////////////////////////
    // Upload file audio
    ////////////////////////////////
    protected function uploadaudio(request $request){
        $validate=Validator::make($request -> all(),[
            //  dùng để check định dạng file âm thanh
            'cover' => 'required|mimes:mp3,wav'  
        ]);
        if($validate->fails()){
            return response()->json(['error' => $validate->errors()
        ], 401);
        }
        //Lưu file vào thư mục
        $path=$request->file('audio')->store('public/audio');
        // lấy tên file
            $name=$request->file('audio')->hashName();
        //lấy url 
            $url=asset('storage/audio/'.$name);
            $user=$request->user();
            $input['name']=$name;
            $input['url']=$url;
            $input['type']='Audio';
            $input['created_by']=$user['name'];
            $asset =Assets::create($input);
        return $asset['id'];
    }
}
