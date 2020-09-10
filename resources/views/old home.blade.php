@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <h2>Hallo {{ auth()->user()->name }}</h2>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }} <br>
                    <br>

                @isset($hobbies)
                    <h5 class="mt-3">Deine Hobbies</h5>

                    @if($hobbies->count()==0)
                        Du hast noch keine Hobbies angelegt!
                    @endif

                    <ul class="list-group">
                        @foreach($hobbies as $hobby)
                            <li class="list-group-item"> 
                                <a title="Detailansicht" class="ml-2" href="/hobby/{{ $hobby->id }}"> {{ $hobby->name }} </a>

                                <a class="ml-2 btn btn-light btn-sm" href="/hobby/{{ $hobby->id }}/edit"><i class="fas fa-pen"></i> Bearbeiten </a>
                                <form ​ style="display: inline;"​ action="/hobby/{{ $hobby->id }}" ​ method="post"​ >
                                    @csrf
                                    @method('DELETE')
                                    <input class="btn btn-sm btn-outline-danger ml-2" type="submit" value="Löschen">
                                </form>
                            <div class="float-right">{{ $hobby->created_at->diffForHumans() }}</div>
                            <br>
                            @foreach($hobby->tags as $tag)
                                <a class="badge badge-{{ $tag->style }}" href="/hobby/tag/{{ $tag->id }}">{{ $tag->name }}</a>
                            @endforeach
                            </li>
                        @endforeach
                    </ul>
                @endisset

                    <a class="btn btn-success btn-sm" href="/hobby/create"><i class="fas fa-plus-circle"></i>Neues Hobby anlegen</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
