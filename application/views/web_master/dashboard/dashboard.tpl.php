
<script type="text/javascript">
$(document).ready(function(e) {
    $(".ajax").colorbox();
});

</script>
<section class="content">
	<div class="row">
    	<div class="col-lg-3 col-xs-6">
        	<div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            150
                        </h3>
                        <p>
                            Providers
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="<?php echo admin_base_url()?>provider_list" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
            </div>
        </div>   
        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            53<sup style="font-size: 20px">%</sup>
                        </h3>
                        <p>
                            Customers
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="<?php echo admin_base_url()?>customer_list" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
         <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>
                            44
                        </h3>
                        <p>
                            Guests
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
          <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            65
                        </h3>
                        <p>
                            Job Posted
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
    </div><!-- row end-->
    <!-- top row -->
        <div class="row">
            <div class="col-xs-12 connectedSortable">
                <?php 
					$data = $last_ten_days_data['html'];
					echo '<img src="'.base_url('graph_lib').'/show_graph/" align="center" title="Last 10 days article graph corresponding to HTML, RSS, RSS Only"/>';
                ?>
            </div><!-- /.col -->
        </div>
                    <!-- /.row -->
</section>