<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Location: 
                    <span class="font-weight-bold">
                        {{ $selectedLocationData['location_ip'] }} | 
                        {{ $selectedLocationData['server_type'] }} | 
                        {{ $selectedLocationData['location_name'] }}
                    </span>
                </h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form class="" action="#" id="user_edit_form" method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="edit_admin_name" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="edit_admin_name" name="edit_admin_name" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="edit_admin_passwd" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="edit_admin_passwd" name="edit_admin_passwd" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="edit_first_name" class="col-sm-3 col-form-label">First Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="edit_first_name" name="edit_first_name" placeholder="First Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="edit_last_name" class="col-sm-3 col-form-label">Last Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="edit_last_name" name="edit_last_name" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="edit_user_phone" class="col-sm-3 col-form-label">Mobile</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="edit_user_phone" name="edit_user_phone" placeholder="Mobile">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="edit_user_email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="edit_user_email" name="edit_user_email" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="edit_mac_address" class="col-sm-3 col-form-label">MAC</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="edit_mac_address" name="edit_mac_address" placeholder="MAC">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="edit_can_log_back" class="col-sm-3 col-form-label">Can Log Back</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="edit_can_log_back" name="edit_can_log_back">
                                        <option value="null">Please select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="edit_user_card" class="col-sm-3 col-form-label">Card</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="edit_user_card" name="edit_user_card" placeholder="Card">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="edit_user_position" class="col-sm-3 col-form-label">Position</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="edit_user_position" name="edit_user_position">
                                        <option value="">Select Template</option>
                                    </select>
                                    {{-- <input type="text" class="form-control" id="edit_user_position" name="edit_user_position" placeholder="Position"> --}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="edit_user_max_inactive_time" class="col-sm-3 col-form-label">Max Inactive Time</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="edit_user_max_inactive_time" name="edit_user_max_inactive_time" placeholder="Max Inactive Time">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-success" onclick="updateUserData()">Save User</button>
            </div>
        </div>
    </div>
</div>