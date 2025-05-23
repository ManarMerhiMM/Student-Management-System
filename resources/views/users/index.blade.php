@extends('layouts.layout')

@section('title', 'Manage Users')

@section('content')
    <div class="container">
        <h2 class="mb-4">Manage Users</h2>

        @if (session('success'))
            <div class="alert alert-success" id="alertSuccess" role="alert">
                {{ session('success') }}
            </div>
        @endif
        {{-- Search Form --}}
        <form action="{{ route('users.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by username..."
                    value="{{ request('search') }}" autocomplete="off">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
        </form>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center align-middle">
                            @if ($user->is_deactivated)
                                <span class="badge bg-danger">Deactivated</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->is_deactivated)
                                <form action="{{ route('users.activate', $user) }}" method="POST" style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to activate this user?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success d-block mx-auto">Activate</button>
                                </form>
                            @else
                                <form action="{{ route('users.deactivate', $user) }}" method="POST" style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to deactivate this user?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger d-block mx-auto">Deactivate</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection


@section('script')
<script src="{{asset("JS/userIndex.js")}}"></script>
@endsection
