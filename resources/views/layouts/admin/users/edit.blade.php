@extends('layouts.app')
@section('content')

<div style="background-color: #fff; border: 1px solid #bbb; border-radius:6px;" class="container mt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb pb-4">
                <div class="pull-left">
                    <h2 class="pt-4">Edit User</h2>
                </div>
            </div>
        </div>
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Invalid data submited!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('update_user', $user->id) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label style="font-weight:bold" for="username"> Username </label>
                        <input class="form-control" type="text" name="username" value="{{ $user->username }}">
                    </div>

                    <div class="form-group">
                        <label style="font-weight:bold" for="name">Full Name</label>
                        <input class="form-control" type="text" name="name" value="{{ $user->name }}">
                    </div>

                    <div class="form-group">
                        <label style="font-weight:bold" for="email">Email</label>
                        <input class="form-control" type="text" name="email" value="{{ $user->email }}">
                    </div>

                    <div class="form-group">
                        <label style="font-weight:bold" for="password">Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Password...">
                    </div>

                    <div class="form-group">
                        <label style="font-weight:bold" for="confirm">Confirm Password</label>
                        <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password...">
                    </div>

                    <div class="form-group pb-2">
                        <label style="font-weight:bold" for="roles">User Role</label>
                        <select style="font-weight:bold" class="form-control" name="roles">
                            @foreach ($roles as $role)
                                <option value="{{$role}}" {{ $user->is_admin != "1" ? 'selected' : '' }}>
                                {{$role}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display:flex; justify-content:space-between; width:100%;" class="text-center pb-4">
                        <div class="pull-right">
                            <a style="width:100px" class="btn btn-primary" href="{{ route('users_list') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><line x1="20" y1="12" x2="4" y2="12"></line><polyline points="10 18 4 12 10 6"></polyline></svg>
                                Back
                            </a>
                        </div>

                        <div>
                            <button style="width:100px !important; margin:0 auto; width:fit-content" type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Ionut Code Removed --}}
    {{-- {!! Form::model($user, ['method' => 'PATCH','route' => ['update_user', $user->id]]) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Username:</strong>
                {!! Form::text('username', null, array('placeholder' => 'Username','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Full Name:</strong>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Password:</strong>
                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Confirm Password:</strong>
                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                {!! Form::select('role', $roles, $userRole, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
{!! Form::close() !!} --}}
</div>
@endsection
