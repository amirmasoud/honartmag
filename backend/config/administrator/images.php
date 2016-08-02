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
		'created_time' => array(
			'title' 		=> 'Created time',
		),
		'id' =>  array(
			'title' => 'ID'
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'id',
		'caption_text' => array(
		    'title' => 'Caption Text',
		    'type' 	=> 'textarea',
		),
		'title' => array(
			'title' => 'Title',
			'type' 	=> 'text',
			'limit' => 255,
		),
		'alt' => array(
			'title' => 'Alt',
			'type' 	=> 'textarea',
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
		'category' => array(
		    'type' => 'relationship',
		    'title' => 'Category',
		    'name_field' => 'name',
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
