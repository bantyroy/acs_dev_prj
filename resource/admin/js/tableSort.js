// JavaScript Document
$(document).ready(function() {
						   

    $('#tableSort').tableDnD({
        onDrop: function(table, row) {
		
			var sortIdArr	=	$('#tableSort').tableDnDSerialize();
			//alert(sortIdArr);
			
				// Ajax Calling to change banner order[ Start ]
				$.ajax({
						   type: "POST",
						   url: base_url + 'admin/banner/change_order/',
						   /*data: "id_string="+ sortIdArr,*/
						   data:  sortIdArr,
						   success: function(msg)	{
														//alert(msg);
													}
						});
				// Ajax Calling to change banner order  [End]
			
			
        },
        dragHandle: ".dragHandle"
    });

    $("#tableSort tr").hover(function() {
          $(this.cells[0]).addClass('showDragHandle');
		   $('.box-content table tr:first td').removeClass("showDragHandle");
    }, function() {
          $(this.cells[0]).removeClass('showDragHandle');
		  $('.box-content table tr:first td').removeClass("showDragHandle");
    });
});