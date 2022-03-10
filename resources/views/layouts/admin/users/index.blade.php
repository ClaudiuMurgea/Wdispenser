@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <a href="{{ route('create_user') }}" class="btn btn-success mb-1" onclick="showLoadingOverlay()"  >Add User</a>
    </div>
    <br/>
    <div class="container-fluid">
        <table class="table table-sm table-responsive-sm table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Full Name</th>
                    <th>username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ $user->is_admin }}
                        </td>
                        <td>
                            <div class="btn-group btn-sm">
                                <a href="{{ route('edit_user', ['id' => $user->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
@endsection

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            hideLoadingOverlay();
        });
    </script>
@endsection
