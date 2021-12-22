<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add user for: 
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
                        <form class="form-horizontal" action="#" id="user_add_form" method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="login_name" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" style="text-transform: uppercase" id="login_name" name="login_name" autocomplete="off" placeholder="Admin Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="admin_passwd" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="admin_passwd" name="admin_passwd" autocomplete="off" placeholder="Admin Password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_phone" class="col-sm-3 col-form-label">Mobile</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="user_phone" name="user_phone" placeholder="Mobile">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="user_email" name="user_email" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mac_address" class="col-sm-3 col-form-label">MAC</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="mac_address" name="mac_address" placeholder="MAC">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="can_log_back" class="col-sm-3 col-form-label">Can Log Back</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="can_log_back" name="can_log_back">
                                        <option value="null">Please select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_card" class="col-sm-3 col-form-label">Card</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="user_card" name="user_card" placeholder="Card">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_position" class="col-sm-3 col-form-label">Position</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="user_position" name="user_position" placeholder="Position">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_max_inactive_time" class="col-sm-3 col-form-label">Max Inactive Time</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="user_max_inactive_time" name="max_inactive_time" placeholder="Max Inactive Time">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-success" onclick="saveNewUser()">Save User</button>
            </div>
        </div>
    </div>
</div>
