<h1>Have a <span>project</span>? </h1>
<p class="intro"><?php echo $have_a_project[0]['s_description'];?></p>

<div class="featured_prj_box">
	<h2>Featured <span>Project</span></h2>
    <div id="owl-fea_prj" class="owl-carousel">
        <?php foreach($featured_proj_list as $featured_prj){?>
        <div class="item">
            <?php if($featured_prj['s_image']!=''){?>
            <img src="<?= base_url() ?>resource/uploaded/post_job/small_thumb/small_<?=$featured_prj['s_image']?>" border="0" alt="" title="" />
            <?php } else { ?>
            <img src="<?= base_url() ?>resource/fe/images/featured_prj3.jpg" border="0" alt="" title="" />
            <?php } ?>
            <h6><?php echo $featured_prj['s_title'];?></h6>
            <p><?php echo substr($featured_prj['s_description'],0,250);?></p>
            <a href="#" target="_self">Go There</a>
            <div class="spacer"></div>
            <div class="spacer"></div>
        </div>
        <?php } ?>
    </div>
</div>



<div class="nutshell_box">



<h2>In a <span>Nutshell...</span></h2>

<img src="<?= base_url() ?>resource/fe/images/nutshell_pic.jpg" border="0" alt="" title="" />

<div id="nutshell_less_details"><?php echo string_part($nutshell[0]['s_description'], 200);?></div>

<div id="nutshell_full_details" style="display:none;"> <?php echo $nutshell[0]['s_description'];?> </div>


<a href="javascript:void(0);" target="_self" class="see_more"  id="nutshell_see_more" onclick="see_more_nutshell()"><span>See More</span></a><br />
<a href="<?php echo base_url()?>registration" target="_self" class="get_start">Get Started Now! It's Free!</a>

<div class="spacer"></div>

</div>

<div class="spacer"></div>

<div class="happening_box"><h2><span>Happening <em>Now</em></span></h2>



<div class="happeining_content">

<div id="content_1" class="happeining_content_scroll">



<ul>

<li><img src="<?= base_url() ?>resource/fe/images/happen_pic1.jpg" border="0" alt="" title="" />

<div class="info"><h3>Provider just quoted an RFQ</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="1">

	<tr>

		<th width="40%" align="left" valign="top">Category:</th>

		<td width="60%" align="left" valign="top">PCB</td>

	</tr>

	<tr>

		<th width="40%" align="left" valign="top">Buyer Location:</th>

		<td width="60%" align="left" valign="top">Canada</td>

	</tr>

	<tr>

		<th width="40%" align="left" valign="top">Closes:</th>

		<td width="60%" align="left" valign="top">Thursday, Oct 18 - 9:45PM</td>

	</tr>

</table>





</div>

<div class="spacer"></div>

</li>



<li><img src="<?= base_url() ?>resource/fe/images/happen_pic2.jpg" border="0" alt="" title="" />

<div class="info"><h3>User just posted an RFP</h3>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

	<tr>

		<th width="40%" align="left" valign="top">Category:</th>

		<td width="60%" align="left" valign="top">PCB</td>

	</tr>

	<tr>

		<th width="40%" align="left" valign="top">Buyer Location:</th>

		<td width="60%" align="left" valign="top">Canada</td>

	</tr>

	<tr>

		<th width="40%" align="left" valign="top">Closes:</th>

		<td width="60%" align="left" valign="top">Thursday, Oct 18 - 9:45PM</td>

	</tr>

</table>

</div>

<div class="spacer"></div>

</li>



<li><img src="<?= base_url() ?>resource/fe/images/happen_pic1.jpg" border="0" alt="" title="" />

<div class="info"><h3>Provider just quoted an RFQ</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="1">

	<tr>

		<th width="40%" align="left" valign="top">Category:</th>

		<td width="60%" align="left" valign="top">PCB</td>

	</tr>

	<tr>

		<th width="40%" align="left" valign="top">Buyer Location:</th>

		<td width="60%" align="left" valign="top">Canada</td>

	</tr>

	<tr>

		<th width="40%" align="left" valign="top">Closes:</th>

		<td width="60%" align="left" valign="top">Thursday, Oct 18 - 9:45PM</td>

	</tr>

