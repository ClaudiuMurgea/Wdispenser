@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <button class="btn btn-success mb-1" type="button" data-toggle="modal" data-target="#addUserModal" onclick="clearUserAddForm()">Add user</button>
    </div>
    <div class="container container-fluid">
        <div class="row">
            <div class="d-lg-table-cell col-sm-6">
                <span class="font-weight-bold">From location</span>
                <select class="form-control input-group-sm" id="selected_location_id" onchange="updateFromLocation(this)">
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
                            <td>{{ $user->Login }}</td>
                            <td>{{ $user->FirstName }}</td>
                            <td>{{ $user->LastName }}</td>
                            <td>{{ $user->Mobile }}</td>
                            <td>{{ $user->Email }}</td>
                            <td>{{ $user->MAC }}</td>
                            <td>{{ $user->CanLogBack }}</td>
                            <td>{{ $user->Card }}</td>
                            <td>{{ $user->Position }}</td>
                            <td>
                                <input type="checkbox" class="form-check" name="user_{{ $user->ID }}" value="{{ $user->ID }}">
                            </td>
                            <td>
                                <div class="btn-group btn-group-lg btn-group-sm mb-3">
                                    <input type="button" class="btn btn-sm btn-success" value="View" data-id="show_{{ $user->ID }}" data-toggle="modal" data-target="#viewUserModal" onclick="openViewUserModal({{ $user->ID }}, '{{ csrf_token() }}')">
                                    <input type="button" class="btn btn-sm btn-warning" value="Edit" data-id="edit_{{ $user->ID }}" data-toggle="modal" data-target="#editUserModal" onclick="openEditUserModal({{ $user->ID }}, '{{ csrf_token() }}')">
                                    <input type="button" class="btn btn-sm btn-danger" value="Access Rules" data-id="rules_{{ $user->ID }}" data-toggle="modal" data-target="#accessRulesModal" onclick="openAccessRulesModal({{ $user->ID }}, '{{ csrf_token() }}')">
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </form>
            </tbody>
        </table>
    </div>
    @include('modals.user_add_modal')
    @include('modals.user_view_modal')
    @include('modals.user_edit_modal')
    @include('modals.access_rules_modal')

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
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function updateFromLocation(e){
            let selectedLocationId = e.value;

            $('#loader').show();
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

        function openViewUserModal(userId, token){
            let locationId = $("#selected_location_id").val();

            $.ajax({
                method: 'GET',
                url: 'show/' + locationId + '/' + userId,
                headers: {
                    'X-CSRF-Token': token,
                    Accept: "application/json"
                },
                beforeSend: function(){
                    $('#loader').show();
                },
                success: (response) => {
                    $("#view_login_name").html(response.edit_admin_name);
                    $("#view_admin_first_name").html(response.edit_first_name);
                    $("#view_admin_last_name").html(response.edit_last_name);
                    $("#view_mobile").html(response.edit_user_phone);
                    $("#view_email").html(response.edit_user_email);
                    $("#view_mac").html(response.edit_mac_address);
                    $("#edit_can_log_back").html(response.edit_can_log_back);
                    $("#view_card").html(response.edit_user_card);
                    $("#view_positin").html(response.edit_user_position);
                    $("#view_user_max_inactive_time").html(response.edit_user_max_inactive_time);
                }
            })
        }

        function openEditUserModal(userId, token){
            // clear form first
            $('#user_edit_form').each(function() { this.reset() });

            // get user data
            let locationId = $("#selected_location_id").val();
            let url = "show/" + locationId + '/' + userId;

            $.ajax({
                method: "GET",
                headers: {
                    Accept: "application/json"
                },
                url: url,
                success: (response) => {
                    $('#user_edit_form :input').each(function() {
                        var input = $(this);

                        $.each(response, function(fName, fValue){
                            if(input.attr('name') == fName){
                                input.val(fValue);
                            }
                        });

                    });
                },
                error: (response) => {
                    console.error(response);
                }
            });
        }

        function openAccessRulesModal(userId, token){
            let locationId = $("#selected_location_id").val();
            let url = "access_rules/" + locationId + '/' + userId;

            $.ajax({
                method: "GET",
                headers: {
                    Accept: "application/json"
                },
                url: url,
                success: (response) => {
                    let accessRulesHtml = '';
                    accessRulesHtml = buildTreeMenu(response, accessRulesHtml);

                    $("#accessRulesRoot").html(accessRulesHtml);
                    activateTreemenu();
                    
                    $('<input>').attr({type: 'hidden', id: 'hUserId', name: 'userId', value: userId}).appendTo('#accessRulesModalFooter');
                    $('<input>').attr({type: 'hidden', id: 'hLocationId', name: 'locationId', value: locationId}).appendTo('#accessRulesModalFooter');
                },
                error: (response) => {
                    console.error(response);
                }
            });
        }

        function activateTreemenu(){
            var toggler = document.getElementsByClassName("caret");
            var i;

            for (i = 0; i < toggler.length; i++) {
                toggler[i].addEventListener("click", function() {
                    this.parentElement.querySelector(".nested").classList.toggle("active");
                    this.classList.toggle("caret-down");
                });
            }
        }

        function buildTreeMenu(data, tree) {
            if (Object.keys(data).length > 0) {
                if(tree == ''){
                    tree += '<ul id="accessRulesList">';
                }
                else{
                    tree += '<ul class="nested">';
                }
                    $.each(data, function(key, value){
                        if(typeof value.children !== 'undefined'){
                            if(value.Type == 'ShowHide'){ // checkbox
                                if(value.UserValue == ''){// user restriction not set -> unchecked
                                    tree += '<li>';
                                        tree += '<span class="caret"></span>';
                                        tree += '<input type="checkbox" name="' + value.f_name + '" /> ';
                                        tree += '<span title="' + value.Help + '" style="color: red">' + value.r_name + '</span>';
                                }
                                else{
                                    if(value.UserValue == 'Show'){
                                        tree += '<li>';
                                            tree += '<span class="caret"></span>';
                                            tree += '<input type="checkbox" checked="checked" name="' + value.f_name + '" /> ' + value.r_name + '';
                                    }
                                    else{
                                        tree += '<li>';
                                        tree += '<span class="caret"></span>';
                                        tree += '<input type="checkbox" name="' + value.f_name + '" /> ' + value.r_name + '';
                                    }
                                }
                            }
                            else if(value.Type == 'CheckList'){// multiple cb`s
                                console.log(value);
                            }
                            else if(value.Type == 'Choice'){ // select
                                if(value.UserValue == ''){// user restriction not set
                                console.log(value);
                                    tree += '<li>';
                                        tree += '<li>';
                                        tree += '<span class="caret"></span>';
                                        tree += ' <span color="red">' + value.r_name + '</span>';
                                        tree += '<ul><select name="' + value.f_name + '">';
                                        tree += '<option value="null" >Select</option>';
                                        $.each(value.additional, function(k, aditional){
                                            if(value.DefaultValue == aditional){
                                                tree += '<option selected="selected" value="'+aditional+'">' + aditional + '</option>';
                                            }
                                            else{
                                                tree += '<option value="'+aditional+'">' + aditional + '</option>';
                                            }
                                        });
                                        tree += '</select></ul>';
                                }
                                else{
                                    tree += '<li>';
                                        tree += '<span class="caret"></span>';
                                        tree += ' <span>' + value.r_name + '</span>';
                                        tree += '<ul><select name="' + value.f_name + '">';
                                        tree += '<option value="null" >Select</option>';
                                        $.each(value.additional, function(k, aditional){
                                            if(value.UserValue == aditional){
                                                tree += '<option selected="selected" value="'+aditional+'">' + aditional + '</option>';
                                            }
                                            else{
                                                tree += '<option value="'+aditional+'">' + aditional + '</option>';
                                            }
                                        });
                                        tree += '</select></ul>';
                                }
                            }

                            tree = buildTreeMenu(value.children, tree);
                        }
                        else{// no children
                            if(value.Type == 'ShowHide'){ // checkbox
                                if(value.UserValue == ''){// user restriction not set
                                    tree += '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    tree += '<input type="checkbox" name="' + value.f_name + '" /> ';
                                    tree += '<span title="' + value.Help + '" style="color: red">' + value.r_name + '</span>';
                                }
                                else{
                                    if(value.UserValue == 'Show'){ // use user
                                        tree += '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        tree += '<input type="checkbox" checked="checked" name="' + value.f_name + '" /> ';
                                        tree += '<span title="' + value.Help + '">' + value.r_name + '</span>';
                                    }
                                    else{
                                        tree += '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        tree += '<input type="checkbox" name="' + value.f_name + '" /> ';
                                        tree += '<span title="' + value.Help + '">' + value.r_name + '</span>';
                                    }
                                }
                            }
                            else if(value.Type == 'CheckList'){ // checkbox
                                tree += '<ul>';
                                if(value.UserValue == '' && false){// user restriction not set
                                    $.each(value.additional, function(k, aditional){
                                        tree += '<li>';
                                            tree += '<input type="checkbox" name="' + value.f_name + '" value="' + aditional + '" /> ';
                                            tree += aditional;
                                        tree += '</li>';
                                    });
                                }
                                else{
                                    $.each(value.additional, function(k, aditional){
                                        tree += '<li>';
                                            tree += '<input type="checkbox" id="' + value.f_name + aditional + '" name="' + value.f_name + '[]" value="' + aditional + '" /> ';
                                            tree += '<label style="margin-bottom:0; cursor:pointer" for="' + value.f_name + aditional + '">' + aditional + '</label>';
                                        tree += '</li>';
                                    });
                                }
                                tree += '</ul>';
                            }
                            else if(value.Type == 'Choice'){ // select
                                
                            }
                        }

                        tree += '</li>';
                    });
                tree += '</ul>';
            }

            return tree;
        }

        function saveUserRestrictions(){
            let formData = $("#access_rules_form").serializeArray();
            let userId = $("#hUserId").val();
            let locationId = $("#hLocationId").val();

            let url = "access_rules/" + locationId + '/' + userId;

            $.ajax({
                method: "POST",
                headers: {
                    Accept: "application/json"
                },
                beforeSend: function(){
                    showLoadingOverlay();
                },
                url: url,
                data: formData,
                success: (response) => {
                    console.log(response);

                    if(response.status){
                        toastr.options.timeOut = 5000;
                        toastr.options.positionClass = 'toast-top-center';
                        toastr.success('User restriction updated!', 'Succes:');
                    }
                    else{
                        toastr.options.timeOut = 5000;
                        toastr.options.positionClass = 'toast-top-center';
                        toastr.error('Server error: ', 'Error:');
                    }

                    window.location.assign('{{ route("users_list", ["locationId" => "0"]) }}')
                },
                error: (response) => {
                    console.log(response);
                    
                    toastr.options.timeOut = 5000;
                    toastr.options.positionClass = 'toast-top-center';
                    toastr.error('Server error!', 'Error:');
                }
            });
        }

        function saveNewUser(serverId){
            let formData = $("#user_add_form").serializeArray();
            let locationId = $("#selected_location_id").val();
            
            let url = '{{ route("add_user", ["locationId" => "::locationId"]) }}';
            url = url.replace('::locationId', locationId);

            $.ajax({
                method: "POST",
                headers: {
                    Accept: "application/json"
                },
                url: url,
                data: formData,
                success: (response) => {
                    console.log(response);

                    if(response.status){
                        toastr.options.timeOut = 5000;
                        toastr.options.positionClass = 'toast-top-center';
                        toastr.success('User recorded!', 'Succes:');
                    }
                    else{
                        toastr.options.timeOut = 5000;
                        toastr.options.positionClass = 'toast-top-center';
                        toastr.error('Server error: ', 'Error:');
                    }
                },
                error: (response) => {
                    console.log(response);
                    
                    toastr.options.timeOut = 5000;
                    toastr.options.positionClass = 'toast-top-center';
                    toastr.error('Server error!', 'Error:');
                }
            });

            //console.log(formData);
        }

        function clearUserAddForm(){
            $('#user_add_form').each(function() { this.reset() });
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
