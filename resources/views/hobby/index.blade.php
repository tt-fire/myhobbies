
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                @isset($filter)
                    <div class="card-header">Alle Hobbies gefiltert nach 
                        <span class="ml-2 badge badge-{{ $filter->style }}" style="font-size: 120%">{{ $filter->name ?? '' }}</span>
                        <a class="float-right" href="/hobby">Alle Hobbies anzeigen</a>
                    </div>
                @else
                    <div class="card-header">Alle Hobbies</div>
                @endisset

                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($hobbies as $hobby)
                                <li class="list-group-item">

                                    @if(file_exists("img/hobby/" . $hobby->id . "_thumb.jpg"))
                                        <a class="mr-1" title="Details anzeigen" href="/hobby/{{ $hobby->id }}">
                                            <img src="/img/hobby/{{ $hobby->id }}_thumb.jpg" alt="thumb"></a>
                                    @endif

                                    {{ $hobby->name }}

                                    <a class="ml-2" href="/hobby/{{ $hobby->id }}">Detailansicht</a>

                                    <span class="mx-2">Von <a href="/user/{{$hobby->user->id}}">{{ $hobby->user->name }}</a> ( {{ $hobby->user->hobbies->count() }} Hobbies)
                                    <a href="/user/{{ $hobby->user->id }}">
                                        
                                    @if(file_exists("img/user/User_" . $hobby->user->id . "_thumb.jpg"))
                                            <img class="img-fluid" src="/img/user/User_{{ $hobby->user->id }}_thumb.jpg" alt="/img/300x400.jpg">
                                        </a>
                                    @endif
                                    </span>

                                    @can('update', $hobby) 
                                        <a class="ml-2 btn btn-sm btn-outline-primary" href="/hobby/{{ $hobby->id }}/edit"><i class="fas fa-edit"></i> Bearbeiten</a>
                                    @endcan
                                    
                                    @can('delete', $hobby)
                                        <form style="display: inline;" action="/hobby/{{ $hobby->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input class="btn btn-outline-danger btn-sm ml-2" type="submit" value="Löschen">
                                        </form>
                                    @endcan


                                    <div class="float-right">{{ $hobby->created_at->diffForHumans() }}</div>
                                    <br>
                                    @foreach($hobby->tags as $tag)
                                        <a class="badge badge-{{$tag->style}}" href="/hobby/tag/{{ $tag->id }}">{{ $tag->name }}</a>
                                    @endforeach
                                </li>
                            @endforeach
                        </ul>
                        @auth
                        <a class="btn btn-success btn-sm mt-3" href="hobby/create"><i class="fas fa-plus-circle"></i> Neues Hobby anlegen</a>
                        @endauth
                        <div class="mt-3">
                            {{ $hobbies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
