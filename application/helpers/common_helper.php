<?php

/**
 * 检测id格式
 * @param int $id
 */
if (!function_exists('checkId'))
{
	function checkId($id)
	{
		$reg="#(^[0-9]{1,}$)#";
		if (!preg_match($reg, $id))
		{
			return false;
		}
		return true;
	}
}
