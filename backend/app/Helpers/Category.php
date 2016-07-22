<?php

namespace app\Helpers;

use App\Image as ImageModel;
use App\Category as CategoryModel;
use App\Helpers\Contracts\CategoryContract;

class Category implements CategoryContract
{
    /**
     * Get all images based on the category name.
     * 
     * @param  string $name
     * @return json
     */
    public function all($name)
    {
        // Get all images with category.name
        $images =  CategoryModel::where('name', $name)
                            ->firstOrFail()
                            ->images()
                            ->select(['id', 'thumb'])
                            ->simplePaginate(config('honart.paginate'));

        // add category.name to each image
        foreach ($images as $image) {
            $image['category'] = ['name' => $name];
        }

        return $images;
    }

    /**
     * Get single image based on category.
     * 
     * @param  string $name
     * @param  integer $id
     * @return json
     */
    public function singular($name, $id)
    {
        // Get all images with category.name
        $image =  CategoryModel::where('name', $name)
                            ->firstOrFail()
                            ->images()
                            ->select(['id', 'full', 'caption_text', 'link', 'created_time'])
                            ->where('id', $id)
                            ->firstOrFail();

        $nextId = ImageModel::NextId($image->id, $name);
        $prevId = ImageModel::prevId($image->id, $name);
        $image->next = empty( $nextId->id ) ? 0 : $nextId->id;
        $image->prev = empty( $prevId->id ) ? 0 : $prevId->id;

        return $image;
    }
}