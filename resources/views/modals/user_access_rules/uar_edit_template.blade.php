<div class="modal fade" id="editAccessRulesTemplateModal" tabindex="-1" aria-labelledby="editAccessRulesTemplateModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edt access rules template.</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal" id="accessRulesEditTemplateForm" action="#" method="post">
                            @csrf
                            <div class="form-group row">
                                <input type="text" class="form-control input-sm bg-light text-info font-weight-bold" id="templateNameEdit" name="template_name" value="" readonly>
                            </div>
                            <div class="w-100 text-right">
                                <input type="button" class="btn btn-sm btn-warning" value="Clear All" onclick="formClearAll()">
                                <input type="button" class="btn btn-sm btn-success" value="Select All" onclick="formSelectAll()">
                            
                            </div>
                            <div id="editAccessRulesRoot"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="addAccessRulesTemplateModalFooter">
                <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-sm btn-success" type="button" onclick="updateRestrictionsTemplate()">Update Template</button>
            </div>
        </div>
    </div>
</div>
