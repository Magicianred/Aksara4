<?php namespace Aksara\Modules\Home\Controllers;
/**
 * Home
 * The default landing page of default routes
 *
 * @author			Aby Dahana
 * @profile			abydahana.github.io
 * @website			www.aksaracms.com
 * @since			version 4.0.0
 * @copyright		(c) 2021 - Aksara Laboratory
 */
class Home extends \Aksara\Laboratory\Core
{
	public function index($partial_error = null)
	{
		$this->set_title(phrase('welcome_to') . ' ' . get_setting('app_name'))
		->set_description(get_setting('app_description'))
		
		->set_output
		(
			array
			(
				'error'								=> ($partial_error ? true : false),
				'writable'							=> array
				(
					'uploads'						=> (is_dir(FCPATH . UPLOAD_PATH) && is_writable(FCPATH . UPLOAD_PATH) ? true : false),
					'logs'							=> (is_dir(WRITEPATH . 'logs') && is_writable(WRITEPATH . 'logs') ? true : false),
					'translations'					=> (is_dir(WRITEPATH . 'translations') && is_writable(WRITEPATH . 'translations') ? true : false)
				)
			)
		)
		
		->render();
	}
}
