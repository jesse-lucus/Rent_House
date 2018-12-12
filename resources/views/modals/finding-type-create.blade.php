<template class="uk-hidden" id="form-finding-type-followup-template">
    <div class="form-default-followup" uk-grid>
        <div class="uk-width-1-6 uk-margin-small-top uk-margin-small-bottom">
            <input type="number" min="1" max="31" value="1" class="uk-form-small followup-number" style="height: 20px;">
        </div>
        <div class="uk-width-1-6 uk-margin-small-top uk-margin-small-bottom">
            <select class="uk-select uk-form-small followup-duration">
                <option value="hours">Hours</option>
                <option value="days">Days</option>
                <option value="weeks">Weeks</option>
                <option value="months">Months</option>
            </select>
        </div>
        <div class="uk-width-1-6 uk-margin-small-top uk-margin-small-bottom">
            <select class="uk-select uk-form-small followup-assignment">
                <option value="lead">Lead Auditor</option>
                <option value="pm">Property Manager</option>
                <option value="user">User Creating Finding</option>
            </select>
        </div>
        <div class="uk-width-1-2  uk-margin-small-top uk-margin-small-bottom">
            <input type="text" value="" placeholder="Description" class="uk-input uk-form-small followup-description">
        </div>
        <div class="uk-width-1-6  uk-margin-small-top">
            <label><input class="uk-checkbox followup-reply" type="checkbox" value="1" > Reply</label><br /><br />
            <button class="uk-button uk-button-default uk-button-small" onclick="removeFollowUp(this);return false;"><span uk-icon="minus-circle" class="form-title-icon uk-icon"></span> Remove</button>
        </div>
        <div class="uk-width-1-6  uk-margin-small-top">
            <label><input class="uk-checkbox followup-photo" type="checkbox" value="1" > Add a photo</label>
        </div>
        <div class="uk-width-1-6  uk-margin-small-top">
            <label><input class="uk-checkbox followup-doc" type="checkbox" value="1" > Upload a doc</label>
        </div>
        <div class="uk-width-1-2  uk-margin-small-top">
            @if(count($document_categories))
            <div class="uk-width-1-1 uk-width-2-3@m uk-scrollable-box" style="width:100%; height:100px;">
                <ul class="uk-list">
                    @foreach($document_categories as $cat)
                    <li><label><input class="uk-checkbox followup-cat" type="checkbox" name="categories[]" value="{{$cat->id}}"> {{$cat->document_category_name}}</label></li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</template>

        <div>
            <h2 id="post-response" class="uk-margin-top">@if(!$finding_type)<span uk-icon="plus-circle" class="form-title-icon"></span>@else<span uk-icon="edit" class="form-title-icon"></span>@endif Create Finding Type</h2>
            <hr />
            <form action="/admin/findingtype/store" method="post" target="_blank">
                {{ csrf_field() }}
                
                <div class="uk-form-row">
                    <div class="uk-grid">
                        <label for="name" class="uk-width-1-1 uk-width-1-3@m">Name: </label>
                        <input id="name" type="text" name="name" value="@if($finding_type){{$finding_type->name}}@endif" placeholder="Enter the finding type name" class="uk-input uk-width-1-1 uk-width-2-3@m" required>
                    </div>
                </div>

                <div class="uk-form-row">
                    <div class="uk-grid">
                        <label for="type" class="uk-width-1-1 uk-width-1-3@m">Type: </label>
                        <div class="uk-width-2-3">
                            <label><input class="uk-radio" type="radio" name="type" value="nlt" checked> NLT</label>
                            <label><input class="uk-radio" type="radio" name="type" value="lt"> LT</label>
                            <label><input class="uk-radio" type="radio" name="type" value="file"> FILE</label>
                        </div>
                    </div>
                </div>

                <div class="uk-form-row">
                    <div class="uk-grid">
                        <label for="type" class="uk-width-1-1 uk-width-1-3@m">Default Boilerplates: </label>
                        @if(count($boilerplates))
                        <div class="uk-width-1-1 uk-width-2-3@m uk-scrollable-box">
                            <ul class="uk-list">
                                @foreach($boilerplates as $boilerplate)
                                <li><label><input class="uk-checkbox" type="checkbox" name="boilerplates[]" value="{{$boilerplate->id}}" checked> {{$boilerplate->name}}</label></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>

                <hr />

                <div class="uk-form-row">
                    <div class="uk-grid">
                        <label for="nominal" class="uk-width-1-1 uk-width-1-2@m">Nominal Item Weight %: </label>
                        <input id="nominal_item_weight" type="text" name="nominal_item_weight" value="@if($finding_type){{$finding_type->nominal_item_weight}}@endif" placeholder="Enter the nominal item weight %" class="uk-input uk-width-1-1 uk-width-1-2@m">
                    </div>
                </div>

                <div class="uk-form-row">
                    <div uk-grid>
                        <label for="criticality" class="uk-width-1-1 uk-width-1-2@m">Criticality: </label>
                        <select id="form-stacked-select" name="criticality" class="uk-select uk-width-1-1 uk-width-1-2@m">
                            <option value="1" @if($finding_type) @if($finding_type->criticality == 1) selected @endif @endif>1</option>
                            <option value="2" @if($finding_type) @if($finding_type->criticality == 2) selected @endif @endif>2</option>
                            <option value="3" @if($finding_type) @if($finding_type->criticality == 3) selected @endif @endif>3</option>
                            <option value="4" @if($finding_type) @if($finding_type->criticality == 4) selected @endif @endif>4</option>
                            <option value="5" @if($finding_type) @if($finding_type->criticality == 5) selected @endif @endif>5</option>
                        </select>
                    </div>
                </div>

                <div class="uk-form-row">
                    <div uk-grid>
                        <label for="one" class="uk-width-1-1 uk-width-1-2@m">Levels: </label>
                        <label><input class="uk-checkbox" type="checkbox" name="one" value="1" @if($finding_type) @if($finding_type->one) checked @endif @endif> 1</label>
                        <label><input class="uk-checkbox" type="checkbox" name="two" value="1" @if($finding_type) @if($finding_type->two) checked @endif @endif> 2</label>
                        <label><input class="uk-checkbox" type="checkbox" name="three" value="1" @if($finding_type) @if($finding_type->three) checked @endif @endif> 3</label>
                    </div>
                </div>

                <hr />

                <div class="uk-form-row">
                    <div class="uk-grid">
                        <label class="uk-width-2-3">Follow Ups: TBD foreach on edit</label>
                        <div class="uk-width-1-3 uk-text-right  uk-margin-small-top">
                            <button class="uk-button uk-button-default uk-button-small" onclick="addDefaultFollowup(this);return false;"><span uk-icon="plus-circle" class="form-title-icon"></span> Add follow-up</button>
                        </div>
                        <div class="uk-width-1-1 form-default-followups"></div>
                    </div>
                </div>

                <hr />

                <div class="uk-form-row">
                    <div class="uk-grid">
                        <input type="submit" id="submit" class="uk-button uk-button-default" style="margin: auto;" name="submit" value="Create Finding Type">
                    </div>
                </div>
            </form>
        </div>
