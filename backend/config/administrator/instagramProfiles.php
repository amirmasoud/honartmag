<?php

/**
 * Actors model config
 */
return array(
	'title'  => 'Instagram Profiles',
	'single' => 'Instagram Profile',
	'model'  => App\InstagramProfile::class,

	/**
	 * The display columns
	 */
	'columns' => array(
		'name' => array(
			'title' => 'Name',
		),
		'profile_id' => array(
			'title' => 'Profile ID',
		),
		'created_at' => array(
			'title' 		=> 'Created at',
		),
		'updated_at' => array(
			'title' 		=> 'Updated at',
		)
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'id',
		'name' => array(
			'title' => 'Name',
			'type' 	=> 'text',
			'limit' => 255,
		),
		'profile_id' => array(
			'title' => 'Profile ID',
			'type' 	=> 'text',
			'limit' => 255,
		),
	),


	'actions' => array(
	    'fetch_data' => array(
	        'title' => 'Fetch Data',
	        'messages' => array(
	            'active' => 'Fetching images...',
	            'success' => 'All images fetched.',
	            'error' => 'Error, check laravel.log in storage directory for more details and be sure not running this action twice or more.',
	        ),
	        'action' => function(&$model)
	        {
	            Event::fire(new \App\Events\InstagramProfileCreated($model));

	            return true;
	        }
	    ),
	),

	/**
	 * The filterable fields
	 *
	 * @type array
	 */
/*	'filters' => array(
	    'title' => array(
	        'title' => 'Name',
	    ),
	    'subtitle' => array(
	        'title' => 'Subtitle',
	        'type' 	=> 'text',
	    ),
	    'user' => array(
	        'title' 	 => 'Author',
	        'type' 		 => 'relationship',
	        'name_field' => 'name',
	    ),
	    'body' => array(
	        'title' => 'Body',
	        'type' 	=> 'text',
	    ),
	    'created_at' => array(
	    	'title' => 'Created at',
	    	'type'	=> 'date',
	    ),
	    'updated_at' => array(
	    	'title' => 'Updated at',
	    	'type'	=> 'date',
	    )
	),*/

	'form_width' => 600
);
