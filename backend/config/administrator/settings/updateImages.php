<?php
/**
 * The main site settings page
 */
return array(
	/**
	 * Settings page title
	 *
	 * @type string
	 */
	'title' => 'Update Images',
	/**
	 * The edit fields array
	 *
	 * @type array
	 */
	'edit_fields' => array(
	    'do_nothing' => array(
	        'title' => 'Do nothing',
	        'type' => 'text',
	    ),
	),

	'actions' => array(
	    'update_images' => array(
	        'title' => 'Update Images',
	        'messages' => array(
	            'active' => 'Updating images...',
	            'success' => 'All profiles updated.',
	            'error' => 'Error, check laravel.log in storage directory for more details.',
	        ),
	        'action' => function(&$model)
	        {
	            \Artisan::call('images:update');

	            return true;
	        }
	    ),
	),
);