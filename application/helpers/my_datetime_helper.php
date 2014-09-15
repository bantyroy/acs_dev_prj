<?php

set_include_path(APPPATH.'libraries' . PATH_SEPARATOR . get_include_path());

include('I18N/DateTime.php');

function getShortDate($date, $format='') {

	getShortDateWithTime($date);

    $current_language = 'en';//get_current_language();
    
    if( $current_language == 'en') {
        $dateTime = new I18N_DateTime( 'en_GB' );
    }
    else if( $current_language == 'fr') {
       # $dateTime = new I18N_DateTime( 'fr_FR' );
	    $dateTime = new I18N_DateTime( 'fr_FR' );
    }
    else if( $current_language == 'ge') {
        $dateTime = new I18N_DateTime( 'en_GB' );
    }
    else if( $current_language == 'tr') {
        $dateTime = new I18N_DateTime( 'en_GB' );
    }


    if($format==1) {
        return date('d/m/y', strtotime($date));
    }
    else if($format==2) {
        return date('d-m-Y', strtotime($date));
    }
    else if($format==3) {
        return date('d/m/Y', strtotime($date));
    }

    /* 13 août 2010 */
    else if($format==4) {
        $myFormat = $dateTime->setFormat('d F Y');
        return $dateTime->format(strtotime($date));
    }

    /* 13 aug 2010 */
    else if($format==5) {
        $myFormat = $dateTime->setFormat('d M Y');
        return $dateTime->format(strtotime($date));
    }

    /* 13th août */
    else if($format==6) {
        $myFormat = $dateTime->setFormat('jS F');
        
        $formatted_date = $dateTime->format(strtotime($date));
        return $formatted_date;
    }

    /* Vendredi 13 août 2010 */
    else if($format==7) {
        $myFormat = $dateTime->setFormat('l d F Y');

        return ucfirst($dateTime->format(strtotime($date)));
    }
    /* Date format from Config File */
    else  {
        
        $CI= &get_instance();
        $myFormat = $dateTime->setFormat($CI->config->item('display_date_format'));

        return ucfirst($dateTime->format(strtotime($date)));
    }
}

function getShortDateWithTime($date, $format=1) {
    $current_language = 'en';//get_current_language();
	
	// ADDED BY CLIENT REQUEST //
	$format = 2;
    
    
 if( $current_language == 'en') {
        $dateTime = new I18N_DateTime( 'en_GB' );
    }
    else if( $current_language == 'fr') {
       # $dateTime = new I18N_DateTime( 'fr_FR' );
	    $dateTime = new I18N_DateTime( 'fr_FR' );
    }
    else if( $current_language == 'ge') {
        $dateTime = new I18N_DateTime( 'en_GB' );
    }
    else if( $current_language == 'tr') {
        $dateTime = new I18N_DateTime( 'en_GB' );
    }

    //$myFormat = $dateTime->setFormat('l d F Y');
    //return utf8_encode(ucfirst($dateTime->format()));

    if($format==1) {
        if( $current_language == 'en') {
            $myFormat = $dateTime->setFormat('d/m/y \a\t H:i');
        }
        else if( $current_language == 'fr') {
            $myFormat = $dateTime->setFormat('d/m/y à H\hi');
        }
    }
    else if($format==2) {
        if( $current_language == 'en') {
            $myFormat = $dateTime->setFormat('l, F d, Y \a\t H:i');
        }
        else if( $current_language == 'fr') {
            $myFormat = $dateTime->setFormat('l d F Y à H\hi');
        }
    }

    #return $dateTime->format();
    return $dateTime->format(strtotime($date));
}


function getShortTime($mysql_time, $format=1) {
    $current_language = 'en';//get_current_language();

    $meridian = 'am';
    
    $hour = substr($mysql_time, 0, 2);

    $hour_original = $hour;

    if($hour>12) {
        $hour = $hour - 12;
        $meridian = 'pm';
    }

    $minute = substr($mysql_time, 3, 2);
    $second = substr($mysql_time, 6, 2);

    if($format==1) {
        if( $current_language == 'en') {
            return $hour.':'.$minute.$meridian;
        }
        else if( $current_language == 'fr') {
            return $hour.'h'.$minute.$meridian;
        }
    }
    else if($format==2) {
        if( $current_language == 'en') {
            return $hour_original.':'.$minute;
        }
        else if( $current_language == 'fr') {
            return $hour_original.'h'.$minute;
        }
    }
}


