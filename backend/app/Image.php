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

    /**
     * Scope a query to get next image id.
     *
     * @param  collection $query
     * @param  datetime $createdTime
     * @param  string  $state image state, show|hide|new, default show
     * @return \Illuminate\Database\Eloquent\Builder
     */
	public function scopeNextId($query, $createdTime, $state)
	{
		return $query->whereRaw("created_time > STR_TO_DATE('" . $createdTime . "', '%Y-%m-%d %H:%i:%s')")
					 ->WhereStateOrderByCreatedTime($state, 'asc')
					 ->first(['id']);
	}

    /**
     * Scope a query to get prev image id.
     *
     * @param  collection $query
     * @param  datetime $createdTime
     * @param  string  $state image state, show|hide|new, default show
     * @return \Illuminate\Database\Eloquent\Builder
     */
	public function scopePrevId($query, $createdTime, $state)
	{
		return $query->whereRaw("created_time < STR_TO_DATE('" . $createdTime . "', '%Y-%m-%d %H:%i:%s')")
					 ->WhereStateOrderByCreatedTime($state)
					 ->first(['id']);
	}

    /**
     * Scope a query to get by state and order.
     * 
     * @param  collection $query
     * @param  string  $state image state, show|hide|new, default show
     * @param  string $order
     * @return \Illuminate\Database\Eloquent\Builder
     */
	public function scopeWhereStateOrderByCreatedTime($query, $state, $order = 'desc')
	{
		return $query->where('state', '=', $state)
					 ->orderBy('created_time', $order)
					 ->orderBy('created_at', $order);
	}

	public function getFullAttribute($value)
	{
		return asset('app/' . $value);
	}

	public function getThumbAttribute($value)
	{
		return asset('app/' . $value);
	}
}
