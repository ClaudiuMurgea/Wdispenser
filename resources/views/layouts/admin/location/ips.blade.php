@extends('layouts.app')

@section('content')
    @if($allowAdd)
    <div class="container-fluid">
        <button class="btn btn-success mb-1" type="button" data-toggle="modal" data-target="#addIPModal">Add IP</button>
    </div>
    @endif
    <div class="container container-fluid">
        <table class="table table-striped table-responsive-sm table-hover table-outline mb-0">
            <thead class="thead-dark">
            <tr>
                <th>Location IP</th>
                <th>Location ID</th>
                <th>Location Name</th>
                <th>Server Type</th>
                <th>Sub Company</th>
            </tr>
            </thead>
            <tbody>
            @foreach($locationIps as $locationIp)
                <tr>
                    <td>{{ $locationIp['IP'] }}</td>
                    <td>{{ $locationIp['ID'] }}</td>
                    <td>{{ $locationIp['LocationName'] }}</td>
                    <td>{{ $locationIp['ServerType'] }}</td>
                    <td>{{ $locationIp['SubCompany'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @include('modals.ip_add_modal');
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

        $("#location_ip").on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                let insertedIpAddress = e.target.value;

                $.ajax({
                    method: "POST",
                    url: "ip/validate",
                    data: {ip_address: insertedIpAddress},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function(){
                        showLoadingOverlay();
                    },
                    success: function(data){
                        hideLoadingOverlay();

                        if(data.server_found){
                            console.log(data);

                            $("#location_id").val(data.location_id);
                            $("#location_name").val(data.location_name);
                            $("#sub_company").val(data.sub_company);
                        }
                        else{
                            toastr.options.timeOut = 5000;
                            toastr.options.positionClass = 'toast-top-center'
                            toastr.error(data.message, 'Error:')
                            return false;
                        }
                    },
                    error: function(){

                        hideLoadingOverlay();
                    }
                });

                if(!ValidateIPaddress(e)){
                    toastr.options.timeOut = 5000;
                    toastr.options.positionClass = 'toast-top-center'
                    toastr.error('Invalid IP address!', 'Errors:')
                    return false;
                }
            }


        });

        function ValidateIPaddress(ipaddress){
            var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
            
            return true;
            // if(ipaddress.match(ipformat)){
            //     console.log("ip ok");
            //     return true;
            // }
            // else{
            //     console.log("ip nok");
            //     return false;
            // }
        }


        function privateAlert(){
            toastr.options.timeOut = 5000;
            toastr.options.positionClass = 'toast-top-center'
            toastr.error('Invalid IP address!', 'Error:')
        }

        function addNewServer(){
            
        }
    </script>
@endsection
