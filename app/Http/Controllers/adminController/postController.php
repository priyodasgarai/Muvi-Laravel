<?php

namespace App\Http\Controllers\adminController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\model\post;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class postController extends Controller {    

    public function create(Request $request) {
        if ($request->isMethod('post')) {
        $video = "";
        $poster_image = "";
        $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'publish_date' => 'nullable|date',
                    'expired_date' => 'nullable|date',
                    'video' => 'required|mimetypes:video/mp4|max:20000',
                    'poster_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'content' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }        
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $video = $file->getClientOriginalExtension();
            $video = time() . rand() . '.' . $video;
            $destinationPath = public_path() . trans('labels.88');
            $file->move($destinationPath, $video);
        }
        if ($request->hasFile('poster_image')) {
            $file = $request->file('poster_image');
            $poster_image = $file->getClientOriginalExtension();
            $poster_image = time() . rand() . '.' . $poster_image;
            $destinationPath = public_path() . trans('labels.88');
            $file->move($destinationPath, $poster_image);
        }
        $post = new post;
        $post->title = $request->input('title');
        $post->publish_date = date('Y-m-d', strtotime($request->input('publish_date')));
        $post->expired_date = date('Y-m-d', strtotime($request->input('publish_date')));
        $post->video = $video;
        $post->poster_image = $poster_image;
        $post->content = $request->input('content');
        if($post->save()){
            Session::put('flash_message', 'Post Add succesfull.');
            return redirect('admin-post');
        }else{
            return Redirect::back()->withErrors(['message' => trans('messages.6')]);
        }
        }else{
            return view('admin-view.addPosts');            
        }

    }

    public function post_get() {
        $posts = post::all();   
        //return $posts;
        return view('admin-view.posts', ['posts' => $posts]);        
    }

    public function post_edit($request){
        $val = explode("||", base64_decode($request));
        $id = $val[0];
        //dd($id);
        $details = post::findOrFail($id);
       // return $details;
        return view('admin-view.editPosts', ['post' => $details]); 
    }
    public function post_edit_submit(Request $request, $id){
        $validator = Validator::make($request->all(), ['post_id' => 'required']);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } 
        $post_details = post::findOrFail($request->input('post_id'));
        if (!empty($post_details)) {
            
             if ($request->hasFile('poster_image')) {
                    $validator_img = Validator::make($request->all(), ['poster_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
                    if ($validator_img->fails()) {
                        return redirect()->back()->withErrors($validator_img);
                    } else {
                        $path = public_path() . trans('labels.88') . $post_details->poster_image;
                        if (file_exists($path) && !empty($post_details->poster_image)) {
                            unlink($path);
                        }
                        $file = $request->file('poster_image');
                        $poster_image = $file->getClientOriginalExtension();
                        $poster_image = time() . rand() . '.' . $poster_image;
                        $destinationPath = public_path() . trans('labels.88');
                        $file->move($destinationPath, $poster_image);
                    }
                } else {
                    $poster_image = $post_details->poster_image;
                }
                if ($request->hasFile('video')) {
                    $validator_video = Validator::make($request->all(), ['video' => 'required|mimetypes:video/mp4|max:20000',]);
                    if ($validator_video->fails()) {
                        return redirect()->back()->withErrors($validator_video);
                    } else {
                        $path = public_path() . trans('labels.88') . $post_details->video;
                        if (file_exists($path) && !empty($post_details->video)) {
                            unlink($path);
                        }
                        $file = $data->file('video');
                        $video = $file->getClientOriginalExtension();
                        $video = time() . rand() . '.' . $video;
                        $destinationPath = public_path() . trans('labels.88');
                        $file->move($destinationPath, $video);
                    }
                } else {
                    $video = $post_details->video;
                }
                $post_details->title = (!empty($request->input('title'))) ? $request->input('title') : $post_details->title;
                $post_details->publish_date = (!empty($request->input('publish_date'))) ? date('Y-m-d', strtotime($request->input('publish_date'))) : $post_details->publish_date;
                $post_details->expired_date = (!empty($request->input('expired_date'))) ? date('Y-m-d', strtotime($request->input('expired_date'))) : $post_details->expired_date;
                $post_details->video = $video;
                $post_details->poster_image = $poster_image;
                $post_details->content = (!empty($request->input('content'))) ? $request->input('content') : $post_details->content;
                if ($post_details->save() == true) {
                    Session::put('flash_message', trans('messages.10'));
                    return redirect('admin-post');
                } else {
                    Session::put('flash_message', trans('messages.11'));
                    return redirect('admin-post');
                }
                
                }else{
            Session::put('flash_message', trans('messages.7'));
            return redirect('admin-post')->back();
        }
    }
    public function post_delete($data){
        $val = explode("||", base64_decode($data));
        $id = $val[0];
        $post_details = post::findOrFail($id);
        $path = public_path() . trans('labels.88') . $post_details->poster_image;
        if (file_exists($path) && !empty($post_details->poster_image)) {
            unlink($path);
        }
        $videopath = public_path() . trans('labels.88') . $post_details->video;
        if (file_exists($videopath) && !empty($post_details->video)) {
            unlink($videopath);
        }
        
        if ($post_details->delete() == true) {
            Session::put('flash_message', trans('messages.8'));
            return redirect()->back();
        } else {
            Session::put('flash_message', trans('messages.9'));
            return redirect()->back();
        }
    }
    
    public function view_post(){
         $posts = post::all();
        return view('front-view.posts', ['posts' => $posts]);
    }
    public function post_details($data){
        //echo date("Y-m-d");
        $val = explode("||", base64_decode($data));
        $id = $val[0];
        $post_details = post::findOrFail($id);
        return view('front-view.post_details', ['post' => $post_details]);
    }
    public function play_video($data){
        $val = explode("||", base64_decode($data));
        $id = $val[0];
        $post_details = post::findOrFail($id);
        return view('front-view.play_video', ['post' => $post_details]);
    }
}
