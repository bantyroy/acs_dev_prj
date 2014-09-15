<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 10 Jan 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  add edit For content 
* 
* @package Content Management
* @subpackage content
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/content/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>


<script>
var g_controller="<?php echo $pathtoclass;?>";//controller Path 
</script>
<script language="javascript">
jQuery(function($) {
$(document).ready(function(){
   

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    
$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller+"add_information";
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       $("#frm_add_edit").submit();
   }); 
});    
    

    
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    
    $("input[type=checkbox]").each(function(){
       
        if($(this).attr('checked')=='true' && $(this).prev().val()=='')
        {
            b_valid=false;

        }
        
    });
    /////////validating//////
    if(!b_valid)
    {
        $.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+'Link can not be empty if checked box is checked.'+'</div>').show("slow");
    }
    
    return b_valid;
    }); 
  
///////////end Submitting the form///////// 

    var controler_name  =   '<?php echo $controler_link ; ?>';
    
    $("input[id^=chk_box_]").change(function(){
        var field_type  =   $(this).attr('id').split('_').pop();
        var link =   controler_name;
        
        if($(this).attr('checked') && $(this).prev('input[type=text]').val()=='')
        {
            if($(this).prev('input[type=text]').attr('rel')=='')
            {
                 switch(field_type)
                 {
                    case 'list' :
                    link    +='show_list/';
                    break;
                    case 'add'  :
                    link    +='add_information/';
                    break;
                    case 'edit' :
                    link    +='modify_information/';
                    break;
                    case 'delete' :
                    link    +='delete_information/';
                    break;
                    case 'view' :
                    link    +='show_details/';
                    break;
                    case 'action' :
                    break;
                 }  
             $(this).prev('input[type=text]').val(link);
            }
            else
            {
                $(this).prev('input[type=text]').val($(this).prev('input[type=text]').attr('rel'));
            }
             
        }
        if(!$(this).attr('checked'))
        {
            $(this).prev('input[type=text]').attr('rel',$(this).prev('input[type=text]').val());
            $(this).prev('input[type=text]').val('')
        }

    })  ;
    
    $("#add_action").click(function(){
        
        
        $('<tr><td>&nbsp;</td><td><input type="text" rel="" name="txt_action[]"  value="" size="24" /> <select name="opt_status[]" ><option value="0">Keep</option><option value="1">Add</option></select></td><td>&nbsp;</td></tr>').insertBefore($(this).parent().parent());
        
    });
    
    
    $('input[name=chk_box_action]').change(function(){
       if($(this).attr('checked'))
       {
           $(this).val('1');
           
       }
       else
       {
           $(this).val('0');
       } 
    });
     
    });
});
</script>    

<style>
input[type="text"] {width: 300px !important;}
textarea {width: 250px !important;}
</style>

<div id="right_panel">
<form id="frm_add_edit" name="frm_add_edit" method="post" action="" >
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
    <div class="info_box">Add and edit the menu link .</div>
    <div class="clr"></div>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              //show_msg("error");  
              show_msg();  
              echo validation_errors();
            /*  pr($posted);*/
            ?>
        </div>     
    
    
    <div class="left"><!--<input id="btn_save" name="btn_save" type="button" value="Confirm" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>--></div>
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th colspan="3" align="left"><h4><?php echo $heading;?></h4></th>
        </tr>
        <tr>
          <td>View list *:</td>
          <td><input type="text" rel="" name="txt_list_title" id="txt_list_title" size="24" value="<?php echo ($posted["txt_list_title"]);?>"  />
          <input name="chk_box_list" id="chk_box_list" type="checkbox" <?php echo ($posted["txt_list_title"])?'checked':''; ?> />
          <input type="hidden" name="h_list_id" value="<?php echo $posted["h_list_id"];?>"  />
          </td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td>Add :</td>
          <td><input rel="" type="text" name="txt_add_title" id="txt_add_title" size="24" value="<?php echo ($posted["txt_add_title"]);?>"  />
          <input name="chk_box_add" id="chk_box_add" type="checkbox" <?php echo ($posted["txt_add_title"])?'checked':''; ?> />
           <input type="hidden" name="h_add_id" value="<?php echo $posted["h_add_id"];?>"  />
          </td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td>Edit :</td>
          <td><input rel="" type="text" name="txt_edit_title" id="txt_edit_title" size="24" value="<?php echo ($posted["txt_edit_title"]);?>"  />
          <input name="chk_box_edit" id="chk_box_edit" type="checkbox" <?php echo ($posted["txt_edit_title"])?'checked':''; ?> />
          <input type="hidden" name="h_edit_id" value="<?php echo $posted["h_edit_id"];?>"  />
          </td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td>View Details :</td>
          <td><input rel="" type="text" name="txt_view_title" id="txt_view_title" size="24" value="<?php echo ($posted["txt_view_title"]);?>"  />
          <input name="chk_box_view" id="chk_box_view" type="checkbox" <?php echo ($posted["txt_view_title"])?'checked':''; ?> />
          <input type="hidden" name="h_view_id" value="<?php echo $posted["h_view_id"];?>"  />
          </td>
          <td>&nbsp;</td>
        </tr>
        
          <tr>
          <td>Delete :</td>
          <td><input rel="" type="text" name="txt_delete_title" id="txt_delete_title" size="24" value="<?php echo ($posted["txt_delete_title"]);?>"  />
          <input name="chk_box_delete" id="chk_box_delete" type="checkbox" <?php echo ($posted["txt_delete_title"])?'checked':''; ?> />
          <input type="hidden" name="h_delete_id" value="<?php echo $posted["h_delete_id"];?>"  />
          </td>
          <td>&nbsp;</td>
        </tr>
         <input type="hidden" name="h_action_id" value="<?php echo $posted["h_action_id"];?>"  />
         <?php if($posted['txt_action']){ ?>
         <?php foreach($posted['txt_action'] as $key_val=>$actions){
             ?>
             <tr>
              <td><?php echo ($key_val==0)?'Actions :':'' ?>
              </td>
              <td><input type="text" rel="" name="txt_action[]" id="txt_action" value="<?php echo $actions?>" size="24" />
             <select name="opt_status[]" >
             <?php echo makeOption($arr_status,encrypt($posted['opt_status'][$key_val])) ;?>
             </select>
              
             
              </td>
              <td>&nbsp;</td>
        </tr>
       <?php
         }      
         }
         else
         { ?>
         
          <tr>
              <td>Actions :</td>
              <td><input type="text" rel="" name="txt_action[]" id="txt_action" value="<?php echo $posted['txt_action']?>" size="24" />
             <select name="opt_status[]" >
             <?php echo makeOption($arr_status)?>
             </select>
              </td>
              <td>&nbsp;</td>
        </tr>
             
         <?php 
         } ?>
         
        <tr>
        <td>&nbsp;</td>
        <td ><span id="add_action" style="color: #407595; font-weight: bold; cursor: pointer;">+ Add Action</span></td>
        <td>&nbsp;</td>
        </tr>
        

      </table>
      </div>
    <? /***** end Modify Section *******/?>      
    </div>
    
    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Confirm" title="Click here to save information." /> 
    <!--<input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>-->
    </div>
    
</form>
</div>