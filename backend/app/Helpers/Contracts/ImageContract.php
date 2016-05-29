<?php

namespace App\Helpers\Contracts;

Interface ImageContract
{
	/**
	 * Get all images with pagination.
	 * Show = all images that have been approved
	 * Hide = all images that have not been approved
	 * New  = all images that fectched recently
	 *
	 * @param  string  $state image state, show|hide|new, default show
	 * @return JSON
	 */
	public function all($state = 'show');

	/**
	 * Get single image.
	 * 
	 * @param  integer  $id image id
	 * @param  string  $state image state, show|hide|new, default show
	 * @return JSON
	 */
	public function singular($id, $state = 'show');
}