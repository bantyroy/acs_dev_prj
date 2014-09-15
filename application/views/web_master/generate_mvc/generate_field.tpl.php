<script type="text/javascript" language="javascript" src="<?php echo base_url()?>resource/admin/js/tablednd.js"></script>

<script type="text/javascript">
$(document).ready(function(){

	$(".glyphicon-zoom-in").colorbox();
	
	var g_controller="<?php echo $this->pathtoclass;?>"; //controller Path

	//Submitting the form//                                            
	$("#btn_submit").click(function(){
		var formid=$(this).attr("search");	
		$("#frm_search_"+formid).attr("action","<?php echo $search_action;?>");
		$("#frm_search_"+formid).submit(); 
	});                                              
	//Submitting the form//

	//Submitting the form2//
	$("#frm_search_2").submit(function(){
		var b_valid=true;
		var s_err="";
		
		if($("#dt_date_from").val() > $("#dt_date_to").val() ) 
		{
			s_err='<?php echo addslashes(t("From date cannot be bigger than to date"))?>'
			b_valid=false;
		}
	
		$("#frm_search_2 #div_err_2").hide("slow"); 
	
		//validating//
		if(!b_valid)
		{
			$("#frm_search_2 #div_err_2").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
		}    
		return b_valid;
	});    
	//end Submitting the form2//

	//Submitting search all//
	$("#btn_srchall").click(function(){
		$("#frm_search_3").submit();
	});
	//end Submitting search all// 	
	
    //Submitting the form//                                            
    $("#btn_crud").click(function(){        
        $("#frm_crud").submit(); 
    });                                              
    //Submitting the form//

    //Submitting the form2//
    $("#frm_crud").submit(function(){
        var b_valid = true;
        var s_err="";
        
        $("input[name^='label']").each(function(){
            if($(this).val() == '')
            {
                b_valid = false;
                s_err = 'Field Label can not be blank.'; 
            }
        });
    
        $("#frm_search_2 #div_err_2").hide("slow"); 
    
        //validating//
        if(!b_valid)
        {
            $("#frm_search_2 #div_err_2").html('<div id="err_msg" class="alert alert-error">'+s_err+'</div>').show("slow");
        }    
        return b_valid;
    });    
    //end Submitting the form2//
	
	
});
</script>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
		<div class="row">
		    <div class="col-md-8 col-md-offset-2">
		
                <div class="box-header well">
                    <h2><?php echo addslashes(t("Table List"))?></h2>             
                </div>
    
                <?php show_all_messages(); ?>
                <form class="form-horizontal" id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action?>" >
                    <input type="hidden" id="h_search" name="h_search" value="" />	
                </form>
                
                <form class="" id="frm_search_2" name="frm_search_2" method="post" action="" >
                    <input type="hidden" id="h_search" name="h_search" value="advanced" />		
                    <div id="div_err_2"></div>		
           
	       
                    <div class="row">
					        <div class="col-md-5">
                                <div class="form-group  listmenu_">
                                    <label class=""><?php echo addslashes(t("Select Table"))?></label>
                                    <select name="opt_table" class="form-control">
                                    <?php 
                                    if(count($table_to_mvc) > 0)
                                    {
                                        foreach($table_to_mvc as $t){
                                            $selected = $t == $selected_table_to_mvc ? 'selected="selected"' : '';
                                            echo "<option value=\"$t\" {$selected}>$t</option>";
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                      
                            </div>
					    
					        <div class="col-md-5 col-md-offset-2"></div>
					    
                     </div>             
                    <div class="form-group">
                        <button type="button" search="2" id="btn_submit" name="btn_submit" class="btn btn-primary"><?php echo addslashes(t("Generate MVC"))?></button>
				     </div>
                
                </form>  
          
			
		    </div>
        </div>
        
        <?php if(!empty($field_details)){?>
        <div class="row">
            <form action="<?php echo base_url('web_master/generate_crud/generate')?>" method="post" id="frm_crud">
            <input type="hidden" name="table_name" value="<?php echo $selected_table_to_mvc?>"/>
                <div class="box">
                    <table border="0" class="table table-striped">
                    <tr class="info">
                        <th><strong>Label</strong></th>
                        <th><strong>Show in Listing Page</strong></th>
                        <th><strong>Search</strong></th>
                        <th><strong>Sort</strong></th>
                        <th><strong>Field Type</strong></th>
                        <th><strong>Validation</strong></th>
                    </tr> 
                    <?php 
                    for($i = 1; $i <= count($field_details); $i++)
                    {
                        echo '<tr>
                                <td><input type="text" value="'.$field_details[$i]['label'].'" name="label[]"  class="form-control" /></td>
                                <td><select name="listing[]" class="form-control"><option value="show">Show</option><option value="hide">Hide</option></select>'.($field_details[$i]['is_reference_field'] ? '<span class="denger text-info">Select Reference Field</span><br>'.form_dropdown('ref_field_'.($i-1), $field_details[$i]['reference_field'],'',' class="form-control"').'<span class="denger text-info">(Ref Table: '.$field_details[$i]['reference_table'].')</span><input type="hidden" value="'.$field_details[$i]['reference_table'].'" name="ref_table_'.($i-1).'"/>' : '').'</td>
                                <td><select name="searching[]" class="form-control"><option value="show">Show</option><option value="hide" '.($i > 1 ? "selected" : "").'>Hide</option></select></td>
                                <td><select name="sorting[]" class="form-control"><option value="show">Show</option><option value="hide" '.($i > 1 ? "selected" : "").'>Hide</option></select></td>
                                <td>'.form_dropdown('type[]', $form_field_type, ($field_details[$i]['type']!= "" ? array($field_details[$i]['type']) : ''),' class="form-control"').'</td> 
                                
                                <td><select name="validation[]" class="form-control"><option value="">No Validation</option><option value="required">Required</option><option value="valid_email">Email</option></select></td>                         
                              </tr>';
                    }
                    ?>  
                    <tr>
                        <td colspan="6" align="right" style="text-align: right;"><button class="btn btn-primary" name="btn_submit" id="btn_crud" search="2" type="button">Generate CRUD</button></td>
                    </tr>
                </table>
                </div>
            </form>
        </div>
        <?php }?>
        <?php echo $table_view;?><!-- content ends -->
    </div>
    </div>
</div>

<style type="text/css">
.col-md-10{width: 93.33%;}
.col-md-offset-1{margin-left: 3.33%;}
.col-md-offset-2{margin-left: 20%;}
.text-info{font-size: 10px; font-style: italic; float: left;}
/*.denger{color: red !important;}*/
tr.info th {background: #0b8d97 !important; color: #fff; text-align: center;}
.table td {text-align: center;}
.table{border: 1px solid #ccc;}
.form-control{padding: 6px; height: 30px;}
</style>
