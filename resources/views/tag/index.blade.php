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
                                <span style="font-size: 130%" class="mr-2 badge badge-{{ $tag->style }}">
                                     {{ $tag->name }}
                                </span>
                                

                                @can('update', $tag)
                                 ({{ $tag->style }})
                                    <a class="ml-2 btn btn-light btn-sm" href="/tag/{{ $tag->id }}/edit"><i class="fas fa-pen"></i> Bearbeiten </a>
                                @endcan
                                @can('delete', $tag)
                                    <form ​ style="display: inline;"​ action="/tag/{{ $tag->id }}" ​ method="post"​ >
                                        @csrf
                                        @method('DELETE')
                                        <input class="btn btn-sm btn-outline-danger ml-2" type="submit" value="Löschen">
                                    </form>
                                @endcan

                                <span class="float-right"><a href="/hobby/tag/{{ $tag->id }}">{{ $tag->hobbies()->count()}} mal verwendet</a></span>
                            </li>
                        @endforeach
                    </ul>
                    @can('create', $tag)
                        <a class="btn btn-success btn-sm mt-3" href="/tag/create"> <i class="fas fa-plus-circle"></i> Neuen Tag anlegen</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
