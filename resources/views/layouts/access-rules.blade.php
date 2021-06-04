@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <a href="{{ route('register') }}" class="btn btn-secondary mb-1" type="button" >Add User</a>
    </div>
    <div class="container container-fluid">
        <table class="table table-responsive-sm table-hover table-outline mb-0>
            <thead class="thead-light">
            <tr>
                <th>Username</th>
                <th>Date registered</th>
                <th>Role</th>
                <th>API Token</th>
                <th>Status/Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user['name'] }}</td>
                <td>{{ date('d-m-Y', strtotime($user['created_at'])) }}</td>
                <td>User</td>
                <td>
                    <span id="token_for_{{ $user['id'] }}">***************************</span>
                    <svg class="c-icon float-right" id="copy_for_{{ $user['id'] }}" style="display: none" onclick="copyToClipboard({{ $user['id'] }})">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-copy') }}"></use>
                    </svg>
                </td>
                <td>
                    <form method="POST" action="#">
                        @csrf

                        <input type="button" class="btn btn-sm btn-warning" onclick="resetApiKey({{ $user['id'] }}, this.form._token.value);" value="Reset/Generate Key">
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        function resetApiKey(id, token){
            $.ajax({
                method: "POST",
                url: "user/reset_api_token",
                data: {id: id},
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': token
                }
            }).done(function(response){
                $("#token_for_"+id).html(response.token);

                $("#copy_for_"+id).css("display", "block");
            });
        }

        function copyToClipboard(id){
            var copyText = $("#token_for_"+id).text();

            navigator.clipboard.writeText(copyText);

            $("#token_for_"+id).css("color", "green");
        }
    </script>
@endsection
