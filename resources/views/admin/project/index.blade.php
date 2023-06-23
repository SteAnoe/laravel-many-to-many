@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    @if (Session::has('success'))
        <div>
            {!! Session::get('success') !!}
        </div>
    @endif
    <a class="btn btn-primary" href="{{route ('admin.project.create') }}">Create Project</a>
    <div class="row justify-content-center">
        
    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Client</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
            <tr class="mb-3">
                <td>{{ $project->name }}</td>
                <td>{{ $project->client }}</td>
                <td>{{ $project->description }}</td>
                <td>
                <div class="d-flex">
                    <a href="{{route ('admin.project.show', $project)}}"><button type="submit" class="btn btn-primary">Show</button></a>
                    <form class="mx-3" action="{{ route('admin.project.destroy', $project) }}" method="POST" onclick="return confirm('Are you sure you want to delete this project?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <a href="{{ route('admin.project.edit', $project) }}"><button type="submit" class="btn btn-warning">Edit</button></a>
                    </td>
                </div>
                
            </tr>
            @empty
            <tr>
                <td colspan="3">
                    <h2>Non ci sono progetti</h2>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
       
            
    </div>
</div>
@endsection
