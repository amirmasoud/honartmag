<?php

namespace app\Helpers;

use App\Image as ImageModel;
use App\Helpers\Contracts\ImageContract;

class Image implements ImageContract
{
    /**
     * Get all images
     *
     * @param  string  $state image state, show|hide|new, default show
     * @return JSON
     */
    public function all($state = 'show')
    {
        $images = ImageModel::select('id', 'thumb')
                            ->where('state', 'show')
                            ->orderBy('id', 'desc')
                            ->simplePaginate(24);

        foreach ($images as $image) {
            $image['category'] = ImageModel::find($image->id)->category()->first(['name']);
        }

        return $images;
    }

    /**
     * Get an image based on id.
     * 
     * @param  integer  $id image id
     * @param  string  $state image state, show|hide|new, default show
     * @return JSON
     */
    public function singular($id, $state = 'show')
    {
        $image = ImageModel::select('id', 'full', 'caption_text', 'created_time')
                            ->where('id', '=', $id)
                            ->where('state', $state)
                            ->firstOrFail();

        $nextId = ImageModel::NextId($image->id);
        $prevId = ImageModel::prevId($image->id);
        $image->next = empty( $nextId->id ) ? 0 : $nextId->id;
        $image->prev = empty( $prevId->id ) ? 0 : $prevId->id;
        return $image;
    }
}