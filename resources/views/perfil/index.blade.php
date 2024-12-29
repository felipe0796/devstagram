@extends('layouts.app')

@section('titulo')
    Editar perfil: {{ auth()->user()->user_name }}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form method="POST" action="{{ route('perfil.store') }}" enctype="multipart/form-data" class="mt-10 md:mt-0">
                @if (@session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ session('mensaje') }}
                    </p>
                @endif
                @csrf
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Username
                    </label>
                    <input id="username" name="username" type="text" placeholder="Tu nombre de usueario" class="border p-3 w-full rounded-lg
                    @error('username') border-red-500 @enderror" value="{{ auth()->user()->username }}">
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="old_email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>
                    <input id="new_email" name="new_email" type="text" placeholder="Tu nombre de usueario" class="border p-3 w-full rounded-lg
                    @error('new_email') border-red-500 @enderror" value="{{ auth()->user()->email }}">
                    @error('new_email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                    <input id="email" name="email" type="hidden" value="{{ auth()->user()->email }}">
                </div>
                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">
                        Imagen Perfil
                    </label>
                    <input id="imagen" name="imagen" type="file" placeholder="Tu nombre de usueario" class="border p-3 w-full rounded-lg
                    @error('imagen') border-red-500 @enderror" value="{{ auth()->user()->imagen }}">
                    @error('imagen')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password Actual
                    </label>
                    <input id="password" name="password" type="password" placeholder="Password de registro" class="border p-3 w-full rounded-lg
                    @error('password') border-red-500 @enderror" value="">
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="new_password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password Nuevo
                    </label>
                    <input id="new_password" name="new_password" type="password" placeholder="Password de registro" class="border p-3 w-full rounded-lg
                    @error('new_password') border-red-500 @enderror" value="">
                    @error('new_password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <input type="submit" value="Editar Cuenta" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer
                    uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection