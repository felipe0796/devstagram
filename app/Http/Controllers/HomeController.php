<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HomeController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('auth'),
        ];
    }
    public function __invoke()
    {
        $ids_followings = Auth::user()->followings->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $ids_followings)->latest()->paginate(6);

        return view('home', [
            'posts' => $posts,
        ]);
    }
}
