
<script type="text/javascript">
$(document).ready(function(e) {
    $(".ajax").colorbox();
});

</script>
<div id="content" class="span10">
	<!-- content starts -->	
	<?php echo admin_breadcrumb($BREADCRUMB); ?>
	<?php
	if(!empty($article_count_by_type))
	{
		foreach($article_count_by_type as $v)
		{
			if($v['e_fetch_type'] == 'rss') $rss = intval($v['total']);
			if($v['e_fetch_type'] == 'html') $html = $v['total'];
			if($v['e_fetch_type'] == 'only_rss') $only_rss = $v['total'];
		}
	}
	
	?>
    <div class="sortable row-fluid">
        <a title="<?php echo $article_in_last_10_days[0]['total'].' '. addslashes(t("article in the last 10 days"))?>" class="well span2 top-block" href="<?php echo base_url('web_master/view_xml_news/show_list')?>">
            <span class="icon32 icon-color icon-copy"></span>
            <div><?php echo addslashes(t("Total article in the last 10 days")) ?></div>
            <div></div>
            <span class="notification yellow"><?php echo $article_in_last_10_days[0]['total']?></span>
        </a>
    
        <a title="<?php echo $rss?> article found by RSS." class="well span2 top-block" href="<?php echo base_url('web_master/view_xml_news/show_list')?>">
            <span class="icon32 icon-color icon-page"></span>
            <div><?php echo addslashes(t("RSS")) ?></div>
            <div><?php echo $total_tasks ?></div>
            <span class="notification green"><?php echo $rss?></span>
        </a>
        <a title="<?php echo $html?> article found by HTML." class="well span2 top-block" href="<?php echo base_url('web_master/view_xml_news/show_list')?>">
            <span class="icon32 icon-color icon-page"></span>
            <div><?php echo addslashes(t("HTML")) ?></div>
            <div><?php echo $total_tasks ?></div>
            <span class="notification green"><?php echo $html?></span>
        </a>
        <a title="<?php echo $only_rss?> article found by RSS Only." class="well span2 top-block" href="<?php echo base_url('web_master/view_xml_news/show_list')?>">
            <span class="icon32 icon-color icon-page"></span>
            <div><?php echo addslashes(t("RSS Only")) ?></div>
            <div><?php echo $total_tasks ?></div>
            <span class="notification green"><?php echo $only_rss?></span>
        </a>
        <a title="<?php echo $total_article_today?> article found today." class="well span2 top-block" href="<?php echo base_url('web_master/view_xml_news/show_list')?>">
            <span class="icon32 icon-color icon-page"></span>
            <div><?php echo addslashes(t("Article found today")) ?></div>
            <div><?php echo $total_tasks ?></div>
            <span class="notification yellow"><?php echo $total_article_today?></span>
        </a>
        <a title="<?php echo $total_customer?> registred customer." class="well span2 top-block" href="<?php echo base_url('web_master/manage_customer/show_list')?>">
            <span class="icon32 icon-color icon-users"></span>
            <div><?php echo addslashes(t("Total Customers")) ?></div>
            <div><?php echo $total_tasks ?></div>
            <span class="notification red"><?php echo $total_customer?></span>
        </a>
    </div>
	<div class="row-fluid">
        <div class="box span12">
            <div class="box-header well">
                <h2><i class="icon-info-sign"></i> <?php echo addslashes(t("Last 10 days article graph"))?></h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div>
				<?php 
				$data = $last_ten_days_data['html'];
				echo '<img src="'.base_url('graph_lib').'show_graph/'.urlencode(serialize($data)).'" align="center" title="Last 10 days article graph corresponding to HTML, RSS, RSS Only"/>';
                ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>		
    <div class="row-fluid">
    	<div class="box span12">
            <div class="box-header well">
                <h2><i class="icon-info-sign"></i> <?php echo addslashes(t("System Log"))?></h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <table class="table table-bordered">
                    <tr>
                        <td colspan="2"  align="center"><strong>RSS Activities</strong></td>
                        <td colspan="2"  align="center"><strong>HTML Activities</strong></td>
                    </tr>
                    <tr>
                        <td width="25%" align="center">Start</td>
                        <td width="25%" align="center">End</td>
                        <td width="25%" align="center">Start</td>
                        <td width="25%" align="center">End</td>
                    </tr>
                    <tr>
                        <td width="25%" align="center"><?php echo make_admin_date($cron_log['rss_start'][0]['log_time'])?></td>
                        <td width="25%" align="center"><?php echo make_admin_date($cron_log['rss_end'][0]['log_time'])?></td>
                        <td width="25%" align="center"><?php echo make_admin_date($cron_log['html_start'][0]['log_time'])?></td>
                        <td width="25%" align="center"><?php echo make_admin_date($cron_log['html_end'][0]['log_time'])?></td>
                    </tr>
                    <tr>
                        <td width="25%" align="center"><?php echo make_admin_date($cron_log['rss_start'][1]['log_time'])?></td>
                        <td width="25%" align="center"><?php echo make_admin_date($cron_log['rss_end'][1]['log_time'])?></td>
                        <td width="25%" align="center"><?php echo make_admin_date($cron_log['html_start'][1]['log_time'])?></td>
                        <td width="25%" align="center"><?php echo make_admin_date($cron_log['html_end'][1]['log_time'])?></td>
                    </tr>
                </table>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="box span12">
            <div class="box-header well">
                <h2><i class="icon-info-sign"></i> <?php echo addslashes(t("User Activity"))?></h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <ul class="dashboard-list">
                	<li>Log in: <span class="green"><?php echo $login_activity?></span></li>
                    <li>Add customer: <span class="red"><?php echo $customer_added_today?></span></li>
                    <li>Modify customer: <span class="yellow"><?php echo $customer_updated_today?></span></li>
                    <li>Send email</li>
                    <li>Modify article</li>
                </ul>
                
                <div class="clearfix"></div>
            </div>
        </div>
        
        
	</div>
    
    
</div>
<style type="text/css">
.row-fluid [class*="span"]{min-height:90px;}
ul.dashboard-list li span{font-size:18px; font-weight:bold;}
</style>