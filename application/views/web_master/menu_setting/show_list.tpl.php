<?php
/* * *******
 * Author: Acumen CS
 * Date  : 30 Jan 2014
 * Modified By: 
 * Modified Date:
 * 
 * Purpose:
 *  View For menu setting List Showing
 * 
 * @package 
 * @subpackage 
 * 
 * @link InfController.php 
 * @link My_Controller.php
 * @link views/admin/menu_setting/

 */
?>

<script type="text/javascript" language="javascript" >
    var admin_base_url = "<?php echo admin_base_url(); ?>";
    jQuery(function($) {
        $(document).ready(function() {
            $("#tab_search").tabs({
                cache: true,
                collapsible: true,
                fx: {"height": 'toggle', "duration": 500},
                show: function(clicked, show) {
                    $("#btn_submit").attr("search", $(show.tab).attr("id"));
                    $("#tabbar ul li a").each(function(i) {
                        $(this).attr("class", "");
                    });
                    $(show.tab).attr("class", "select");
                }
            });


            $("#tab_search ul").each(function(i) {
                $(this).removeClass("ui-widget-header");
                $("#tab_search").removeClass("ui-widget-content");
            });
            // end Clicking the tabbed search



            //Submitting the form                                           
            $("#txt_menu_title").focus(function() {
                $(this).val('');
            });

            $("#btn_submit").click(function() {
                //$.blockUI({ message: 'Just a moment please...' });
                //blockPage();

                var b_valid = true;
                if ($.trim($("#txt_menu_title").val()) == '' || $.trim($("#txt_menu_title").val()) == 'Enter menu title')
                {
                    $("#txt_menu_title").val('Enter menu title');
                    b_valid = false;
                }
                if (b_valid)
                {
                    $("#frm_2").submit();
                }
            });
            // Submitting the form          

            // clearing the form
            $("#btn_clear").click(function() {
                var formid = $("#btn_submit").attr("search");
                clear_form("#frm_search_" + formid);
            });

            function clear_form(formid)
            {
                // Clearing input fields
                $(formid).find("input")
                        .each(function(m) {
                    switch ($(this).attr("type"))
                    {
                        case "text":
                            $(this).attr("value", "");
                            break;

                        case "password":
                            $(this).attr("value", "");
                            break;

                        case "radio":
                            $(this).find(":checked").attr("checked", false);
                            break;

                        case "checkbox":
                            $(this).find(":checked").attr("checked", false);
                            break;
                    }
                });

                // Clearing select fields
                $(formid).find("select")
                        .each(function(m) {
                    $(this).find("option:selected").attr("selected", false);
                });
                // Clearing textarea fields

                $(formid).find("textarea")
                        .each(function(m) {
                    $(this).text("");
                });
            }
            // clearing the form

            // Submitting the form1
            // end Submitting the form1

            // Submitting the form2
            $("#frm_search_2").submit(function() {
                var b_valid = true;
                var s_err = "";
                $("#frm_search_2 #div_err_2").hide("slow");
                /*    if($.trim($("#frm_search_2 #txt_news_title").val())=="") 
                 {
                 s_err +='Please provide News Title.<br />';
                 b_valid=false;
                 }*/
                
                //validating
                if (!b_valid)
                {
                    //$.unblockUI();
                    $("#frm_search_2 #div_err_2").html('<div id="err_msg" class="error_massage">' + s_err + '</div>').show("slow");
                }
                return b_valid;
            });
            // end Submitting the form2

            // Submitting search all
            $("#btn_srchall").click(function() {
                $("#frm_search_3").submit();
            });
            // end Submitting search all

            $("a[id^=edit_row_]").click(function() {
                var row_id = $(this).attr('id').split('_').pop();
                $(this).parent().prev('td').prev('td').find('span').text('');
                $(this).parent().prev('td').prev('td').find('input').show();
                $(this).hide().next().show();
            });


            $("a[id^=save_row_]").hide();

            $("a[id^=save_row_]").click(function() {
                var row_id = $(this).attr('id').split('_').pop();
                var edited_data = $(this).parent().prev('td').prev('td').find('input').val();
                var obj_td = $(this).parent().prev('td').prev('td');
                $.ajax({
                    type: "POST",
                    url: admin_base_url + 'menu_setting/ajax_edit_main_menu',
                    data: "edited_data=" + edited_data + "&row_id=" + row_id,
                    success: function(msg) {
                        if (msg == 'ok')
                        {
                            $(obj_td).find('input').hide();
                            $(obj_td).find('span').text(edited_data);
                        }
                    }
                });
                $(this).hide().prev().show();
            });

            $("a[id^=change_row_]").click(function() {
                var row_id = $(this).attr('id').split('_').pop();
                var obj_td = $(this).parent().prev('td');
                var data = $(this).parent().prev('td').text();
                $.ajax({
                    type: "POST",
                    url: admin_base_url + 'menu_setting/ajax_change_status_main_menu',
                    data: "data=" + data + "&row_id=" + row_id,
                    success: function(msg) {
                        if (msg != 'error')
                        {
                            window.location.reload();
                        }
                    }
                });
            });


            $("a[id^=delete_row_]").click(function() {
                var row_id = $(this).attr('id').split('_').pop();
                var extraData = new Object;               
                extraData = {'row_id': row_id};
                showConfirmation("<?php echo addslashes(t('This menu wiil deleted permanently with submenu')); ?>", 100, extraData);
            });

        });
    });

    // Confirm box callback
    function callbackEventYes(modalObj, refId, extraData) {
        $(modalObj).modal('hide');
        if (refId === 100) {
            blockPage();
            $.ajax({
                type: "POST",
                url: admin_base_url + 'menu_setting/ajax_delete_main_menu',
                data: "row_id=" + extraData.row_id,
                success: function(msg) {
                    if (msg == 'ok')
                    {
                        //unBlockPage();
                        window.location.reload();
                    }
                }
            });
        }
    }
</script>

<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box-header well" data-original-title>
                        <h2><?php echo addslashes(t("Add Menu")) ?></h2>                
                    </div>
                    <form class="form-horizontal" id="frm_2" name="frm_2" method="post" action="" >
                        <input type="hidden" id="h_search" name="h_search" value="advanced" /> 
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label><?php echo addslashes(t('Menu Title')); ?></label>
                                    <input type="text" id="txt_menu_title" name="txt_menu_title"  class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-5 col-md-offset-2">
                                <div class="form-group">
                                    <label><?php echo addslashes(t('Menu Status')); ?></label>
                                    <select name="opt_status" id="opt_status"  class="form-control" >
                                        <option value="1"><?php echo addslashes(t('Show')); ?></option>
                                        <option value="0"><?php echo addslashes(t('Hide')); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>  
                        <div class="form-group">
                            <button type="button" search="2" id="btn_submit" name="btn_submit" title="Click to Add new Menu." class="btn btn-primary"><?php echo addslashes(t('Add Menu')) ?></button>

                            <button type="button" id="btn_clear" name="btn_clear" class="btn"><?php echo addslashes(t('Clear')) ?></button>
                        </div> 
                    </form>
                </div> <!-- End col-md-8 col-md-offset-2-->
            </div> <!-- End Row-->
            
            <?php echo $table_view;?>
        </div> <!-- End col-md-12-->
    </div> <!-- End Row-->
</div> <!-- End container-fluid-->