</table>

</div>

<div class="spacer"></div>

</li>



<li><img src="<?= base_url() ?>resource/fe/images/happen_pic2.jpg" border="0" alt="" title="" />

<div class="info"><h3>User just posted an RFP</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="1">

	<tr>

		<th width="40%" align="left" valign="top">Category:</th>

		<td width="60%" align="left" valign="top">PCB</td>

	</tr>

	<tr>

		<th width="40%" align="left" valign="top">Buyer Location:</th>

		<td width="60%" align="left" valign="top">Canada</td>

	</tr>

	<tr>

		<th width="40%" align="left" valign="top">Closes:</th>

		<td width="60%" align="left" valign="top">Thursday, Oct 18 - 9:45PM</td>

	</tr>

</table>

</div>

<div class="spacer"></div>

</li>



<li><img src="<?= base_url() ?>resource/fe/images/happen_pic1.jpg" border="0" alt="" title="" />

<div class="info"><h3>Provider just quoted an RFQ</h3>



<table width="100%" border="0" cellspacing="0" cellpadding="1">

	<tr>

		<th width="40%" align="left" valign="top">Category:</th>

		<td width="60%" align="left" valign="top">PCB</td>

	</tr>

	<tr>

		<th width="40%" align="left" valign="top">Buyer Location:</th>

		<td width="60%" align="left" valign="top">Canada</td>

	</tr>

	<tr>

		<th width="40%" align="left" valign="top">Closes:</th>

		<td width="60%" align="left" valign="top">Thursday, Oct 18 - 9:45PM</td>

	</tr>

</table>

</div>

<div class="spacer"></div>

</li>



<li><img src="<?= base_url() ?>resource/fe/images/happen_pic2.jpg" border="0" alt="" title="" />

<div class="info"><h3>User just posted an RFP</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

	<tr>

		<th width="40%" align="left" valign="top">Category:</th>

		<td width="60%" align="left" valign="top">PCB</td>

	</tr>

	<tr>

		<th width="40%" align="left" valign="top">Buyer Location:</th>

		<td width="60%" align="left" valign="top">Canada</td>

	</tr>

	<tr>

		<th width="40%" align="left" valign="top">Closes:</th>

		<td width="60%" align="left" valign="top">Thursday, Oct 18 - 9:45PM</td>

	</tr>

</table>

</div>

<div class="spacer"></div>

</li>



</ul>



		</div>

</div>

</div>



<div class="how_box">

<h2><span>How it <em>Works</em></span></h2>



<div class="how_box_content">

<h3>For <span>Customers</span></h3>

<img src="<?= base_url() ?>resource/fe/images/how_pic.jpg" border="0" alt="" title="" />

<div id="customer_less_details"><?php echo string_part($for_customer[0]['s_description'], 300);?></div>

<div id="customer_full_details" style="display:none;"> <?php echo $for_customer[0]['s_description'];?> </div>


<a href="javascript:void(0)" target="_self" class="see_more" id="customer_see_more" onclick="see_more_for_customer()"><span>See More</span></a><br />



<a href="<?php echo base_url()?>registration" target="_self" class="get_start">Get Started</a>

<div class="spacer"></div>

</div>

</div>

<div class="spacer"></div>

<div class="provider_news_wrapper">

<div class="provider_box">

<h2>For <span>Providers</span></h2>

<img src="<?= base_url() ?>resource/fe/images/providers_pic.jpg" border="0" alt="" title="" />

<div id="provider_less_details"><?php echo string_part($for_provider[0]['s_description'], 200);?></div>

<div id="provider_full_details" style="display:none;"> <?php echo $for_provider[0]['s_description'];?> </div>

<a class="see_more" target="_self" href="javascript:void(0);"  id="provider_see_more" onclick="see_more_for_provider()"><span>See More</span></a><br />

<a class="get_start" target="_self" href="<?php echo base_url()?>registration">Get Started</a>

<div class="spacer"></div>

