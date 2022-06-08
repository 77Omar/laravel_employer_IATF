@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tâches</h2>
            </div>
            <div class="pull-right">
                @can('create-task')
                    <a class="btn btn-success" href="{{ route('taches.create') }}"> Create New Task</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Libelle</th>
            <th>Description</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($taches as $tache)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $tache->libelle }}</td>
                <td>{{ $tache->description }}</td>
                <td>{{ $tache->status }}</td>
                <td>
                    <form action="{{ route('taches.destroy',$tache->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('taches.show',$tache->id) }}">Show</a>
                        @can('update-task')
                            <a class="btn btn-primary" href="{{ route('taches.edit',$tache->id) }}">Edit</a>
                        @endcan


                        @csrf
                        @method('DELETE')
                        @can('delete-task')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </table>


    {!! $taches->links() !!}


    <p class="text-center text-primary"><small>Tutorial by omzo@gmail.com</small></p>
@endsection