function get_age_from_dob($dob) {
    if($dob=='') {
        return '&nbsp;';
    }
    $year_dob = substr($dob, 0, 4);
    $month_dob = substr($dob, 5, 2);
    $day_dob = substr($dob, 8, 2);

    $total_dob = $year_dob*365+$month_dob*30+$day_dob;

    $now = date('Y-m-d');

    $year_now = substr($now, 0, 4);
    $month_now = substr($now, 5, 2);
    $day_now = substr($now, 8, 2);

    $total_now = $year_now*365+$month_now*30+$day_now;
    

    $age = (int) (($total_now-$total_dob)/(365));

    if( $age <= 10 || $age >=200 ) {
        return '';
    }

    return $age;
}


function get_time_elapsed($datetime) {
//     $a = 'a moments ago';
//     $b = '12 seconds ago';
//     $c = '34 minutes ago';
//     $d = 'about an hour ago';
//     $e = '2 hours ago';
//     $f = '12 hours ago';
//     $a = 'Yesterday at 11:44pm';
//     $a = 'Saturday at 5:58pm';
//     $a = 'May 20 at 8:46pm';
//     $a = 'May 16 at 12:37pm';

    $current_language = 'en';//get_current_language();
# echo ' @@'.get_db_datetime();

    $current_timestamp = strtotime(get_db_datetime());
    $another_timestamp = strtotime($datetime);

    $time_diff = $current_timestamp - $another_timestamp;

    $str = '';

    
        $dateTime = new I18N_DateTime( 'en_GB' );

        if( $time_diff <= 0 || $time_diff == 1 ) {
            $str = 'a moment ago';
        }
        else if( $time_diff <= 59 ) {
             $str = $time_diff.' seconds ago';
        }
        else if( (int) ($time_diff/60) <= 59 ) {
            $minute_diff = (int) ($time_diff/60);
            if( $minute_diff == 1 ) {
                $str = $minute_diff.' minute ago';
            }
            else {
                $str = $minute_diff.' minutes ago';
            }
        }
        else if( (int) ($time_diff/3600) < 24 ) {
            $hour_diff = (int) ($time_diff/3600);
            if( $hour_diff == 1 ) {
                $str = $hour_diff.' hour ago';
            }
            else {
                $str = $hour_diff.' hours ago';
            }
        }
  else
  {
   		$str = getShortDateWithTime($datetime,9); // 6
  }
        /*else if( (int) ($time_diff/3600) < 48 ) {
            $myFormat = $dateTime->setFormat('\a\t g(idea) a');
            $str = 'Yesterday '.$dateTime->format($another_timestamp);
        }
        else if( (int) ($time_diff/3600) < 96 ) {
            $myFormat = $dateTime->setFormat('l \a\t g(idea) a');
            $str = $dateTime->format($another_timestamp);
        }
        else {
            $myFormat = $dateTime->setFormat('F d \a\t g(idea) A');
            $str = $dateTime->format($another_timestamp);
        }*/    

    return $str;
}


function get_formated_time($total_seconds) {
	$hours = $mins = $secs = 0;

	$mins = (int) ($total_seconds / 60);
	$secs = $total_seconds % 60;
	
	if($mins>=60) {
		$hours = (int) ($mins / 60);
		$mins = $mins % 60;
	}
	
	$return_str = '';
	
	$current_language = 'en';//get_current_language();
    
    if($current_language == 'en') {
		if($hours==1) {
			$return_str .= $hours.' hour ';
		}
		else if($hours!=0) {
			$return_str .= $hours.' hours ';
		}
		
		if($mins==1) {
			$return_str .= $mins.' minute ';
		}
		else if($mins!=0) {
			$return_str .= $mins.' minutes ';
		}
		
		if($secs==1) {
			$return_str .= $secs.' second ';
		}
		else if($secs!=0) {
			$return_str .= $secs.' seconds ';
		}
	}
	else if($current_language == 'fr') {
		if($hours==1) {
			$return_str .= $hours.' hour ';
		}
		else if($hours!=0) {
			$return_str .= $hours.' hours ';
		}
		
		if($mins==1) {
			$return_str .= $mins.' minute ';
		}
		else if($mins!=0) {
			$return_str .= $mins.' minutes ';
		}
		
		if($secs==1) {
			$return_str .= $secs.' second ';
		}
		else if($secs!=0) {
			$return_str .= $secs.' seconds ';
		}
	}
	
	return $return_str = trim($return_str, ', ');
}



//// function to get date in specified format...
function getDesiredDate($date, $format)
{
    $dateTime = new I18N_DateTime( 'en_GB' );
    
	# $dateTime = new I18N_DateTime( 'en_GB' );
	$customFormat = $dateTime->setFormat($format);


	$formatted_dt = $dateTime->format(strtotime($date));

	return $formatted_dt;
}


