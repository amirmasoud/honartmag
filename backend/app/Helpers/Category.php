<?php

namespace app\Helpers;

use App\Category as CategoryModel;
use App\Helpers\Contracts\CategoryContract;

class Category implements CategoryContract
{
    /**
     * Get all images based on the category name.
     * 
     * @param  string $name
     * @return 
     */
    public function singular($name)
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
}