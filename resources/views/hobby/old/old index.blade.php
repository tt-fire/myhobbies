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
                                <a title="Detailansicht" class="ml-2" href="/hobby/{{ $hobby->id }}"> {{ $hobby->name }} </a>

                            <span class="mx-2">Von <a href="/user/{{$hobby->user->id}}"> {{ $hobby->user->name }} </a> ({{ $hobby->user->hobbies->count() }} Hobbies)</span>

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
                    @auth()
                    <a class="btn btn-success btn-sm mt-3" href="hobby/create"> <i class="fas fa-plus-circle"></i> Neues Hobby anlegen</a>
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
