<div class="modal fade" id="addAccessRulesTemplateModal" tabindex="-1" aria-labelledby="addAccessRulesTemplateModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New access rules template</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal" id="accessRulesTemplateForm" action="#" method="post">
                            @csrf

                            <input type="text" class="form-control input-sm" id="templateNameInput" name="_template_name" placeholder="Template name">
                            <hr/>
                            <div class="w-100 text-right">
                                <input type="button" class="btn btn-sm btn-warning" value="Clear All" onclick="formClearAll()">
                                <input type="button" class="btn btn-sm btn-success" value="Select All" onclick="formSelectAll()">
                            
                            </div>
                            <div id="accessRulesRoot"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="addAccessRulesTemplateModalFooter">
                <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-success" type="button" onclick="saveRestrictionsTemplate()">Save Template</button>
            </div>
        </div>
    </div>
</div>
