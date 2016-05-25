<?php

namespace App;

use Storage;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	/**
	 * variable that can be mass assigned.
     * 
	 * @var array
	 */
	protected $fillable = [
		'link',
        'thumb',
		'full',
		'caption_text',
		'profile_id',
		'image_id',
		'created_time',
		'state',
	];

	/**
	 * An image is owned by a instagram profile.
	 * 
	 * @return belongTo
	 */
	public function instagramProfile()
	{
		return $this->belongsTo('App\InstagramProfile', 'profile_id', 'profile_id');
	}
}
