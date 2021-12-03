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
                        <form class="form-horizontal" action="#" id="user_edit_form" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="edit_admin_name">Admin Name</label>
                                <input type="text" class="form-control" id="edit_admin_name" name="edit_admin_name" placeholder="Admin Name">
                            </div>
                            <div class="form-group">
                                <label for="edit_admin_passwd">Admin Password</label>
                                <input type="password" class="form-control" id="edit_admin_passwd" name="edit_admin_passwd" placeholder="Admin Password">
                            </div>
                            <div class="form-group">
                                <label for="edit_first_name">First Name</label>
                                <input type="text" class="form-control" id="edit_first_name" name="edit_first_name" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label for="edit_last_name">Last Name</label>
                                <input type="text" class="form-control" id="edit_last_name" name="edit_last_name" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label for="edit_user_phone">Mobile</label>
                                <input type="text" class="form-control" id="edit_user_phone" name="edit_user_phone" placeholder="Mobile">
                            </div>
                            <div class="form-group">
                                <label for="edit_user_email">Email</label>
                                <input type="text" class="form-control" id="edit_user_email" name="edit_user_email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="edit_mac_address">MAC</label>
                                <input type="text" class="form-control" id="edit_mac_address" name="edit_mac_address" placeholder="MAC">
                            </div>
                            <div class="form-group">
                                <label for="edit_can_log_back">Can Log Back</label>
                                <select class="form-control" id="edit_can_log_back" name="edit_can_log_back">
                                    <option value="null">Please select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_user_card">Card</label>
                                <input type="text" class="form-control" id="edit_user_card" name="edit_user_card" placeholder="Card">
                            </div>
                            <div class="form-group">
                                <label for="edit_user_position">Position</label>
                                <input type="text" class="form-control" id="edit_user_position" name="edit_user_position" placeholder="Position">
                            </div>
                            <div class="form-group">
                                <label for="edit_user_max_inactive_time">Max Inactive Time</label>
                                <input type="text" class="form-control" id="edit_user_max_inactive_time" name="edit_user_max_inactive_time" placeholder="Max Inactive Time">
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