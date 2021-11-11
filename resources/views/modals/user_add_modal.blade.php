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
                            <div class="form-group">
                                <label for="user_name">Username</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="user_password">Password</label>
                                <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label for="user_phone">Mobile</label>
                                <input type="text" class="form-control" id="user_phone" name="user_phone" placeholder="Mobile">
                            </div>
                            <div class="form-group">
                                <label for="user_email">Email</label>
                                <input type="text" class="form-control" id="user_email" name="user_email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="mac_address">MAC</label>
                                <input type="text" class="form-control" id="mac_address" name="mac_address" placeholder="MAC">
                            </div>
                            <div class="form-group">
                                <label for="can_log_back">Can Log Back</label>
                                <select class="form-control" id="can_log_back" name="can_log_back">
                                    <option value="null">Please select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="user_card">Card</label>
                                <input type="text" class="form-control" id="user_card" name="user_card" placeholder="Card">
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