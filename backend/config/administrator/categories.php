<?php

/**
 * Actors model config
 */
return array(
	'title'  => 'Categories',
	'single' => 'Category',
	'model'  => App\Category::class,

	/**
	 * The display columns
	 */
	'columns' => array(
		'name' => array(
			'title' => 'Name',
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
		)
	),

	/**
	 * The filterable fields
	 *
	 * @type array
	 */
	'filters' => array(
	    'name' => array(
	        'title' => 'Name',
	    )
	),
);
