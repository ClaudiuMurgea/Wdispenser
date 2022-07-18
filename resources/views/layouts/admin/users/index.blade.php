@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div style="display:flex; justify-content: space-between" class="pt-4">
            <div>
                <h2 class="pb-4">All Users</h2>
            </div>
            <div>
                <a style="width:100px;font-weight:bold;" href="{{ route('create_user') }}" class="btn btn-primary mb-1" onclick="showLoadingOverlay()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Add
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <table class="table table-sm table-responsive-sm table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th style="width:5%;text-align:center;">                ID          </th>
                    <th style="width:25%;" class="pl-3">                    Full Name   </th>
                    <th style="width:25%;" class="pl-3">                    Username    </th>
                    <th style="width:25;"  class="pl-3">                    Email       </th>
                    <th style="width:5%;text-align:center;">                Role        </th>
                    <th style="width:15%;text-align:center;" class="pl-3">  Action      </th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td style="vertical-align:middle;text-align:center;">   {{ $user->id }}         </td>
                        <td style="vertical-align:middle" class="pl-3">         {{ $user->name }}       </td>
                        <td style="vertical-align:middle" class="pl-3">         {{ $user->username }}   </td>
                        <td style="vertical-align:middle" class="pl-3">         {{ $user->email }}      </td>
                        <td style="vertical-align:middle;text-align:center;">
                            @if($user->is_admin)
                                Admin
                            @else
                                User
                            @endif
                        </td>
                        <td  style="display:flex; justify-content:space-between;">
                            <div style="margin-left:2rem;" class="btn-group btn-sm">
                                <a style="width:100px;" href="{{ route('edit_user', ['id' => $user->id]) }}" class="btn btn-sm btn-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon><line x1="3" y1="22" x2="21" y2="22"></line></svg>
                                    Edit
                                </a>
                            </div>
                            <div style="margin-right:2rem;" class="btn-group btn-sm">
                                <form action="{{ route('delete_user', ['user' => $user->id]) }}">
                                    @csrf
                                    <button style="width:100px;" type="submit" class="btn btn-sm btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        Delete
                                    </button>
                                </form>
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
