<?php
function token($length = 32) {
	// Create random token
	$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	
	$max = strlen($string) - 1;
	
	$token = '';
	
	for ($i = 0; $i < $length; $i++) {
		$token .= $string[mt_rand(0, $max)];
	}	
	
	return $token;
}

/**
 * Backwards support for timing safe hash string comparisons
 * 
 * http://php.net/manual/en/function.hash-equals.php
 */

if(!function_exists('hash_equals')) {
	function hash_equals($known_string, $user_string) {
		$known_string = (string)$known_string;
		$user_string = (string)$user_string;

		if(strlen($known_string) != strlen($user_string)) {
			return false;
		} else {
			$res = $known_string ^ $user_string;
			$ret = 0;

			for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);

			return !$ret;
		}
	}
}

function pre($val) {
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}

function pre_exit($val) {
	echo '<pre>';
	print_r($val);
	echo '</pre>';
	exit;
}

function date2DateText($datetime) {
	$datetime = explode(' ', $datetime);

	$time = explode(':', $datetime[1]);

	$date = explode('-', $datetime[0]);

	$year = $date[0];
	$month = $date[1];
	$day = $date[2];

	if($month == '01') {
		$month_ = 'Jan';
	} elseif($month == '02') {
		$month_ = 'Feb';
	} elseif($month == '03') {
		$month_ = 'Mar';
	} elseif($month == '04') {
		$month_ = 'Apr';
	} elseif($month == '05') {
		$month_ = 'May';
	} elseif($month == '06') {
		$month_ = 'Jun';
	} elseif($month == '07') {
		$month_ = 'Jul';
	} elseif($month == '08') {
		$month_ = 'Aug';
	} elseif($month == '09') {
		$month_ = 'Sep';
	} elseif($month == '10') {
		$month_ = 'Oct';
	} elseif($month == '11') {
		$month_ = 'Nov';
	} elseif($month == '12') {
		$month_ = 'Dec';
	}

	return $day.' '.$month_.' '.$year.'<br>'.$time[0].':'.$time[1];
}