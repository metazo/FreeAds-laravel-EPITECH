@extends('layouts.app')

@section('content')


<div class="w-4/5 m-auto text-center">
    <div class="py-15 border-b border-gray-200">
        <h1 class="text-6xl">
            Blog d'annonce
        </h1>
    </div>
    <br>
    <div class="search-container">
        <form action="{{ url('/')}}" type="get">
          <input type="text" placeholder="Trouver utilisateur.." name="search">
          <button type="submit">Rechercher</button>
        </form>
      </div>
</div>
<style>
.search-container {
  float: right;
  margin-top: 38px
}

 input[type=text] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: #3f83f8
}

.search-container button {
  float: right;
  padding: 10px;
  margin-top: 8px;
  margin-right: 16px;
  background: #3f83f8;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.search-container button:hover {
  background: rgb(88, 157, 247);
}


</style>

@if (session()->has('message'))
    <div class="w-4/5 m-auto mt-10 pl-2">
        <p class="w-2/6 mb-4 text-gray-50 bg-green-500 rounded-2xl py-4">
            {{ session()->get('message') }}
        </p>
    </div>
@endif

@if (Auth::check())
    <div class="pt-15 w-4/5 m-auto">
        <a 
            href="/blog/create"
            class="bg-blue-500 uppercase bg-transparent text-gray-100 text-xs font-extrabold py-3 px-5 rounded-3xl">
            Créer une annonce
        </a>
    </div>
    
@endif

@foreach ($posts as $post)
    <div class="sm:grid grid-cols-2 gap-20 w-4/5 mx-auto py-15 border-b border-gray-200">
        <div>
            <img src="{{ asset('images/' . $post->image_path) }}" alt="">
        </div>
        <div>
            <h2 class="text-gray-700 font-bold text-5xl pb-4">
                {{ $post->title }}
            </h2>

            <span>
                <h5 class="text-3xl">
                    {{ $post->price.' €'}}
                </h5>
                <br>
            </span>

            <span class="text-gray-500">
                Par <span class="font-bold italic text-gray-800">{{ $post->user->name }}</span>, Publiée le {{ date('jS M Y', strtotime($post->updated_at)) }}
            </span>


            <p class="text-xl text-gray-700 pt-8 pb-10 leading-8 font-light">
                {{ $post->description }}
            </p>

            

            <a href="/blog/{{ $post->slug }}" class="uppercase bg-blue-500 text-gray-100 text-lg font-extrabold py-4 px-8 rounded-3xl">
                Continuer la lecture
            </a>

            @if (isset(Auth::user()->id) && Auth::user()->id == $post->user_id)
                <span class="float-right">
                    <a 
                        href="/blog/{{ $post->slug }}/edit"
                        class="text-gray-700 italic hover:text-gray-900 pb-1 border-b-2">
                        Modifier
                    </a>
                </span>

                <span class="float-right">
                     <form 
                        action="/blog/{{ $post->slug }}"
                        method="POST">
                        @csrf
                        @method('delete')

                        <button
                            class="text-red-500 pr-3"
                            type="submit">
                            Supprimer
                        </button>

                    </form>
                </span>
            @endif
        </div>
    </div>    
@endforeach

@endsection