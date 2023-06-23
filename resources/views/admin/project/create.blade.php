@extends('layouts.dashboard')

@section('title')
Portfolio | Project Create
@endsection

@section('content')
<h1>Creazione nuovo Projects</h1>
@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="{{route ('admin.project.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group mb-3">
        <label for="name" class="form-label @error('name') is-invalid @enderror">Name</label>
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="text" name="name" id="name" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label for="description" class="form-label @error('description') is-invalid @enderror">Description</label>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <textarea name="description" id="description" class="form-control" rows="5"></textarea>
    </div>
    <div class="form-group mb-3">
        <label for="client" class="form-label @error('client') is-invalid @enderror">Client</label>
        
        <input type="text" name="client" id="client" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label for="img" class="form-label @error('img') is-invalid @enderror">Img</label>

        <input type="file" name="img" id="img" class="form-control">
    </div>

    <div class="form-group mb-3">
        <label for="project-types" class="form-label">Types</label>
        @error('type_id')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <select class="form-select form-select-lg @error('type_id') is-invalid @enderror" name="type_id" id="project-types">
            <option value="">-- Choose a type --</option>
            @foreach($types as $type)
                <option value="{{$type->id}}">{{$type->name}}</option>
            @endforeach
        </select>
    </div>
    
    <button class="btn btn-primary">Crea Project</button>
</form>

@endsection