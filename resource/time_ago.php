<?php
function time_stamp($time_ago)
{ 
	$cur_time		= time();
	$time_elapsed	= $cur_time - $time_ago; 
	$seconds		= $time_elapsed ; 
	$minutes		= round($time_elapsed / 60 );
	$hours			= round($time_elapsed / 3600); 
	$days			= round($time_elapsed / 86400 ); 
	$weeks 			= round($time_elapsed / 604800); 
	$months 		= round($time_elapsed / 2600640 ); 
	$years 			= round($time_elapsed / 31207680 ); 

	// Seconds
	if($seconds <= 60)
		echo "$seconds seconds ago"; 
 	//Minutes
	/*else */if($minutes <=60)
	{
		if($minutes==1)
			echo "one minute ago "; 
		else
			echo "$minutes minutes ago"; 
	}
	//Hours
	/*else */if($hours <=24)
	{
		if($hours==1)
			echo "an hour ago";
		else
			echo "$hours hours ago";
	}
 //Days
	/*else */if($days <= 7)
	{
		if($days==1)
			echo "yesterday";
		else
			echo "$days days ago";
	}
	//Weeks
	/*else */if($weeks <= 4.3)
	{
		if($weeks==1)
			echo "a week ago";
		else
			echo "$weeks weeks ago";
	}
	//Months
	/*else */if($months <=12)
	{
		if($months==1)
			echo "a month ago";
		else
			echo "$months months ago";
	}
 	//Years
	else
	{
		if($years==1)
			echo "one year ago";
		else
			echo "$years years ago";
	}
}

$time="2012-01-05 15:47:01";
$time_ago = strtotime($time);
echo time_stamp($time_ago);


echo '...........................<br>';
function time_ago($tm, $rcs = 0) {
	$cur_tm = time(); $dif = $cur_tm-$tm;
	$pds = array('second','minute','hour','day','week','month','year','decade');
	$lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
	for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); 
	if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);
	$no = floor($no); 
	if($no <> 1) $pds[$v] .='s'; 
	$x=sprintf("%d %s ",$no,$pds[$v]);
	if(($rcs > 0)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm, --$rcs);
	return $x;
}
echo time_ago(strtotime('2014-03-01 12:20:28'),0).' ago';