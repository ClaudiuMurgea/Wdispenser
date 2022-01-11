@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <input type="button" class="btn btn-success mb-1" value="Add template" onclick="initTemplate()">
        <a href="{{ route('users_list', ['locationId' => 0]) }}" class="btn btn-warning mb-1" onclick="showLoadingOverlay()" >Users List</a>
    </div>
    <br/>
    <div class="container container-fluid">
        <table class="table table-sm table-striped table-responsive-sm table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th class="col-md-2">Name</th>
                    <th class="col-md-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $template)
                    <tr>
                        <td class="col-md-2">{{ $template['TemplateName'] }}</td>
                        <td class="col-md-2">
                            <div class="btn-group btn-group-lg btn-group-sm mb-3">
                                {{-- <input type="button" class="btn btn-sm btn-success" value="View" onclick="openViewRestrictionsTemplateModal('{{ $template['TemplateName'] }}', '{{ csrf_token() }}')"> --}}
                                <input type="button" class="btn btn-sm btn-warning" value="Edit" onclick="openEditRestrictionsTemplateModal('{{ $template['TemplateName'] }}', '{{ csrf_token() }}')">
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('modals.user_access_rules.uar_add_template')
    @include('modals.user_access_rules.uar_edit_template')
@endsection

@section('scripts')
    <script type="text/javascript">
        function initTemplate(){
            $.ajax({
                method: "GET",
                headers: {
                    Accept: "application/json"
                },
                beforeSend: function(){
                    showLoadingOverlay();
                },
                url: '{{ route('access_rules_defaults') }}',
                success: (response) => {
                    let accessRulesHtml = '';
                    $('#addAccessRulesTemplateModal').modal();

                    accessRulesHtml = buildTreeMenu(response, accessRulesHtml);

                    $("#accessRulesRoot").html(accessRulesHtml);
                    activateTreemenu();

                    $("#templateNameInput").val('');
                },
                error: (response) => {
                    console.error(response);
                },
                complete: (r) => {
                    hideLoadingOverlay();
                }
            });
        }

        function activateTreemenu(){
            var toggler = document.getElementsByClassName("caret");
            var i;

            for (i = 0; i < toggler.length; i++) {
                toggler[i].addEventListener("click", function() {
                    this.parentElement.querySelector(".nested").classList.toggle("active");
                    this.classList.toggle("caret-down");
                });
            }
        }

        function buildTreeMenu(data, tree, selector = 'DefaultValue') {
            // selector => DefaultValue or UserValue
            if (Object.keys(data).length > 0) {
                if(tree == ''){
                    tree += '<ul id="editAccessRulesList">';
                }
                else{
                    tree += '<ul class="nested">';
                }
                $.each(data, function(key, value){
                    if(typeof value.children !== 'undefined'){
                        if(value.Type == 'ShowHide'){ // checkbox
                            if(value[selector] == 'Show'){
                                tree += '<li>';
                                    tree += '<span class="caret"></span>';
                                    tree += '<input type="checkbox" checked="checked" name="' + value.f_name + '" /> ' + value.r_name + '';
                            }
                            else{
                                tree += '<li>';
                                tree += '<span class="caret"></span>';
                                tree += '<input type="checkbox" name="' + value.f_name + '" /> ' + value.r_name + '';
                            }
                        }
                        else if(value.Type == 'CheckList'){// multiple cb`s
                            //console.log('CheckList');
                        }
                        else if(value.Type == 'Choice'){ // select
                            // user restriction not set
                            tree += '<li>';
                                tree += '<li>';
                                tree += '<span class="caret"></span>';
                                tree += ' <span color="black">' + value.r_name + '</span>';
                                tree += '<ul><select name="' + value.f_name + '">';
                                tree += '<option value="null" >Select</option>';
                                $.each(value.additional, function(k, aditional){
                                    if(value[selector] == aditional){
                                        tree += '<option selected="selected" value="'+aditional+'">' + aditional + '</option>';
                                    }
                                    else{
                                        tree += '<option value="'+aditional+'">' + aditional + '</option>';
                                    }
                                });
                                tree += '</select></ul>';
                        }

                        tree = buildTreeMenu(value.children, tree, selector);
                    }
                    else{// no children
                        if(value.Type == 'ShowHide'){ // checkbox
                            if(value[selector] == 'Show'){ // use user
                                tree += '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                tree += '<input type="checkbox" checked="checked" name="' + value.f_name + '" /> ';
                                tree += '<span title="' + value.Help + '">' + value.r_name + '</span>';
                            }
                            else{
                                tree += '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                tree += '<input type="checkbox" name="' + value.f_name + '" /> ';
                                tree += '<span title="' + value.Help + '">' + value.r_name + '</span>';
                            }
                        }
                        else if(value.Type == 'CheckList'){ // checkbox
                            tree += '<ul>';
                                $.each(value.additional, function(k, aditional){
                                    let cbIsChecked = '';
                                    if(value.UserValuesArray[aditional] != 'undefined' && value.UserValuesArray[aditional]) cbIsChecked = 'checked="checked"';

                                    tree += '<li>';
                                        tree += '<input type="checkbox" ' + cbIsChecked + ' id="' + value.f_name + aditional + '" name="' + value.f_name + '[]" value="' + aditional + '" /> ';
                                        tree += '<label style="margin-bottom:0; cursor:pointer" for="' + value.f_name + aditional + '">' + aditional + '</label>';
                                    tree += '</li>';
                                });
                            tree += '</ul>';
                        }
                        else if(value.Type == 'Choice'){ // select
                            tree += '<li>';
                                    tree += ' <span>' + value.r_name + '</span>';
                                    tree += '<ul><select name="' + value.f_name + '">';
                                    tree += '<option value="null" >Select</option>';
                                    $.each(value.additional, function(k, aditional){
                                        if(value[selector] == aditional){
                                            tree += '<option selected="selected" value="'+aditional+'">' + aditional + '</option>';
                                        }
                                        else{
                                            tree += '<option value="'+aditional+'">' + aditional + '</option>';
                                        }
                                    });
                                    tree += '</select></ul>';
                        }
                    }

                    tree += '</li>';
                });
                tree += '</ul>';
            }

            return tree;
        }

        function saveRestrictionsTemplate(){
            let formData = $("#accessRulesTemplateForm").serializeArray();
            $.ajax({
                method: "POST",
                headers: {
                    Accept: "application/json"
                },
                beforeSend: function(){
                    showLoadingOverlay();
                },
                url: '{{ route("access_rules_template_store") }}',
                data: formData,
                success: (response) => {
                    hideLoadingOverlay();

                    if(response.status){
                        toastr.options.timeOut = 5000;
                        toastr.options.positionClass = 'toast-top-center';
                        toastr.success('Restriction template created!', 'Succes:');

                        window.location.assign('{{ route("access_rules_templates") }}')
                    }
                    else{
                        toastr.options.timeOut = 5000;
                        toastr.options.positionClass = 'toast-top-center';
                        toastr.error(response.message, 'Error:');
                    }
                },
                error: (response) => {
                    toastr.options.timeOut = 5000;
                    toastr.options.positionClass = 'toast-top-center';
                    toastr.error('Server error!', 'Error:');
                }
            });
        }

        function formClearAll(){
            $('input[type=checkbox]').each(function(){ 
                this.checked = false;
            });

            $('select').each(function(){ 
                this.value = 'Hide';
            });
        }

        function formSelectAll(){
            $('input[type=checkbox]').each(function(){ 
                this.checked = true;
            });

            $('select').each(function(){ 
                this.value = '2 Days';
            });
        }

        function openEditRestrictionsTemplateModal(template, token){
            let url = '{{ route("access_rules_template", ["TemplateName" => "::TemplateName"]) }}';
            url = url.replace('::TemplateName', template);

            $.ajax({
                method: "GET",
                headers: {
                    Accept: "application/json"
                },
                beforeSend: function(){
                    showLoadingOverlay();
                },
                url: url,
                success: (response) => {
                    let accessRulesHtml = '';
                    $('#editAccessRulesTemplateModal').modal();

                    accessRulesHtml = buildTreeMenu(response.access_rules_tree, accessRulesHtml, 'UserValue');

                    $("#editAccessRulesRoot").html(accessRulesHtml);
                    $("#templateNameEdit").val(response.template_name);

                    activateTreemenu();
                },
                error: (response) => {
                    console.error(response);
                },
                complete: (r) => {
                    hideLoadingOverlay();
                }
            });
        }

        function updateRestrictionsTemplate(){
            let formData = $("#accessRulesEditTemplateForm").serializeArray();

            $.ajax({
                method: "PUT",
                headers: {
                    Accept: "application/json"
                },
                beforeSend: function(){
                    showLoadingOverlay();
                },
                url: '{{ route("access_rules_template_update") }}',
                data: formData,
                success: (response) => {
                    hideLoadingOverlay();

                    if(response.status){
                        toastr.options.timeOut = 5000;
                        toastr.options.positionClass = 'toast-top-center';
                        toastr.success('Restriction template created!', 'Succes:');

                        //window.location.assign('{{ route("access_rules_templates") }}')
                    }
                    else{
                        toastr.options.timeOut = 5000;
                        toastr.options.positionClass = 'toast-top-center';
                        toastr.error(response.message, 'Error:');
                    }
                },
                error: (response) => {
                    toastr.options.timeOut = 5000;
                    toastr.options.positionClass = 'toast-top-center';
                    toastr.error('Server error!', 'Error:');
                }
            });
        }

    </script>
@endsection