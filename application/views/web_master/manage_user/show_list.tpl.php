
<script type="text/javascript">

$(document).ready(function(){

var g_controller="<?php echo $this->pathtoclass;?>"; //controller Path

$(".ajax").colorbox();

 $("#btn_upload").click(function(e){
		e.preventDefault();
		$("#error_massage").hide();
		$('#myModal_upload').modal('show');

		//var temp_id = $(this).attr('value');

		$('#btn_upload_yes').on('click',function(){
		
			$("#frm_upload").submit();
		});

   });

/////Click Edit////
$("a[id^='view_detail_']").each(function(i){
   $(this).click(function(){
	    var user_id = $(this).attr('id').split('_').pop();
        var url=g_controller+'show_detail/'+user_id;
        window.location.href=url;
   }); 
});
/////end Click Edit////

/////////Submitting the form//////                                            

$("#btn_submit").click(function(){
   
    var formid=$(this).attr("search");	
    $("#frm_search_"+formid).attr("action","<?php echo $search_action;?>");
    $("#frm_search_"+formid).submit(); 

});                                              

/////////Submitting the form//////
///////////Submitting the form2/////////

$("#frm_search_2").submit(function(){

    var b_valid=true;
    var s_err="";

    $("#frm_search_2 #div_err_2").hide("slow"); 

    /////////validating//////

    if(!b_valid)
    {
        $("#frm_search_2 #div_err_2").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }    

    return b_valid;

});    

///////////end Submitting the form2/////////

////////Submitting search all///

$("#btn_srchall").click(function(){
 $("#frm_search_3").submit();
 
});

////////end Submitting search all///       

});
</script>

<div class="container-fluid">

            <div class="row">
              <div class="col-md-10 col-md-offset-1">
					<div class="box-header well" data-original-title>
						<h2><?php echo addslashes(t('Search'))?></h2>
						
					</div>
					<div class="box-content">
                    	<?php show_all_messages(); ?>
                    
						<form class="form-horizontal" id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action ?>" >
        					<input type="hidden" id="h_search" name="h_search" value="" />	
                         </form>
                        
                        <form class="form-horizontal" id="frm_search_2" name="frm_search_2" method="post" action="" >
        					<input type="hidden" id="h_search" name="h_search" value="advanced" />				
						<fieldset>	
						
						
						
						<div class="searchBox">
						
							<div class="searchRow">
								<div class="searchCell">
									<div class="searchLabel">
								  		<label><?php echo addslashes(t('First Name'));?></label>
								    </div>
								    <div >
										<input type="text" id="first_name" name="first_name" value="<?php echo $first_name;?>"/>
									</div>
								
								</div>
						
								<div class="searchCell">
									<div class="searchLabel">
								  		<label><?php echo addslashes(t('Last Name'));?></label>
								    </div>
								    <div >
										<input type="text" id="last_name" name="last_name" value="<?php echo $last_name;?>"/>
									</div>
								
								</div>
						
								
								</div>
							</div>
							
							<div class="searchBox">
                         	<div class="searchRow">
								<div class="searchCell">
									<div class="searchLabel">
								  		<label><?php echo addslashes(t('User Name'));?></label>
								    </div>
								    <div >
										<input type="text" id="user_name" name="user_name" value="<?php echo $user_name;?>"/>
									</div>
								
								</div>
								
								<div class="searchCell">
									<div class="searchLabel">
								  		<label><?php echo addslashes(t('Email'));?></label>
								    </div>
								    <div >
									    <input type="text" id="email" name="email" value="<?php echo $email;?>"/>
									</div>
								</div>
							</div>
                        </div>
                         
								                        
                         
						
                            
                                                                           
						<div style="clear:both;"></div>	
                       		
							<div class="form-actions">
							  <button type="button" search="2" id="btn_submit" name="btn_submit" class="btn btn-primary"><?php echo addslashes(t('Search'))?></button>
							 
							  <button type="button" id="btn_srchall" name="btn_srchall" class="btn"><?php echo addslashes(t('Show All'))?></button>

							
							</div>
						  </fieldset>
						</form>
						
						<?php if(decrypt($admin_loggedin['user_type_id'])== 1 ||decrypt($admin_loggedin['user_type_id'])==0)
							{?>
								
						<button id="btn_export" class="btn btn-round btn-mini btn-success" onclick="window.location.href = '<?php echo admin_base_url().'manage_user/csv_download';?>'">
							<?php echo addslashes(t("Export User"))?>							
						</button>
						<button id="btn_upload" class="btn btn-round btn-mini btn-warning">
							<?php echo addslashes(t("Import User"))?>							
						</button>
						<button id="btn_sample" class="btn btn-round btn-mini btn-inverse" onclick="window.location.href = '<?php echo base_url().'content_data/user_sample.xls';?>'">
							<?php echo addslashes(t("Download Sample "))?>							
						</button>
						 <button id="btn_sample" class="btn btn-round btn-mini btn-primary" onclick="window.location.href = '<?php echo base_url().'content_data/user_type.xls';?>'">
							<?php echo addslashes(t("Download User Type Info"))?>							
						</button>
						
						<?php	}
							?>
						
							
						  
    </div> 

                    
			


 <?php

        echo $table_view;
?>
        <!-- content ends -->
</div>
	</div>

			</div>



<form name="frm_upload" id="frm_upload" method="POST" enctype="multipart/form-data" action="<?php echo admin_base_url()."manage_user/csv_file_upload"?>" >
<div class="modal hide fade" id="myModal_upload">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3><?php echo addslashes(t("Upload Csv Here"))?></h3>
    </div>
    <div class="modal-body" style="height:300 ">
       <div class="uploader" id="uniform-fileInput"><input class="input-file uniform_on" name="fileInput" id="fileInput" type="file" size="40" style="opacity: 0;"><span class="filename">No file selected</span><span class="action">Choose File</span>
	</div> <span class="help-inline"></span> 
	<span> Please upload .csv or .xls file only</span>
    
	</div>
    <div class="modal-footer">
        <a href="#" class="btn" id="btn_upload_no" data-dismiss="modal"><?php echo addslashes(t("Cancel"))?></a>
        <button class="btn btn-primary" id="btn_upload_yes" ><?php echo addslashes(t("Submit"))?></button>
    </div>
</div>
</form>