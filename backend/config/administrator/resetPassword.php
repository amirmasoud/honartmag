
<?php
/**
 * Actors model config
 */
return array(
	'title' => 'Reset Password',
	'single' => 'Reset Password',
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
		'password' => array(
			'type' => 'password',
			'title' => 'Password',
			'limit' => 255
		),

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