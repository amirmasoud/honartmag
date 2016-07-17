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
	public function all($name);

    /**
     * Get single image based on category.
     *
     * @param  string $name
     * @param  integer $id
     * @return json
     */
	public function singular($name, $id);
}