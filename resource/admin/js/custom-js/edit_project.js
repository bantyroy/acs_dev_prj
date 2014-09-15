/* ~~~~~~~~~ FOR PROJECT PIC [BEGIN] ~~~~~~~~~ */

//// function to show file-browser dialog...
$(document).ready(function() {

    // UPLOADING PROJECT IMAGE
    $('#uploadBtn').change(function(evt) {
        alert('neena');
        _upload_job_pic_AJAX();
    });
});


// FUNCTION TO UPLOAD PROJECT IMAGE START
function _upload_job_pic_AJAX()
{
    var action_url = base_url +'manage_job/upload_project_main_img_AJAX';
    optionsPopUpArr = {
        beforeSubmit:  showBusyScreen,  // pre-submit callback
        success:       validatePortfolioMainPic, // post-submit callback
        url:		   action_url
    };

    $('#frm_add_edit').ajaxSubmit(optionsPopUpArr);

    return false;
}

// validate project-main-pic ajax-submission...
function validatePortfolioMainPic(data)
{
    var result_obj = JSON.parse(data);
    // 'success'
    if(result_obj.result=='success') {
        // main-pic div to be changed...
        $('.post_project_img').html( result_obj.content );
        // set filename to a hidden field...
        $('#hdn_main_pic').val( result_obj.main_pic );

    }
    // 'error'
    if(result_obj.result=='error') {
        // error message...
        showUIMsg(result_obj.msg);
    }
    // hide busy-screen...
    hideBusyScreen();
}
// FUNCTION TO UPLOAD PROJECT IMAGE END

