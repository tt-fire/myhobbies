@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Alle Tags</div>

                <div class="card-body">
                    <ul class="list-group">
                        @foreach($tags as $tag)
                            <li class="list-group-item"> 
                                <a title="Detailansicht" class="ml-2"> {{ $tag->name }} </a>
                                <a class="ml-2 btn btn-light btn-sm" href="/tag/{{ $tag->id }}/edit"><i class="fas fa-pen"></i> Bearbeiten </a>
                                <form ​ style="display: inline;"​ action="/tag/{{ $tag->id }}" ​ method="post"​ >
                                    @csrf
                                    @method('DELETE')
                                    <input class="btn btn-sm btn-outline-danger ml-2" type="submit" value="Löschen">
                                </form>
                            </li>
                        @endforeach
                    </ul>
                    <a class="btn btn-success btn-sm mt-3" href="/tag/create"> <i class="fas fa-plus-circle"></i> Neuen Tag anlegen</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection