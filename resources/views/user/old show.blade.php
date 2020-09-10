@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><span style="font-size: 150%">Profil von {{ $user->name }}</span>
                    <a class="float-right" href="/hobby">Alle Hobbies anzeigen</a>
                </div>

                <div class="card-body">
                    <p><b>Motto: {{ $user->motto ?? '' }} </b></p>
                    <p> {{ $user->ueber_mich ?? '' }} </p>
                    
                    <h5>Hobbies von {{ $user->name }}:</h5>

                    @if($user->hobbies->count() > 0)

                        <ul class="list-group">
                            @foreach($user->hobbies as $hobby)
                                <li class="list-group-item"> 
                                    <a title="Detailansicht" class="ml-2" href="/hobby/{{ $hobby->id }}"> {{ $hobby->name }} </a>

                                <div class="float-right">{{ $hobby->created_at->diffForHumans() }}</div>
                                <br>
                                @foreach($hobby->tags as $tag)
                                    <a class="badge badge-{{ $tag->style }}" href="/hobby/tag/{{ $tag->id }}">{{ $tag->name }}</a>
                                @endforeach
                                </li>
                            @endforeach
                        </ul>

                        
                    @else()

                            <p>Der User {{ $user->name }} hat noch keine Hobbies angelegt!</p>
                    
                    @endif

                    <a class="btn btn-success btn-sm mt-3" href={{ URL::previous() }}> <i class="fa fa-arrow-circle-up"></i> Zurück</a>
            </div>  

            </div>
        </div>
    </div>
</div>
@endsection
