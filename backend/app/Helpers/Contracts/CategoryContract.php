<?php

namespace App\Helpers\Contracts;

Interface CategoryContract
{
	/**
	 * Get all images based on the category name.
	 * 
	 * @param  string  $name
	 * @return JSON
	 */
	public function singular($name);
}