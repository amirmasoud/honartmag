<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the iamges for the category
     *
     * @return  hasMany
     */
    public function images()
    {
        return $this->hasMany('App\Image');
    }
}
