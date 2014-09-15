<?php
function get_current_language() {
	$CI = get_instance();
	/* if no language variable in session default language is master language */
	$languages = $CI->config->item('languages');
        $default_language = $CI->config->item('default_language');
        if( $CI->session->userdata('current_language')!='' && in_array( $CI->session->userdata('current_language'), $languages) ) {
		$current_language = $CI->session->userdata('current_language');
	}
	else {
		$current_language = $default_language;
	}
        
	return $current_language;
}

function t($str) {
	$ci = get_instance();
	$current_language = get_current_language();
	$tc = $ci->get_translations();
	//$current_language = 'ar';
	if($tc !== null) {
		$tf = $tc->getById($str);
		
		if($tf !== null) {
			$data = $tf->getData();
			if( array_key_exists($current_language, $data) && trim($data[$current_language])!='' ) {
				return $data[$current_language];
			}
		}
	}
	return $str;
}

function tp($singular, $plural, $n) {
	$current_language = get_current_language();

	$type = null;
	$type = getplural($current_language, $n);

	if($type=='singular') {
		return sprintf(t($singular), $n);
	}
	else {
		return sprintf(t($plural), $n);
	}
}


function getplural($language, $n) {
	if($n==0||$n>1) {
		return 'plural';
	}
	else {
		return 'singular';
	}
}

function cur_lang($arr, $key) {
	if(!is_array($arr)) {
		return '';
	}

	$current_language = get_current_language();

	if( isset($arr[$key.'_'.$current_language]) && $arr[$key.'_'.$current_language] != '' ) {
		return $arr[$key.'_'.$current_language];
	}

	$ci = get_instance();

	$master_language = $ci->config->item('default_language');

	if( isset($arr[$key.'_'.$master_language]) && $arr[$key.'_'.$master_language] != '' ) {
		return $arr[$key.'_'.$master_language];
	}

	$languages = $ci->config->item('languages');

	foreach( $languages as $language ) {
		if( isset($arr[$key.'_'.$language]) && $arr[$key.'_'.$language] != '' ) {
			return $arr[$key.'_'.$language];
		}
	}

	return '';
}


function def_lang($arr, $key) {
	if(!is_array($arr)) {
		return '';
	}

	$ci = get_instance();

	$master_language = $ci->config->item('default_language');

	if( isset($arr[$key.'_'.$master_language]) && $arr[$key.'_'.$master_language] != '' ) {
		return $arr[$key.'_'.$master_language];
	}

	$languages = $ci->config->item('languages');

	foreach( $languages as $language ) {
		if( isset($arr[$key.'_'.$language]) && $arr[$key.'_'.$language] != '' ) {
			return $arr[$key.'_'.$language];
		}
	}

	return '';
}



