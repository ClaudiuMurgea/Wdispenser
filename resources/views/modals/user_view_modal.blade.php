<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModal" style="display: none;" aria-hidden="true">
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
                        <div class="form-group">
                            <label>Login Name</label>
                            <span class="form-control" id="view_login_name"></span>
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <span class="form-control" id="view_admin_first_name"></span>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <span class="form-control" id="view_admin_last_name"></span>
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <span class="form-control" id="view_mobile"></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <span class="form-control" id="view_email"></span>
                        </div>
                        <div class="form-group">
                            <label>MAC</label>
                            <span class="form-control" id="view_mac"></span>
                        </div>
                        <div class="form-group">
                            <label>Can Log Back</label>
                            <span class="form-control" id="edit_can_log_back"></span>
                        </div>
                        <div class="form-group">
                            <label>Card</label>
                            <span class="form-control" id="view_card"></span>
                        </div>
                        <div class="form-group">
                            <label>Positin</label>
                            <span class="form-control" id="view_positin"></span>
                        </div>
                        <div class="form-group">
                            <label>Max Inactive Time</label>
                            <span class="form-control" id="view_user_max_inactive_time"></span>
                        </div>
                        
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