</div>

<div class="newsletter_box">

    <h2>Signup for <span>Newsletter</span></h2>
    <div class="success_msg" id="succ_msg"></div>
    <form method="post" action="" name="frm_subscribe" id="frm_subscribe">
    
        <input type="text" name="txt_email" id="txt_email" value="Type your email address here" onfocus="blank(this)" onblur="unblank(this)"/>
        
        <input type="button" name="" value="Submit"  onclick="submit_newsletter()" />
    	<div class="error_msg subscribe" id="err_txt_email"></div>
        <div class="spacer"></div>
        
    	
    </form>
</div>

</div>

<div class="testimonials_box">

<h2>Client <span>Testimonials</span></h2>



<div class="testimonial_content" >

	

 		<div id="content_2" class="testimonial_content_scroll">
        
        <?php
			foreach($customer_testimonial_list as $key=>$val)
			{
		?>
				<small><?php echo $val['s_comments']?><span><?php echo $val['s_given_by']?>, <?php echo $val['s_company_name']?></span></small>
        <?php
			}
		?>
		</div>
	</div>
</div>



<div class="spacer"></div>

<script>
function submit_newsletter()
{
		// Validating the join form 
		var email_pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		$(".error_msg").html('');
		var b_valid = true;
		
		if(email_pattern.test($.trim($("#txt_email").val())) == false)
		{
			$("#err_txt_email").html('<?php echo addslashes(t("Please provide valid email address"))?>');	
			$(".error_msg").css('display','block');
			b_valid = false;
		}
		if(b_valid == true)
		{
			var urldata  = $("#frm_subscribe").serialize();
			
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url().'home/join_mailing_list'?>",
				data: urldata,
				dataType : 'html',
				success : function(msg){
					var message = msg.split("*");
					if(message[0] == 'succ')
					{
						$("#succ_msg").html(message[1]);
						$("#txt_email").val("Type your email address here");
					}
					if(message[0] == 'exist')
					{
						$("#txt_email").val("Type your email address here");
						$("#err_txt_email").html('<?php echo addslashes(t("You are already subscribed"))?>');
						$(".error_msg").css('display','block');
					}
									
				}
			});	
		}
}

var for_customer	= 'less';
var for_provider	= 'less';
var nutshell		= 'less';

function see_more_for_customer()
{
	if(for_customer=='less')
	{
		$('#customer_less_details').hide();
		$('#customer_full_details').show();
		$('#customer_see_more').html('See Less');
		for_customer	= 'more';		
	}
	else
	{
		$('#customer_less_details').show();
		$('#customer_full_details').hide();
		$('#customer_see_more').html('See More');
		for_customer	= 'less';
	}
	
}

function see_more_for_provider()
{
	if(for_provider=='less')
	{
		$('#provider_less_details').hide();
		$('#provider_full_details').show();
		$('#provider_see_more').html('See Less');
		for_provider	= 'more';		
	}
	else
	{
		$('#provider_less_details').show();
		$('#provider_full_details').hide();
		$('#provider_see_more').html('See More');
		for_provider	= 'less';
	}
	
}

function see_more_nutshell()
{
	if(nutshell=='less')
	{
		$('#nutshell_less_details').hide();
		$('#nutshell_full_details').show();
		$('#nutshell_see_more').html('See Less');
		nutshell	= 'more';		
	}
	else
	{
		$('#nutshell_less_details').show();
		$('#nutshell_full_details').hide();
		$('#nutshell_see_more').html('See More');
		nutshell	= 'less';
	}
	
}

$(document).ready(function() {

	 var owl = jQuery("#owl-fea_prj");
	 
	 <?php if($featured_auto_slide == 1){ ?>
	 var auto_silde = true;
	 <?php } else { ?>
	 var auto_silde = false;
	<?php } ?>

	owl.owlCarousel({
	
			autoPlay: auto_silde,
	
		  	navigation : true, // Show next and prev buttons
	
			slideSpeed : '<?php echo $featured_slider_speed;?>',
	
			paginationSpeed : 400,
	
			singleItem:true
	});
});
</script>