@extends('layouts.dashboard')

@section('title')
Portfolio | Project Show
@endsection

@section('content')
<h1>Singolo Projects: {{$project->name}}</h1>

<p>
    Descrizione: {{$project->description}}
</p>
<p>
    Cliente: {{$project->client}}
</p>

<img class="img-fluid" src="{{asset('storage/' . $project->img)}}" alt="">


@if($project->type)
<p>
    Type: {{$project->type->name}}
</p>
@endif

<div>
    Technology used: 
    @if ($project->technologies)
        @foreach($project->technologies as $elem)	
            {{$elem->name}}
        @endforeach
    @endif
</div>

@endsection