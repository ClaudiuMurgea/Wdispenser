@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-success mb-1" type="button" data-toggle="modal" data-target="#addUserModal">Add user</button>
    </div>
    <div class="container container-fluid">
        <div class="row">
            <div class="d-lg-table-cell col-sm-6">
                <span class="font-weight-bold">From location</span>
                <select class="form-control input-group-sm" onchange="updateFromLocation(this)">
                    @foreach($locations as $location)
                    <option value="{{ $location['LocationID'] }}" {{ $currentLocationId == $location['LocationID'] ? 'selected="selected"' : '' }}>{{ $location['IP'] }} | {{ $location['ServerType'] }} | {{ $location['LocationName'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-md-table-cell col-sm-6">
                <span class="font-weight-bold">To location</span>
                <select class="form-control input-group-sm" onchange="processAction(this)">
                    <option value="none">Select Action</option>
                    <optgroup label="Copy">
                        <option value="copy_to_location">Copy to location</option>
                    </optgroup>
                </select>
            </div>
        </div>
        <br/>
        <table class="table table-sm table-striped table-responsive-sm table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Login</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>MAC</th>
                    <th>Can Log Back</th>
                    <th>Card</th>
                    <th>Position</th>
                    <th>Select</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <form action="#" id="userSelectionForm" method="POST">
                    @csrf
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user['Login'] }}</td>
                            <td>{{ $user['FirstName'] }}</td>
                            <td>{{ $user['LastName'] }}</td>
                            <td>{{ $user['Mobile'] }}</td>
                            <td>{{ $user['Email'] }}</td>
                            <td>{{ $user['MAC'] }}</td>
                            <td>{{ $user['CanLogBack'] }}</td>
                            <td>{{ $user['Card'] }}</td>
                            <td>{{ $user['Position'] }}</td>
                            <td>
                                <input type="checkbox" class="form-check" name="user_{{ $user['ID'] }}" value="{{ $user['ID'] }}">
                            </td>
                            <td>
                                <div class="btn-group btn-group-lg btn-group-sm mb-3">
                                    <input type="button" class="btn btn-sm btn-success" value="View" data-id="show_{{ $user['ID'] }}" data-toggle="modal" data-target="#showUserModal" onclick="opeViewUserModal({{ $user['ID'] }}, '{{ csrf_token() }}')">
                                    <input type="button" class="btn btn-sm btn-warning" value="Edit" data-id="edit_{{ $user['ID'] }}" data-toggle="modal" data-target="#editUserModal" onclick="opeEditUserModal({{ $user['ID'] }}, '{{ csrf_token() }}')">
                                    <input type="button" class="btn btn-sm btn-danger" value="Access Rules">
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </form>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add user</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" action="#" method="post">
                                <div class="form-group">
                                    <label for="user_name">Username</label>
                                    <input class="form-control" id="user_name" type="text" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input class="form-control" id="first_name" type="text" placeholder="First Name">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input class="form-control" id="last_name" type="text" placeholder="Last Name">
                                </div>
                                <div class="form-group">
                                    <label for="user_phone">Mobile</label>
                                    <input class="form-control" id="user_phone" type="text" placeholder="Mobile">
                                </div>
                                <div class="form-group">
                                    <label for="user_email">Email</label>
                                    <input class="form-control" id="user_email" type="text" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="mac_address">MAC</label>
                                    <input class="form-control" id="mac_address" type="text" placeholder="MAC">
                                </div>
                                <div class="form-group">
                                    <label for="can_log_back">Can Log Back</label>
                                    <select class="form-control" id="select1" name="select1">
                                        <option value="null">Please select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="user_card">Card</label>
                                    <input class="form-control" id="user_card" type="text" placeholder="Card">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-sm btn-success" type="button">Save User</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showUserModal" tabindex="-1" aria-labelledby="showUserModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Show user</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="#">
                                <div class="form-group">
                                    <label for="show_user_name">Login</label>
                                    <span class="form-control" id="show_user_name" ></span>
                                </div>
                                <div class="form-group">
                                    <label for="show_first_name">First Name</label>
                                    <span class="form-control" id="show_first_name"></span>
                                </div>
                                <div class="form-group">
                                    <label for="show_last_name">Last Name</label>
                                    <span class="form-control" id="show_last_name"></span>
                                </div>
                                <div class="form-group">
                                    <label for="show_user_phone">Mobile</label>
                                    <span class="form-control" id="show_user_phone"></span>
                                </div>
                                <div class="form-group">
                                    <label for="show_user_email">Email</label>
                                    <span class="form-control" id="show_user_email"></span>
                                </div>
                                <div class="form-group">
                                    <label for="show_mac_address">MAC</label>
                                    <span class="form-control" id="show_mac_address"></span>
                                </div>
                                <div class="form-group">
                                    <label for="show_can_log_back">Can Log Back</label>
                                    <span class="form-control" id="show_can_log_back"></span>
                                </div>
                                <div class="form-group">
                                    <label for="show_user_card">Card</label>
                                    <span class="form-control" id="show_user_card"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit user</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" action="#" id="editUserForm" method="POST">
                                <div class="form-group">
                                    <label for="edit_user_name">Username</label>
                                    <input class="form-control" id="edit_user_name" type="text" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label for="edit_first_name">First Name</label>
                                    <input class="form-control" id="edit_first_name" type="text" placeholder="First Name">
                                </div>
                                <div class="form-group">
                                    <label for="edit_last_name">Last Name</label>
                                    <input class="form-control" id="edit_last_name" type="text" placeholder="Last Name">
                                </div>
                                <div class="form-group">
                                    <label for="edit_user_phone">Mobile</label>
                                    <input class="form-control" id="edit_user_phone" type="text" placeholder="Mobile">
                                </div>
                                <div class="form-group">
                                    <label for="edit_user_email">Email</label>
                                    <input class="form-control" id="edit_user_email" type="text" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="edit_mac_address">MAC</label>
                                    <input class="form-control" id="edit_mac_address" type="text" placeholder="MAC">
                                </div>
                                <div class="form-group">
                                    <label for="edit_can_log_back">Can Log Back</label>
                                    <select class="form-control" id="edit_can_log_back" name="select1">
                                        <option value="null">Please select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit_user_card">Card</label>
                                    <input class="form-control" id="edit_user_card" type="text" placeholder="Card">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="button">Save changes</button>
                </div>
            </div>
        </div>
    </div>

{{--    user copy modal --}}
    <div class="modal fade" id="copyUserModal" tabindex="-1" aria-labelledby="copyUserModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Copy user(s) to location(s)</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal" action="{{ route('copy_user') }}" id="copyUserForm" method="POST">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div id="copyModalLocations"></div>
                                <div id="copyModalUsers"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-danger" value="Copy" />
    {{--                    <button class="btn btn-danger" type="button" onclick="copyUsersToLocationsAction()">Copy</button>--}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function updateFromLocation(e){
            let selectedLocationId = e.value;

            let url = '{{ route("users_list", ["locationId" => "::locationId"]) }}';
            url = url.replace('::locationId', selectedLocationId);

            window.location.assign(url);
        }

        function processAction(e){
            if(e.value == 'copy_to_location'){
                let selectedUsers = {selected_users : $("#userSelectionForm").serializeArray()};

                $("#copyUserModal").modal('show');
                $("#copyModalLocations").html("");

                $.ajax({
                    method: 'GET',
                    url: '{{ URL::to("admin/locations/ip/json") }}',
                    headers: {
                        Accept: "application/json"
                    },
                    beforeSend: function(){

                    },
                    success: (response) => {
                        let rowHtml = '<table class="table table-sm table-responsive-sm">';

                        rowHtml += '<tr>' +
                            '<th>Location Name</th>' +
                            '<th>Location IP</th>' +
                            '<th>Sub Company</th>' +
                            '<th>Action</th>' +
                            '</tr>';

                        $.each(response, function(key, location){
                            rowHtml += '<tr>';
                                rowHtml += '<td>' + location.LocationName + '</td>';
                                rowHtml += '<td>' + location.IP + '</td>';
                                rowHtml += '<td>' + location.SubCompany + '</td>';
                                rowHtml += '<td>' +
                                        '<input type="checkbox" name="location_' + location.LocationID + '" value="' + location.LocationID + '" />' +
                                    '</td>';
                            rowHtml += '</tr>';
                        });
                        rowHtml += '</table>';

                        $("#copyModalLocations").html(rowHtml);

                        $.each(selectedUsers.selected_users, function(key, selectedUser){
                            $("#copyModalUsers").append('<input type="hidden" name="' + selectedUser.name + '" value="' + selectedUser.value + '" />');
                        });
                    }
                });

                e.value = 'none';
            }
        }

        function copyUsersToLocationsAction(){
            let formData = $("#copyUserForm").serializeArray();
            let token = $("#copyUserForm input[name=_token]").val();

            console.log(JSON.stringify(formData));

            $.ajax({
                method: "POST",
                headers: {
                    'X-CSRF-Token': token,
                    Accept: "application/json"
                },
                url: "user/copy",
                data: JSON.stringify(formData),
                success: () => window.location.assign("{{ route('users_list', ['locationId' => 0]) }}"),
                error: (response) => {

                }
            })


        }

        function opeViewUserModal(userId, token){
            $.ajax({
                method: 'GET',
                url: 'show/' + userId,
                headers: {
                    'X-CSRF-Token': token,
                    Accept: "application/json"
                },
                beforeSend: function(){
                    $('#loader').show();
                },
                success: (response) => {
                    $("#show_user_name").html(response.Login);
                    $("#show_first_name").html(response.FirstName);
                    $("#show_last_name").html(response.LastName);
                    $("#show_user_phone").html(response.Mobile);
                    $("#show_user_email").html(response.Email);
                    $("#show_mac_address").html(response.MAC);
                    $("#show_can_log_back").html(response.CanLogBack);
                    $("#show_user_card").html(response.Card);
                }
            })
        }

        function openEditUserModal(userId, token){
            console.log(userId);
        }

        $('#registerForm').submit(function (e) {
            e.preventDefault();
            let formData = $(this).serializeArray();
            $(".invalid-feedback").children("strong").text("");
            $("#registerForm input").removeClass("is-invalid");
            $.ajax({
                method: "POST",
                headers: {
                    Accept: "application/json"
                },
                url: "{{ route('register') }}",
                data: formData,
                success: () => window.location.assign("{{ route('dashboard') }}"),
                error: (response) => {
                    if(response.status === 422) {
                        let errors = response.responseJSON.errors;
                        Object.keys(errors).forEach(function (key) {
                            $("#" + key + "Input").addClass("is-invalid");
                            $("#" + key + "Error").children("strong").text(errors[key][0]);
                        });
                    } else {
                        window.location.reload();
                    }
                }
            })
        });
    </script>
@endsection
