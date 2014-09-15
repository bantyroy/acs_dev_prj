<?php
/* * *******
 * Author: Acumen CS
 * Date  : 03 Jan 2014
 * Modified By: 
 * Modified Date:
 * 
 * Purpose:
 *  add edit For menu_setting 
 * 
 * @package menu_setting Management
 * @subpackage menu_setting
 * 
 * @link InfController.php 
 * @link My_Controller.php
 * @link views/admin/menu_setting/
 */
?>
<?php
//Javascript For List View//
?>

<link rel="StyleSheet" href="<?php echo base_url(); ?>resource/admin/css/jquery.tagedit.css" type="text/css" media="all"/>
<script type="text/javascript" src="<?php echo base_url(); ?>resource/admin/js/jquery.autoGrowInput.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resource/admin/js/jquery.tagedit.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resource/admin/js/jquery.multiFieldExtender.js"></script>
<script language="javascript">

    var g_controller = "<?php echo $pathtoclass; ?>";//controller Path 
    var controler_name = '<?php echo $controler_link; ?>';
    var i_menu_id = '<?php echo $i_menu_id; ?>';
	var menu_source = ["Add", "Edit", "Delete", "View List", "View Detail", "Status", "Default"];
	<?php if(!empty($extra_action)){
		foreach($extra_action as $k=>$v){ ?>menu_source.push('<?php echo $v?>');
	<?php }}?>
    var initActionLink = function() {
        $('input.typeahead').typeahead({
            name: 'Actions',
            source: menu_source//["Add", "Edit", "Delete", "View List", "View Detail", "Status", "Default"]
        });

        $('input.actionLink').focus(function() {
            var thisObj = $(this);
            //var actionType = thisObj.parent().prev().find('input').val().toLowerCase();
            var actionType = thisObj.parent().parent().prev().find('input').val().toLowerCase();
            var link = controler_name;

            if (thisObj.val() == '' && actionType != '')
            {
                switch (actionType) {
                    case 'view list' :
                        link += 'show_list/';
                        break;
                    case 'add'  :
                        link += 'add_information/';
                        break;
                    case 'edit' :
                        link += 'modify_information/';
                        break;
                    case 'delete' :
                        link += 'delete_information/';
                        break;
                    case 'view' :
                        link += 'show_details/';
                        break;
                    case 'status' :
                        link += 'show_list/';
                        break;
                    default :
                        link += actionType.toLowerCase().replace(' ','_')+'/';
                }
                $(this).val(link);
            }

        });
		
    }



    jQuery(function($) {
        $(document).ready(function() {
            // Local Source
            var localJSON = [
                {"id": "1", "label": "Show Phone", "value": "Show Phone"},
                {"id": "2", "label": "Show Address", "value": "Show Address"}
            ];
            $('input.tagedit').tagedit({
                autocompleteOptions: {
                    source: localJSON
                }

            });

            // Initialise action and the link there are 6 default action and link
            initActionLink();

            var actionData = <?php echo $actions; ?>;
			
            $('.add_more_container').EnableMultiField({
                linkText: '<button class="btn btn-mini btn-primary"><i class="icon-plus-sign icon-white"></i> Add</button>',
                removeLinkText: '<button class="btn btn-mini btn-danger"><i class="icon-minus-sign icon-white"></i> Remove</button>',
                addEventCallback: function() {
                    initActionLink();
                },
				removeEventCallback:function(pr, thisobj){
					var i_menu_permit_id = thisobj.find('input[recname=h_id]').val();
                    var s_remove_action = thisobj.find('input[recname=txt_action]').val();
				},
				beforeRemoveEventCallback:function(p,thisobj){
					i_menu_permit_id = thisobj.parent().find('input[recname=h_id]').val();
                    s_remove_action = thisobj.parent().find('input[recname=txt_action]').val();
					$.ajax({
                        type: "POST",
                        async: false,
                        url: g_controller + 'ajax_delete_menu_permission/',
                        data: "i_menu_permit_id=" + i_menu_permit_id + "&i_menu_id=" + i_menu_id + "&s_remove_action=" + s_remove_action,
                        success: function(msg) {
							$.noty.closeAll()
                            if (msg == "ok")
								noty({"text":"Menu has been deleted successfully.","layout":"bottomRight","type":"success"});
                            else if (msg == "error")
                           		noty({"text":"Failed to delete menu.","layout":"bottomRight","type":"error"});
                        }
                    });
					return true;
				},
                data: actionData
            });

            $("#btn_cancel").click(function() {
				window.history.back();
            });


            $('#btn_save').click(function(){
                $("#frm_add_edit").submit();
            });
        });
    });
</script>    

<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md_8 col-md-offset-2">
                    <div class="box-header well" data-original-title>
                        <h2><?php echo $heading . ' For ' . $controler_link; ?></h2>                
                    </div>
                    <form class="form-horizontal" id="frm_add_edit" name="frm_add_edit" action="" method="post" autocomplete="off" >                 
                        <div class="row add_more_container">
                            <input type="hidden"  name="h_id[]" recname="h_id" value="-1"  />
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="text" class="focused typeahead form-control"  name="txt_action[]" recname="txt_action" />
                                </div>
                            </div>
                            <div class="col-md-5 col-md-offset-2">
                                <div class="form-group">
                                    <input type="text" class="focused span8 actionLink form-control"  name="txt_link[]" recname="txt_link" />
                                    <span class="help-inline"></span>     
                                </div>
                            </div>
                        </div>  
                        <dir class="close"></dir>
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label" for="focusedInput"><?php echo addslashes(t('Add Extra Action')); ?></label>
                                    <?php
                                    if (!empty($extra_action)) 
                                    {
                                        foreach ($extra_action as $val) 
                                        {
                                        ?>
                                            <input class="focused tagedit form-control" id="txt_extra_action" name="txt_extra_action[]"  type="text" value="<?php echo $val; ?>" >
                                        <?php
                                        }
                                    } 
                                    else 
                                    {
                                    ?>
                                        <input class="focused tagedit  form-control" id="txt_extra_action" name="txt_extra_action[]"  type="text" value="" >
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">


                            <button type="submit" id="btn_save" name="btn_save" class="btn btn-primary"><?php echo addslashes(t('Save changes')); ?></button>
                            <button type="button" id="btn_cancel" name="btn_cancel" class="btn btn-mini btn-danger"><?php echo addslashes(t('Cancel')); ?></button>
                        </div>
                       
                        
                    </form>
                    
                </div>
            </div>
        
        
        </div> <!-- End col-md-12-->
    </div> <!-- End Row-->
</div> <!-- End container-fluid-->

<style type="text/css">
.offset1 input[type="text"]{width:240px !important; margin:2px 0 0 45px !important;}
.btn-mini{margin-top:5px;}
.col-md-offset-2 {
    margin-left: 3.667%;
}
.btn-mini {
    margin-top: 0px;
}
.addMoreFields {
    display: inline-block;
    float: left !important;
    margin-top: 22px;
}
</style>