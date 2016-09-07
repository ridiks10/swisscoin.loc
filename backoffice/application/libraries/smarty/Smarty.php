<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Smarty Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Smarty
 * @author		Kepler Gelotte
 * @link		https://www.coolphptools.com/codeigniter-smarty
 */
require_once( BASEPATH.'libraries/smarty/Smarty.class.php' );

class CI_Smarty extends Smarty {

	function __construct()
	{
		parent::__construct();

		$this->compile_dir  = APPPATH . "views/templates_c/";
		$this->template_dir = APPPATH . "views/";
		$this->assign( 'APPPATH' , APPPATH );
		$this->assign( 'BASEPATH', BASEPATH );
                $base_url = base_url();
		$this->assign( 'BASE_URL', $base_url );
                $this->assign( 'PATH_TO_ROOT_DOMAIN', $base_url );
                $this->assign( 'PATH_TO_ROOT', $base_url );
                $this->assign( 'PUBLIC_URL', $base_url."public_html/" );
                $this->assign( 'COMPANY_LOGO', $base_url."public_html/images/ioss_logo.png" );
		// Customisations (IK 02NOV2011)
		//$this->left_delimiter  = '[~'; 
		//$this->right_delimiter = '~]';
		//$this->error_reporting = 'E_ALL ^ E_NOTICE';
		
		// Assign CodeIgniter object by reference to CI
		if ( method_exists( $this, 'assignByRef') )
		{
			$ci =& get_instance();
			$this->assignByRef("ci", $ci);
		}

		log_message('debug', "Smarty Class Initialized");
	}

	/**
	 *  Parse a template using the Smarty engine
	 *
	 * This is a convenience method that combines assign() and
	 * display() into one step. 
	 *
	 * Values to assign are passed in an associative array of
	 * name => value pairs.
	 *
	 * If the output is to be returned as a string to the caller
	 * instead of being output, pass true as the third parameter.
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */
	function view($template, $data = array(), $return = FALSE)
	{
		foreach ($data as $key => $val)
		{
			$this->assign($key, $val);

		}
		
		if ($return == FALSE)
		{
                       
			$CI =& get_instance();
			if (method_exists( $CI->output, 'set_output' ))
			{
                               
				$CI->output->set_output( $this->fetch($template) );
			}
			else
			{	
				$CI->output->final_output = $this->fetch($template);
			}
			return;
		}
		else
		{

			return $this->fetch($template);
		}
	}
}
// END Smarty Class
