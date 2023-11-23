@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Alert for displaying success messages -->
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <h1 class="my-4" style="color: white">Manage Users</h1>
    <div class="card">
        
        <div class="card-header text-white" style="background-color: rgb(31,41,55)">
            User Management
        </div>
        <div class="card-body" style="background-color: rgb(31,41,55);">
            <table class="table" style="background-color: rgb(31,41,55);">
                <thead>
                    <tr>
                        <th style="color: white; text-align: center;">ID</th>
                        <th style="color: white; text-align: center;">Name</th>
                        <th style="color: white; text-align: center;">Email</th>
                        <th style="color: white; text-align: center;">Role</th>
                        <th style="color: white; text-align: center;">Number of chats</th>
                        <th style="color: white; text-align: center;">Account Status</th>
                        <th style="color: white; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            
                            <td style="color: {{ $user->chats_count > 4 ? 'red' : 'white' }}; text-align: center;" >{{ $user->id }}</td>
                            <td style="color: {{ $user->chats_count > 4 ? 'red' : 'white' }}; text-align: center;" >{{ $user->name }}</td>
                            <td style="color: {{ $user->chats_count > 4 ? 'red' : 'white' }}; text-align: center;" >{{ $user->email }}</td>
                            <td style="color: {{ $user->chats_count > 4 ? 'red' : 'white' }}; text-align: center;" >{{ $user->role }}</td>
                            <td style="color: {{ $user->chats_count > 4 ? 'red' : 'white' }}; text-align: center;" >{{ $user->chats_count }}</td>
                            <td style="text-align: center; color: {{ $user->chats_count > 4 ? 'red' : 'white' }}; text-align: center;">{{ $user->block == 1 ? 'BLOCKED' : 'UNBLOCKED' }}</td>

                            <td style="text-align: center;">
                                <form action="{{ url('/admin/users/'.$user->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                <form action="{{ route('admin.users.restrict', $user->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-warning">Restrict</button>
                                </form>
                                <form action="{{ route('admin.users.allow', $user->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn  btn-sm btn-primary">Allow</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
