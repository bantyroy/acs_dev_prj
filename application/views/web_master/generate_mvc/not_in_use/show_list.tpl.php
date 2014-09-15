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
	
	/*----  For changing sorting order[start] ---------------------*/
	  $('.box table').attr('id','tableSort');
	  $('.box table tr').prepend('<td valign="top" title="Drag to re-order" class="dragHandle showDragHandle">&nbsp;</td>');
	  $('.box table tr:first td').html("<strong>Drag And Re-order</strong>");
	  $('.box table tr:first td').removeClass("dragHandle showDragHandle");
	  $('.box table tr:first').next().children().removeClass("dragHandle showDragHandle");
	/*----  For changing sorting order [end] ---------------------*/
	
	$('#tableSort').tableDnD({
        onDrop: function(table, row) {
		
			var sortIdArr	=	$('#tableSort').tableDnDSerialize();
			//alert(sortIdArr);
			// Ajax Calling to change banner order[ Start ]
			 $.ajax({
					   type: "POST",
					   url: g_controller + 'ajax_change_order/',
					   /*data: "id_string="+ sortIdArr,*/
					   data:  sortIdArr,
					   success: function(msg)	
					   {
						 //alert(msg);
					   }
					});
				// Ajax Calling to change banner order  [End]
        },
        dragHandle: ".dragHandle"
    });
	
	$("#dt_date_from").datepicker({
		dateFormat : 'yy-mm-dd',
	});
	 
	 $("#dt_date_to").datepicker({
		dateFormat : 'yy-mm-dd',
	});      
});
</script>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
		<div class="row">
		<div class="col-md-8 col-md-offset-2">
		
            <div class="box-header well">
                <h2><?php echo addslashes(t("Search"))?></h2>
                
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
      			 <div class="form-group">
				 <label class=""><?php echo addslashes(t("News Title"))?></label>
			
                    <input type="text" name="s_title" id="s_title" value="<?php echo $s_title?>" class="form-control" />
			
                </div>
              
                    <div class="form-group">
					<label class=""><?php echo addslashes(t("Date From"))?></label>
                    
					<input class="form-control" type="text" name="dt_date_from" id="dt_date_from" value="<?php echo $dt_date_from?>" />
                    <span class="help-inline"></span>
					
					</div>
                
				<div class="form-group">    
         		 <label class=""><?php echo addslashes(t("Date To"))?></label>
				 
                    <input class="form-control" type="text" name="dt_date_to" id="dt_date_to" value="<?php echo $dt_date_to?>" />
				
					</div>
					</div>
					
					<div class="col-md-5 col-md-offset-2"></div>
					
                 </div>             
                           
                <div class="form-group">
			
                  <button type="button" search="2" id="btn_submit" name="btn_submit" class="btn btn-primary"><?php echo addslashes(t("Search"))?></button>                 
                  <button type="button" id="btn_srchall" name="btn_srchall" class="btn"><?php echo addslashes(t("Show All"))?></button>
				
                </div>
            
            </form>  
          
			
			</div>
			</div>


 <?php echo $table_view;?><!-- content ends -->
</div>
		</div>
    </div>
