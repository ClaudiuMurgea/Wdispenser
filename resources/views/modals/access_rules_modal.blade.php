<div class="modal fade" id="accessRulesModal" tabindex="-1" aria-labelledby="accessRulesModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Access Rules for <span id="accessRulesFor" class="text-info font-weight-bold"></span></h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form id="access_rules_form" action="#" method="post">
                            @csrf
                            <div class="form-horizontal w-100 text-right">
                                <input type="button" class="btn btn-sm btn-warning" value="Clear All" onclick="formClearAll()">
                                <input type="button" class="btn btn-sm btn-success" value="Select All" onclick="formSelectAll()">
                            </div>
                            <div id="accessRulesRoot"></div>
                            <div id="templateNameDiv" style="display: none">
                                <hr/>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" class="form-control input-sm" id="templateNameInput" name="_template_name" placeholder="Template name">
                                            </div>
                                            <div class="col">
                                                <input type="button" class="btn btn-success" value="Save to templates" onclick="exportRestrictionsToTemplate('save')">
                                            </div>
                                            <div class="col">
                                                <input type="button" class="btn btn-secondary" value="Cancel" onclick="exportRestrictionsToTemplate('cancel')">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light" id="accessRulesModalFooter">
                <button type="button" class="btn btn-outline-primary" onclick="showTemplateNameInput()">Export to template</button>
                <div style="float: left">
                    <select class="btn btn-outline-info" id="restrictionsTemplateSelector" onchange="loadRestrictionsTemplate(this.value)">
                        <option value="">Import from template</option>
                    </select>
                </div>
                <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-success" type="button" onclick="saveUserRestrictions()">Save Restrictions</button>
            </div>
        </div>
    </div>
</div>