# month-name in desired language format...
function getMonthName($monthIndex, $current_language='fr')
{
	    $current_language = 'en';//get_current_language();

		if( $current_language == 'en') {
				$dateTime = new I18N_DateTime( 'en_GB' );
		}
		else if( $current_language == 'fr') {
				$dateTime = new I18N_DateTime( 'fr_FR' );
		}

		$myFormat = $dateTime->setFormat('F');

		$strTime = mktime(0,0,0,$monthIndex);
		$month_name = $dateTime->format($strTime);

		#return utf8_encode($month_name);
		return  $month_name;
}


/////////GET DATABASE DATETIME////////
function get_db_datetime() {
	try
	{ 
		/*return date('Y-m-d H:i:s');*/
	    $CI= &get_instance();
		$sq= "SELECT NOW() AS db_dt ";
		$rs = $CI->db->query($sq);
		if(is_array($rs->result())) {
			  foreach($rs->result() as $row)
			  {
				  $ret_=$row->db_dt; 
			  }    
			  $rs->free_result();          
		  }
	   
	   return $ret_;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}   
  }
  
/*  
  function dateDifference($startDate, $endDate)
	{
		$startDate = strtotime($startDate);
		$endDate = strtotime($endDate);
		if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate)
			return false;
		   
		$years = date('Y', $endDate) - date('Y', $startDate);
	   
		$endMonth = date('m', $endDate);
		$startMonth = date('m', $startDate);
	   
		// Calculate months
		$months = $endMonth - $startMonth;
		if ($months <= 0)  {
			$months += 12;
			$years--;
		}
		if ($years < 0)
			return false;
	   
		// Calculate the days
					$offsets = array();
					if ($years > 0)
						$offsets[] = $years . (($years == 1) ? ' year' : ' years');
					if ($months > 0)
						$offsets[] = $months . (($months == 1) ? ' month' : ' months');
					$offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now';

					$days = $endDate - strtotime($offsets, $startDate);
					$days = date('z', $days);   
				   
		return array($years, $months, $days);
	} 
*/



