<!DOCTYPE HTML>
<html>
<?php $this->load->view('fe/common/head.inc.tpl.php');?>
<body>

    <!-- header -->
    <?php $this->load->view('fe/common/header.inc.tpl.php');?>
    <!-- end of header --> 
    
    <!-- banner-section [iff HOME page] - Begin -->
    <?php
		if( $home_page )
    		$this->load->view('fe/common/HP_banners.inc.tpl.php');
	?>
    <!-- banner-section [iff HOME page] - End --> 


    <!-- slogan-wrapper-section - Begin -->
    <?php
		if( $home_page )
    		$this->load->view('fe/common/HP_slogan_wrapper.inc.tpl.php');
		else
    		$this->load->view('fe/common/slogan_wrapper.inc.tpl.php');
	?>
    <!-- slogan-wrapper-section - End --> 
    

    <!-- Main page content -->
    <?php
		$CSS_CONTENT = ( $home_page )? 'content_wrapper': 'container';
	?>
    <div class="<?= $CSS_CONTENT ?>">
        <?php echo $content;?>
    </div>
    <!-- End main page section -->


    <!-- footer -->
    <?php $this->load->view('fe/common/footer.inc.tpl.php');?>
    <!-- end of footer -->

<!-- end of container -->
</body>
</html>