<?php

function getClientIP() {

	if (isset($_SERVER)) {

		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
			return $_SERVER["HTTP_X_FORWARDED_FOR"];

		if (isset($_SERVER["HTTP_CLIENT_IP"]))
			return $_SERVER["HTTP_CLIENT_IP"];

		return $_SERVER["REMOTE_ADDR"];
	}

	if (getenv('HTTP_X_FORWARDED_FOR'))
		return getenv('HTTP_X_FORWARDED_FOR');

	if (getenv('HTTP_CLIENT_IP'))
		return getenv('HTTP_CLIENT_IP');

	return getenv('REMOTE_ADDR');
}

function user_agent()
{
	return $_SERVER['HTTP_USER_AGENT'];

}



?>