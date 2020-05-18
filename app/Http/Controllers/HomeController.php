<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use Auth;
use App\Events\NewNotification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::all();
        return view('home', compact('posts'));
    }

    public function saveComment(Request $request){
        Comment::create([
            'post_id' => $request ->post_id ,
            'user_id' => Auth::id(),
            'comment' => $request ->post_content,
        ]);

        $data = [
            'post_id' => $request ->post_id ,
            'user_id' => Auth::id(),
            'comment' => $request ->post_content,
            'user_name'  => Auth::user()->name,
        ];

        event(new NewNotification($data));

        return redirect() -> back() -> with(['success'=> 'Comment Added Successfuly']);
    }
}
