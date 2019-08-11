$(function(){

    $("#field_type").change(function(){
        var type_inp = $(this).val();

        if(type_inp == "select"){
            //$(".dn_d").stop(true, true).slideUp(300);
            $(".dn_n").stop(true, true).slideDown(300);
        } else{
            //$(".dn_d").stop(true, true).slideDown(300);
            $(".dn_n").stop(true, true).slideUp(300).val("");
        }
    })

    $("html, body").on("click", ".add_fields", function(){

        fields_params = "";

        var inp_type = $("#field_type").val();
        var inp_type_text = $("#field_type option:selected").text();
        var field_description = $("#field_description").val();
        var field_name_admin = $("#field_name_admin").val();
        var field_name = $("#field_name").val();
        var field_select = $("#field_select").val();
        var field_required = $("#field_required").prop("checked");

        if(field_required == true) field_required = "required";
        else field_required = "";

        fields_params = inp_type+"|"+field_description+"|"+field_name_admin+"|"+field_required;

        if(inp_type == "select") field_name = "";

        $(".form_content").append('<tr class="sort_tr"><td>'+inp_type_text+'<input type="hidden" name="fields_params[]" value="'+fields_params+'"><input type="hidden" name="fields_values[]" value="'+field_name+'"></td><td>'+field_description+'</td><td>'+field_name_admin+'</td><td>'+field_name+'</td><td>'+field_select+'</td><td>'+field_required+'</td><td><a href="#" class="movetop"></a><a href="#" class="movebottom"></a><a href="#" class="deleteGoods"></a></td></tr>');

        return false;
        
    })

    $("html, body").on("click", ".movetop:not(:first)", function(){

        var tr = $(this).parents(".sort_tr").html();
        $(this).parents(".sort_tr").prev().before('<tr class="sort_tr">'+tr+'</tr>');
        $(this).parents(".sort_tr").remove();
        return false;

    })

    $("html, body").on("click", ".movebottom:not(:last)", function(){

        var tr = $(this).parents(".sort_tr").html();
        $(this).parents(".sort_tr").next().after('<tr class="sort_tr">'+tr+'</tr>');
        $(this).parents(".sort_tr").remove();
        return false;

    })

    $("html, body").on("click", ".form_add_fields .deleteGoods", function(){
        $(this).parents('tr').remove();
        return false;
    })

})