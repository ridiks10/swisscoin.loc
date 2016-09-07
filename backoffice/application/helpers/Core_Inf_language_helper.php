<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter DB extencion Language Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Artem Grigorenko
 */

// ------------------------------------------------------------------------

if ( ! function_exists('lang'))
{

    /**
     * Fetches a language variable and optionally outputs a form label
     * @param string $line the line of text to translate
     * @param string $id the id of the form element
     * @param string|array $default [optional] Treat as default value for fallback if string,
     * or as list of replacement parameters if array
     * @param array $params [optional] List of replacement parameters
     * @return string
     */
	function lang($line, $id = '', $default = null, $params = [])
	{
		$CI =& get_instance();
		$line = $CI->lang->line($line, $default, $params);

		if ($id != '')
		{
			$line = '<label for="'.$id.'">'.$line."</label>";
		}

		return $line;
	}
}

// ------------------------------------------------------------------------
