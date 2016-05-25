<?php

namespace app\Helpers;

use App\Helpers\Contracts\ImageContract;

class Image implements ImageContract
{
    /**
     * Get all images.
     *
     * @param  string  $state image state, show|hide|new, default show
     * @return JSON
     */
    public function all($state = 'show')
    {

    }

    /**
     * Get an image based on the imges's id.
     * 
     * @param  integer  $id image id
     * @param  string  $state image state, show|hide|new, default show
     * @return JSON
     */
    public function singular($id, $state = 'show')
    {

    }
}