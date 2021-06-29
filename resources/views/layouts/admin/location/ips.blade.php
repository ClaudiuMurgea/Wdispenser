@extends('layouts.app')

@section('content')
    <div class="container container-fluid">
        <table class="table table-striped table-responsive-sm table-hover table-outline mb-0">
            <thead class="thead-dark">
            <tr>
                <th>Location Name</th>
                <th>location IP</th>
                <th>Server Type</th>
                <th>Sub Company</th>
            </tr>
            </thead>
            <tbody>
            @foreach($locationIps as $locationIp)
                <tr>
                    <td>{{ $locationIp['LocationName'] }}</td>
                    <td>{{ $locationIp['IP'] }}</td>
                    <td>{{ $locationIp['ServerType'] }}</td>
                    <td>{{ $locationIp['SubCompany'] }}</td>
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
