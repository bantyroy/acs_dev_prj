
$(document).ready(function(){
    //Submitting the form//
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err='';
        $("#div_err").hide("slow");
        
		if($("#s_category_req").val()=='')
		{
			markAsError($("#s_category_req"),'<?php echo addslashes(t("Please provide category"))?>');
			b_valid = false;
		}
        //validating//
        if(!b_valid)
        {        
            $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }
    
        return b_valid;
    });
});