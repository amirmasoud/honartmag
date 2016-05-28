
<?php
/**
 * Actors model config
 */
return array(
	'title' => 'All Users',
	'single' => 'User',
	'model' => App\User::class,

	/**
	 * The display columns
	 */
	'columns' => array(
		'name',
		'email',
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'name' => array(
			'type' => 'text',
			'title' => 'Name',
			'limit' => 255
		),
		'email' => array(
			'type' => 'text',
			'title' => 'Email',
			'limit' => 255
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
	    ),
	    'email' => array(
	        'title' => 'Email',
	    )
	),

	'form_width' => 600
);