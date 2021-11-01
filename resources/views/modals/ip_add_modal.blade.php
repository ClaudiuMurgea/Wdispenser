<div class="modal fade" id="addIPModal" tabindex="-1" aria-labelledby="addIPModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add IP</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal" action="#" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="location_ip">IP</label>
                                <input type="text" class="form-control" id="location_ip" placeholder="Location IP">
                                <input type="button" class="btn btn-xs btn-warning" value="Validate">
                            </div>
                            <div class="form-group">
                                <label for="location_id">Location ID</label>
                                <input class="form-control" id="location_id" type="text" placeholder="Location ID">
                            </div>
                            <div class="form-group">
                                <label for="location_name">Location Name</label>
                                <input class="form-control" id="location_name" type="text" placeholder="Location Name">
                            </div>
                            <div class="form-group">
                                <label for="server_type">Server Type</label>
                                <select class="form-control" id="server_type" name="server_type" disabled="disabled">
                                    <option value="null">Please select</option>
                                    <option value="Master">Master</option>
                                    <option value="Slave" selected="selected">Slave</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="suyb_company">Sub Company</label>
                                <input class="form-control" id="sub_company" type="text" placeholder="Sub Company">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-success" type="button" onclick="addNewServer();">Save IP</button>
            </div>
        </div>
    </div>
</div>