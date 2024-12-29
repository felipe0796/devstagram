<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Termwind\Components\Dd;

class PerfilController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('auth', except: ['index']),
        ];
    }

    public function index() {
        return view('perfil.index');
    }

    public function store(Request $request) {

        $request->request->add([
            'username' => Str::slug($request->username)
        ]); 

        $request->validate([
            'username' => [
                'required', 
                'unique:users,username,' . Auth::user()->id, 
                'min:3', 
                'max:20', 
                'not_in:twitter,editar-perfil'
            ],
            'email' => [
                'required', 
                'unique:users,email,' . Auth::user()->id, 
                'email', 
                'max:60'
            ],
        ]);

        $hash_password = Auth::user()->password;
        if ($request->password || $request->new_password) {
            if (!Auth::attempt($request->only('email', 'password'), $request->remember)) {
                return back()->with('mensaje', 'la contraseña actual es incorrecta');
            }
            
            $request->validate([
                'password' => 'required',
                'new_password' => 'required|min:6',
            ]);

            $hash_password = Hash::make($request->new_password);
        }

        if ($request->imagen) {
            $manager = new ImageManager(new Driver());
        
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imagenServidor = $manager->read($imagen);
            $imagenServidor->cover(1000, 1000);

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        // Guardar cambios
        $usuario = User::find(Auth::user()->id);
        $usuario->username = $request->username;
        $usuario->email = $request->new_email;
        $usuario->imagen = $nombreImagen ?? Auth::user()->imagen ?? '';
        $usuario->password = $hash_password;
        
        $usuario->save();
        
        return redirect()->route('posts.index', $usuario->username);
    }
}
