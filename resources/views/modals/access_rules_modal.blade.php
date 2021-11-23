<div class="modal fade" id="accessRulesModal" tabindex="-1" aria-labelledby="accessRulesModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Access Rules for <span id="access_rules_for"></span></h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal" id="access_rules_form" action="#" method="post">
                            @csrf

                            <div id="accessRulesRoot"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="accessRulesModalFooter">
                <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-success" type="button" onclick="saveUserRestrictions()">Save Restrictions</button>
            </div>
        </div>
    </div>
</div>