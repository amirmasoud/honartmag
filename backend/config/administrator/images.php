<?php

return array(
	'title'  => 'Images',
	'single' => 'Image',
	'model'  => App\Image::class,

	/**
	 * The display columns
	 */
	'columns' => array(
		'full' => array(
			'title' 	=> 'Standard Resolution',
			'output' 	=> function($thumbnail) {
				if ($thumbnail != '')
					return '<img src="' . $thumbnail . '" alt="no thumbnail" />';
				},
			'sortable' => false,
		),
		'caption_text' => array(
			'title' => 'Caption Text',
		),
		'state' => array(
			'title' => 'State'
		),
		'owner' => array(
			'title' 		=> 'Owner',
			'relationship' 	=> 'instagramProfile',
			'select' 		=> "(:table).name",
		),
		'created_time' => array(
			'title' 		=> 'Created time',
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'id',
		'caption_text' => array(
		    'title' => 'Caption Text',
		    'type' 	=> 'wysiwyg',
		),
		'state' => array(
		    'type' => 'enum',
		    'title' => 'State',
		    'options' => array(
		        'new' 	=> 'New',
		        'hide' 	=> 'Hide',
		        'show' 	=> 'Show',
		    ),
		),
		'link' => array(
			'title' => 'Link',
			'type' 	=> 'text',
			'limit' => 255,
		),
	),

	/**
	 * The filterable fields
	 *
	 * @type array
	 */
	'filters' => array(
	    'caption_text' => array(
	        'title' => 'Caption Text',
	    ),
	    'state' => array(
	        'title' => 'State',
	        'type' 	=> 'enum',
		    'options' => array(
		        'new' 	=> 'New',
		        'hide' 	=> 'Hide',
		        'show' 	=> 'Show',
		    ),
	    ),
	    'created_time' => array(
	        'title' 	 => 'Created Time',
	        'type' 		 => 'datetime',
	    ),
	),
	'form_width' => 600
);
