<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

//use Illuminate\Routing\Controllers\Middleware;


class PostController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('auth', except: ['show', 'index']),
        ];
    }

    public function index(Request $request, User $user) {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(6);
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    public function create(){
        return view('posts.create');
    }

    public function store(Request $request) {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        Post::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => Auth::user()->id,
        ]);

        /* 2da forma */
        /* $post = new Post;
        $post->titulo = $request->titulo;
        $post->descripcion = $request->descripcion;
        $post->imagen = $request->imagen;
        $post->user_id = $request->user_id; 
        $post->save()*/

        /* 3ra forma */
        /* $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => Auth::user()->id,
        ]); */

        return redirect()->route('posts.index', Auth::user()->username);
    }

    public function show(User $user, Post $post){
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post){
        Gate::allows('delete', $post);
        $post->delete();
        // elimnar imagen
        $imagen_path = public_path('uploads/' . $post->imagen);
        if (File::exists($imagen_path)) {
            unlink($imagen_path);
        }
        
        return redirect()->route('posts.index', Auth::user()->username);
    }

}