function date_difference ($first, $second)
{
    $month_lengths = array (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    $retval = FALSE;

    if (    checkdate($first['month'], $first['day'], $first['year']) &&
            checkdate($second['month'], $second['day'], $second['year'])
        )
    {
        $start = smoothdate ($first['year'], $first['month'], $first['day']);
        $target = smoothdate ($second['year'], $second['month'], $second['day']);
                            
        if ($start <= $target)
        {
            $add_year = 0;
            while (smoothdate ($first['year']+ 1, $first['month'], $first['day']) <= $target)
            {
                $add_year++;
                $first['year']++;
            }
                                                                                                            
            $add_month = 0;
            while (smoothdate ($first['year'], $first['month'] + 1, $first['day']) <= $target)
            {
                $add_month++;
                $first['month']++;
                
                if ($first['month'] > 12)
                {
                    $first['year']++;
                    $first['month'] = 1;
                }
            }
                                                                                                                                                                            
            $add_day = 0;
            while (smoothdate ($first['year'], $first['month'], $first['day'] + 1) <= $target)
            {
                if (($first['year'] % 100 == 0) && ($first['year'] % 400 == 0))
                {
                    $month_lengths[1] = 29;
                }
                else
                {
                    if ($first['year'] % 4 == 0)
                    {
                        $month_lengths[1] = 29;
                    }
                }
                
                $add_day++;
                $first['day']++;
                if ($first['day'] > $month_lengths[$first['month'] - 1])
                {
                    $first['month']++;
                    $first['day'] = 1;
                    
                    if ($first['month'] > 12)
                    {
                        $first['month'] = 1;
                    }
                }
                
            }
                                                                                                                                                                                                                                                        
            #$retval = array ('years' => $add_year, 'months' => $add_month, 'days' => $add_day);
			
			$retval = array($add_year, $add_month, $add_day);
        }
    }
                                                                                                                                                                                                                                                                                
    return $retval;
}

function dateDifference($customer_dob,$current_date)
 {
  
	$date_diff_array =array();
	$array_customer_dob = explode("-",date("Y-m-d",strtotime($customer_dob)));
	$array_policy_create_dt = explode("-",date("Y-m-d",strtotime($current_date)));
	
	$begin = array ('year' => $array_customer_dob[0], 'month' => $array_customer_dob[1], 'day' => $array_customer_dob[2]);
	$end =  array ('year' => $array_policy_create_dt[0], 'month' => $array_policy_create_dt[1], 'day' => $array_policy_create_dt[2]);
	$date_diff_array = date_difference ($begin, $end);
	return $date_diff_array ;
 }
 
 function smoothdate ($year, $month, $day)
{
    return sprintf ('%04d', $year) . sprintf ('%02d', $month) . sprintf ('%02d', $day);
}

function get_month_difference($date1,$date2)
{
	$date1 =  explode('-',$date1);
	$date2 =  explode('-',$date2);	
	$d1	=	mktime(0,0,0,$date1[1],$date1[2],$date1[0]);
	$d2	=	mktime(0,0,0,$date2[1],$date2[2],$date2[0]);
	$month	= floor(($d2-$d1)/2628000); 
	return $month;
}


# =======================================================================================
#           NEW FUNCTIONS [BEGIN]
# =======================================================================================

    # function to fetch "job-time-posted" elapsed...
    function get_job_posted_time_elapsed($datetime) {
    //     $a = 'a moments ago';
    //     $b = '12 seconds ago';
    //     $c = '34 minutes ago';
    //     $d = 'about an hour ago';
    //     $e = '2 hours ago';
    //     $f = '12 hours ago';
    //     $a = 'Yesterday at 11:44pm';
    //     $a = 'Saturday at 5:58pm';
    //     $a = 'May 20 at 8:46pm';
    //     $a = 'May 16 at 12:37pm';

        $current_timestamp = strtotime(get_db_datetime());
        $another_timestamp = strtotime($datetime);

        $time_diff = $current_timestamp - $another_timestamp;

        $str = '';

        # Time elapsed text [Begin]
            $dateTime = new I18N_DateTime( 'en_GB' );

            if( $time_diff == 0 || $time_diff == 1 ) {
                $str = 'a moment ago';
            }
            else if( $time_diff <= 59 ) {
                $str = $time_diff.' seconds ago';
            }
            else if( (int) ($time_diff/60) <= 59 ) {
                $minute_diff = (int) ($time_diff/60);
                if( $minute_diff == 1 ) {
                    $str = $minute_diff.' minute ago';
                }
                else {
                    $str = $minute_diff.' minutes ago';
                }
            }
            else if( (int) ($time_diff/3600) < 24 ) {
                $hour_diff = (int) ($time_diff/3600);
                if( $hour_diff == 1 ) {
                    $str = $hour_diff.' hour ago';
                }
                else {
                    $str = $hour_diff.' hours ago';
                }
            }
            else {
                #getShortDateWithTime($datetime);
                //// get day(s) elapsed after job-posting-date...
                $str = get_job_posted_days_elapsed_str($datetime);
            }
        # Time elapsed text [End]
            

        return $str;
    }
    
    
    # function to get-time-elapsed in day(s)...
    function get_job_posted_days_elapsed_str($datetime)
    {
        $DT1 = $datetime;
        $DT2 = date('Y-m-d H:i:s');
        
        $dt_diff = floor( (strtotime($DT2) - strtotime($DT1))/(60*60*24) );
        $diff_str = "{$dt_diff} days ago";
        
        return $diff_str;
    }


    
    # ~~~~~~~~~~~~~ Time Elapsed function with a different format [Begin]

        # function to fetch "message-time-posted" elapsed...
        function get_msg_posted_time_elapsed($tStamp) {
        //     $a = 'a moments ago';
        //     $b = '12 seconds ago';
        //     $c = '34 minutes ago';
        //     $d = 'about an hour ago';
        //     $e = '2 hours ago';
        //     $f = '12 hours ago';
        //     $a = 'Yesterday at 11:44pm';
        //     $a = 'Saturday at 5:58pm';
        //     $a = 'May 20 at 8:46pm';
        //     $a = 'May 16 at 12:37pm';

            $current_timestamp = strtotime(get_db_datetime());
            $another_timestamp = $tStamp;

            $time_diff = $current_timestamp - $another_timestamp;

            $str = '';

            # Time elapsed text [Begin]
                $dateTime = new I18N_DateTime( 'en_GB' );

                if( $time_diff == 0 || $time_diff == 1 ) {
                    $str = 'a moment ago';
                }
                else if( $time_diff <= 59 ) {
                    $str = $time_diff.' seconds ago';
                }
                else if( (int) ($time_diff/60) <= 59 ) {
                    $minute_diff = (int) ($time_diff/60);
                    if( $minute_diff == 1 ) {
                        $str = $minute_diff.' minute ago';
                    }
                    else {
                        $str = $minute_diff.' minutes ago';
                    }
                }
                else if( (int) ($time_diff/3600) < 24 ) {
                    $hour_diff = (int) ($time_diff/3600);
                    if( $hour_diff == 1 ) {
                        $str = $hour_diff.' hour ago';
                    }
                    else {
                        $str = $hour_diff.' hours ago';
                    }
                }
                else if( (int) ($time_diff/3600) < 48 ) {
                    $myFormat = $dateTime->setFormat(', g:i a');
                    $str = 'Yesterday '.$dateTime->format($another_timestamp);
                }
                else if( (int) ($time_diff/3600) < 96 ) {
                    $myFormat = $dateTime->setFormat('l, g:i a');
                    $str = $dateTime->format($another_timestamp);
                }
                else {
                    //// get time after message posted...
                    $str = get_msg_posted_time_str($datetime);
                }
            # Time elapsed text [End]
                

            return $str;
        }
        
        
        # function to get-time-elapsed in day(s)...
        function get_msg_posted_time_str($tStamp, $format='M j, g:i a')
        {
            $posted_time = date( $format, $tStamp );
            
            return $posted_time;
        }

    # ~~~~~~~~~~~~~ Time Elapsed function with a different format [End]
    
    
    
    # NEW - function to fetch future date (added days or months or years)...
    function _fetch_future_date($from_date, $interval=1, $interval_type='d', $dt_format='Y-m-d H:i:s') {
        
        $from_date_tStamp = strtotime($from_date);
        
        $interval_type = _get_interval_type( $interval_type );
        $interval_type = ( $interval>1 )? "{$interval_type}s": $interval_type;
        
        $dt_interval = "+{$interval} {$interval_type}";
        
        $next_dt = date($dt_format, strtotime("{$dt_interval}", $from_date_tStamp));
        
        return $next_dt;
    }
    
    # NEW - function to get interval-type...
    function _get_interval_type($type) {
        
        $interval_type = '';
        switch($type) {
            case 'd': $interval_type = 'day';
                      break;
            case 'm': $interval_type = 'month';
                      break;
            case 'y': $interval_type = 'year';
                      break;
            default : $interval_type = 'day';
                      break;
        }
        
        return $interval_type;
    }
    
    
    
    # NEW - function to get current week's start-N-end date(s)...
    function _get_week_start_N_end_dates($date, $format = 'Y-m-d') {
        
        //Is $date timestamp or date?
        if (is_numeric($date) AND strlen($date) == 10) {
            $time = $date;
        }else{
            $time = strtotime($date);
        }
        
        $week['week'] = date('W', $time);
        $week['year'] = date('o', $time);
        $week['year_week']           = date('oW', $time);
        $first_day_of_week_timestamp = strtotime($week['year']."W".str_pad($week['week'],2,"0",STR_PAD_LEFT));
        $week['week_start_dt']   = date($format, $first_day_of_week_timestamp);
        $week['first_day_of_week_timestamp'] = $first_day_of_week_timestamp;
        $last_day_of_week_timestamp = strtotime($week['week_start_dt']. " +6 days");
        $week['week_end_dt']   = date($format, $last_day_of_week_timestamp);
        $week['last_day_of_week_timestamp']  = $last_day_of_week_timestamp;
        
        return $week;
    }
    
    
    # NEW - function to get current week no.
    function _get_week_number($param_date=null) {
        
        $param_date = ( !empty($param_date) )? $param_date: date('Y-m-d');
        $week_no = date('W', strtotime($param_date));
        
        return $week_no;
    }
    
    
    # NEW -  function to get week start & end date by week-number...
    function _get_start_N_end_date_by_week_number($week, $year=null, $dt_format='Y-m-d')
    {
        $year = ( !empty($year) )? $year: date('Y');
        
        $date_string = $year . 'W' . sprintf('%02d', $week);
        $return['week_start_dt'] = date($dt_format, strtotime($date_string));
        $return['week_end_dt'] = date($dt_format, strtotime($date_string . '7'));
        
        return $return;
    }
	

# =======================================================================================
#           NEW FUNCTIONS [END]
# =======================================================================================

	function job_end_days($approval_date, $interval)
	{
		$job_end_date	= _fetch_future_date($approval_date, $interval);
		
		$diff			= strtotime($job_end_date)-strtotime(get_db_datetime()); /// End time is calculated based on current time
		
		// immediately convert to days
		$temp=$diff/86400; // 60 sec/min*60 min/hr*24 hr/day=86400 sec/day

		// days
		$days=floor($temp); 
		$temp=24*($temp-$days);
		// hours
		$hours=floor($temp); 
		$temp=60*($temp-$hours); 
		
		return $days.'d '.$hours.'h';
		
	}