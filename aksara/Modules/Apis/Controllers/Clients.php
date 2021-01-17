<?php namespace Aksara\Modules\Apis\Controllers;
/**
 * APIS > Clients
 *
 * @author			Aby Dahana
 * @profile			abydahana.github.io
 * @website			www.aksaracms.com
 * @since			version 4.0.0
 * @copyright		(c) 2021 - Aksara Laboratory
 */
class Clients extends \Aksara\Laboratory\Core
{
	private $_table									= 'rest__clients';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->restrict_on_demo();
		
		$this->set_permission(1);
		$this->set_theme('backend');
		
		$this->_primary								= service('request')->getGet('user_id');
	}
	
	public function index()
	{
		$this->set_title(phrase('manage_rest_clients'))
		->set_icon('mdi mdi-account-check-outline')
		->unset_column('id, redirect_uri_validator')
		->unset_field('id')
		->unset_view('id')
		->column_order('first_name')
		->set_field
		(
			array
			(
				'api_key'							=> '',
				'ip_range'							=> 'textarea',
				'valid_until'						=> 'datepicker',
				'status'							=> 'boolean'
			)
		)
		->set_field
		(
			'method',
			'checkbox',
			array
			(
				'GET'								=> 'GET',
				'POST'								=> 'POST',
				'PUT'								=> 'PUT',
				'DELETE'							=> 'DELETE'
			)
		)
		->set_field('first_name', 'hyperlink', 'apis/permissions', array('client' => 'user_id'))
		->add_action('option', '../permissions', phrase('permission'), 'btn-dark --xhr', 'mdi mdi-security-network', array('client' => 'user_id'))
		->set_relation
		(
			'user_id',
			'app__users.user_id',
			'{app__users.first_name} {app__users.last_name}',
			array
			(
				'app__users.status'					=> 1
			)
		)
		->set_validation
		(
			array
			(
				'user_id'							=> 'required|is_unique[' . $this->_table . '.user_id,user_id,' . $this->_primary . ']',
				'api_key'							=> 'required|max_length[32]|is_unique[' . $this->_table . '.api_key,user_id,' . $this->_primary . ']',
				'status'							=> 'boolean'
			)
		)
		->set_alias
		(
			array
			(
				'user_id'							=> phrase('user'),
				'api_key'							=> phrase('api_key'),
				'ip_range'							=> phrase('ip_range'),
				'valid_until'						=> phrase('valid_until'),
				'status'							=> phrase('status')
			)
		)
		->merge_content('{first_name} {last_name}', phrase('user'))
		->merge_field('valid_until, status')
		
		->render($this->_table);
	}
}
