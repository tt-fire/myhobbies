@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-9">

                            <h2>Hallo {{auth()->user()->name }}</h2>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif


                            <h5>Dein Motto</h5>
                            <p>{{ auth()->user()->motto ?? '' }}</p>

                            <h5>Deine "Über-Mich" - Beschreibung</h5>
                            <p>{{ auth()->user()->ueber_mich ?? '' }}</p>

                            <p>
                                <a href="/user/{{ auth()->user()->id }}/edit" class="btn btn-primary">Profil bearbeiten</a>
                            </p>
                        </div>

                        <div class="col-md-3">

                            @auth

                                @if(file_exists("img/user/User_" . auth()->user()->id . ".jpg"))
                                <a href="/img/user/User_{{ auth()->user()->id }}.jpg" data-lightbox="User_{{ auth()->user()->id }}.jpg" data-title="{{ auth()->user()->id }}">
                                    <img class="img-fluid" src="/img/user/User_{{ auth()->user()->id }}.jpg" alt="/img/300x400.jpg">
                                </a>
                                @endif

                                <i class="fa fa-search-plus"></i> Bild anklicken zum Vergrößern

                            @endauth

                            @guest 
                                @if(file_exists("img/user/User_" . auth()->user()->id . "_verpixelt.jpg"))
                                    <img class="img-fluid" src="/img/user/User_{{ auth()->user()->id }}_verpixelt.jpg" alt="/img/300x400.jpg">
                                @endif
                            @endguest

                        </div>


                    </div>

                    @isset($hobbies)
                        @if($hobbies->count() > 0)
                            <h5>Deine Hobbies</h5>
                        @endif
                        <ul class="list-group">
                        @foreach($hobbies as $hobby)
                        <li class="list-group-item">

                            @if(file_exists("img/hobby/" . $hobby->id . "_thumb.jpg"))
                                <a class="mr-1" title="Details anzeigen" href="/hobby/{{ $hobby->id }}">
                                    <img src="/img/hobby/{{ $hobby->id }}_thumb.jpg" alt="thumb"></a>
                            @endif

                            {{ $hobby->name }} <a class="ml-2" href="/hobby/{{ $hobby->id }}">Detailansicht</a>

                            <a class="ml-2 btn btn-sm btn-outline-primary" href="/hobby/{{ $hobby->id }}/edit"><i class="fas fa-edit"></i> Bearbeiten</a>
                            <form style="display: inline;" action="/hobby/{{ $hobby->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input class="btn btn-outline-danger btn-sm ml-2" type="submit" value="Löschen">
                            </form>
                            <div class="float-right">{{ $hobby->created_at->diffForHumans() }}</div>
                            <br>
                            @foreach($hobby->tags as $tag)
                                <a class="badge badge-{{$tag->style}}" href="/hobby/tag/{{ $tag->id }}">{{ $tag->name }}</a>
                            @endforeach
                        </li>
                         @endforeach
                        </ul>
                    @endisset

                    <a class="btn btn-success btn-sm mt-3   " href="/hobby/create"><i class="fas fa-plus-circle"></i> Neues Hobby anlegen</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
