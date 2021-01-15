<?php namespace Aksara\Modules\Addons\Controllers;
/**
 * Addons > FTP Configuration
 *
 * @author			Aby Dahana
 * @profile			abydahana.github.io
 * @website			www.aksaracms.com
 * @since			version 4.0.0
 * @copyright		(c) 2021 - Aksara Laboratory
 */
class Ftp extends \Aksara\Laboratory\Core
{
	private $_table									= 'app__ftp';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->restrict_on_demo();
		
		$this->set_permission(1);
		$this->set_theme('backend');
		
		$this->set_method('update');
		$this->insert_on_update_fail();
	}
	
	public function index()
	{
		$this->set_title('FTP Configuration')
		->set_icon('mdi mdi-console-network')
		->unset_field('site_id')
		->set_field
		(
			array
			(
				'port'								=> 'numeric',
				'password'							=> 'encryption'
			)
		)
		->set_validation
		(
			array
			(
				'hostname'							=> 'required',
				'port'								=> 'required',
				'username'							=> 'required',
				'password'							=> 'required'
			)
		)
		->set_default
		(
			array
			(
				'site_id'							=> get_setting('id')
			)
		)
		->where
		(
			array
			(
				'site_id'							=> get_setting('id')
			)
		)
		->merge_field('hostname, port')
		->field_size
		(
			array
			(
				'hostname'							=> 'col-md-9',
				'port'								=> 'col-md-3'
			)
		)
		->render($this->_table);
	}
	
	public function before_update()
	{
		$this->ftp									= new \FtpClient\FtpClient();
		
		if(!$this->ftp->connect(service('request')->getPost('hostname'), false, service('request')->getPost('port')))
		{
			return throw_exception(400, array('hostname' => phrase('unable_to_connect_to_ftp_using_the_provided_configuration')));
		}
		elseif(!$this->ftp->login(service('request')->getPost('username'), service('request')->getPost('password')))
		{
			return throw_exception(400, array('username' => phrase('unable_to_login_to_ftp_using_the_provided_configuration')));
		}
	}
}