<script>
    $ = jQuery;

    var followups = {items: []};
    var boilerplates = {items: []};

    function addDefaultFollowup(element){
        var followupTemplate = $('#form-finding-type-followup-template').html();
        $('.form-default-followups').append(followupTemplate);
    }

    function removeFollowUp(element){
        $(element).closest('.form-default-followup').remove();
    }

    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }


    $(document).ready(function(){

        $("form").on('submit',function(e){
            e.preventDefault();
            let form= $(this);
            let action = $(this).attr('action'); 

            $.each($('.form-default-followup'), function(index, followup) {
                var number = $(followup).find('.followup-number').val();
                var duration = $(followup).find('.followup-duration').val();
                var assignment = $(followup).find('.followup-assignment').val();
                var description = $(followup).find('.followup-description').val();
                if($(followup).find('.followup-reply').is(':checked')){
                    var reply = 1;
                }else{
                    var reply = 0;
                }
                if($(followup).find('.followup-photo').is(':checked')){
                    var photo = 1;
                }else{
                    var photo = 0;
                }
                if($(followup).find('.followup-doc').is(':checked')){
                    var doc = 1;
                }else{
                    var doc = 0;
                }
                
                var cats = $(followup).find('.followup-cat:checked').map( function(){
                                return $(this).val();
                            }).get();
                followups.items.push(
                        {
                            number: number,
                            duration: duration,
                            assignment: assignment,
                            description: description,
                            reply: reply,
                            photo: photo,
                            doc: doc,
                            cats: cats
                        }
                    );
            });

            $.each($('input[name^="boilerplates"]'), function(index, element) {
                boilerplates.items.push({
                    id: $(element).val()
                });
            });

            $.ajax({
                url: action, 
                method: 'POST',
                data: {
                    'inputs': getFormData(form),
                    'boilerplates': JSON.stringify(boilerplates),
                    'followups' : JSON.stringify(followups),
                    '_token' : '{{ csrf_token() }}'
                },
                success: function(response){
                    form.remove();
                    $('h2#post-response').hide().html("<span class='uk-text-success'><span uk-icon='check'></span> "+response+"</span><br /><br /><a onclick=\"dynamicModalLoad('admin/finding_type/create')\" class=\"uk-button uk-button-default uk-width-2-5@m\">CREATE ANOTHER FINDING TYPE</a>").fadeIn();
                    console.log(action);
                    switch (action){
                        case "/admin/findingtype/store":
                            $('#findingtype-tab').trigger('click');
                            break;
                    }

                },
                error: function(resp){
                    //form.remove();
                    try {
                    var errorMsg = "<span style='display:none;'>&nbsp;</span>";
                    $.each(JSON.parse(resp.responseText),function(key,value) {
                        errorMsg += "<p class='uk-text-danger' style='font-size:14px;'><span uk-icon='exclamation-circle'></span> "+ value+"</p>";
                    });
                    //$('h2#post-response').hide().html(errorMsg).fadeIn();
                    UIkit.modal.alert('UH OH! Some of the fields are\'t quite right:<hr />'+errorMsg,{stack: true});
                    console.log(errorMsg);
                    }catch(e) {
                        UIkit.modal.alert('OOPS! - The server said something bad happened... to be exact it said:<br /><hr />'+e+'<hr />My friends at <a href="mailto:admin@greenwood360.com">Greenwood 360</a> can probably figure that one out.',{stack: true});
                    }
                }
            });

        });

    });
</script>


