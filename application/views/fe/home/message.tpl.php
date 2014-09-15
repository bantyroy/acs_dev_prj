<div class="container">
	<div class="title">
		<h1>Message</h1>
	</div>
	<div class="breadcrumb">
			<ul>
				<li><a href="<?php echo base_url();?>">Home  &gt;&gt;</a></li>
				<li class="active"><a href="javascript:void(0);">Message</a></li>
			</ul>
	</div>

	<!--sidebar-->
	<div class="sidebar">
		<?php //$this->load->view('fe/cms/cms_left_panel.tpl.php');?>
    </div>

	<!--mainContent-->

	<div class="mainContent">
		<?php include_once(APPPATH."views/fe/common/message.tpl.php"); ?>
	</div>

	<div class="spacer"></div>
</div>