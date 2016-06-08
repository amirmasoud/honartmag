<?php

namespace app\Helpers;

use Storage;
use App\Image;
use App\Category;
use Carbon\Carbon;
use App\InstagramProfile;
use App\Helpers\Logics\InstagramLogic;
use App\Helpers\Contracts\InstagramContract;

class Instagram implements InstagramContract
{
    use InstagramLogic;

    /**
     * Store images of a instagram profile for the first time.
     * 
     * @param  string  $url recent instagram url
     * @param  integer  $profileId instagram profile id of the owner
     * @return  string   command line message
     */
    public function storeComplete($url, $profileId)
    {
        // Get associative arrays.
        $response = json_decode(file_get_contents($url), true);

        /**
         * Each response contains 20 new images
         * every new images first save in this
         * array and then will insert to DB.
         * 
         * @var array
         */
        $data = [];

        $image_id = '';

        $profielIdddd = InstagramProfile::where('name', $profileId)->first()->profile_id;
        $category = Category::first()->id;

        foreach ($response['items'] as $resData) {
            // Current image
            $image = [];

            // Create unique image name
            $image_name = round(microtime(true) * 1000);
            $image_standard_resolution = $image_name . '.jpg';
            $image_thumbnail = $image_name . 'thumbnail.jpg';

            /**
             * To initialize created_at and updated_at in bulk
             * insertion created_at and updated_at 
             * not working out of the box.
             * 
             * @var DateTime
             */
            $now = Carbon::now();
            
            $image['updated_at']   = $now;
            $image['created_at']   = $now;
            $image['profile_id']   = $profielIdddd;
            $image['image_id']     = $resData['id'];
            $image_id              = $resData['id'];
            $image['link']         = $resData['link'];
            $image['caption_text'] = $resData['caption']['text'];
            // store thumbnail on cloud
            Storage::put($image_thumbnail, file_get_contents($resData['images']['low_resolution']['url']));
            $image['thumb']        = $image_thumbnail;

            // store standard image on cloud
            Storage::put($image_standard_resolution, file_get_contents($resData['images']['standard_resolution']['url']));
            $image['full'] = $image_standard_resolution;
            
            $image['created_time'] = Carbon::createFromTimestamp($resData['caption']['created_time']);

            $image['category_id'] = $category;

            // add current image to buck insertion array
            $data[] = $image;
        }

        Image::insert($data);

        /**
         * Recursively run same function until reaching the point that
         * there is no other next_url in pagination array.
         */
        if ($response['more_available'] == 'true')
            $this->store($this->userRecentMediaURL($profileId, $image_id), $profileId);

        // Count of inserted images.
        $imagesCount = Image::where('profile_id', '=', $profielIdddd)->count('image_id');

        return PHP_EOL . $imagesCount . ' image(s) inserted for ' . $profileId . PHP_EOL;
    }




    /**
     * Store images of a instagram profile for the first time.
     * 
     * @param  string  $url recent instagram url
     * @param  integer  $profileId instagram profile id of the owner
     * @return  string   command line message
     */
    public function store($url, $profileId)
    {
        // Get associative arrays.
        $response = json_decode(file_get_contents($url), true);

        if ($response['more_available'] == 'true')
        {
            $image_id = end($response['items'])['id'];
            $this->store($this->userRecentMediaURL($profileId, $image_id), $profileId);
        } else {
            $image = [];
            $resData = end($response['items']);

            $profielIdddd = InstagramProfile::where('name', $profileId)->first()->profile_id;
            $category = Category::first()->id;
            $now = Carbon::now();
            // Create unique image name
            $image_name = round(microtime(true) * 1000);
            $image_standard_resolution = $image_name . '.jpg';
            $image_thumbnail = $image_name . 'thumbnail.jpg';

            $image['updated_at']   = $now;
            $image['created_at']   = $now;
            $image['profile_id']   = $profielIdddd;
            $image['image_id']     = $resData['id'];
            $image['link']         = $resData['link'];
            $image['caption_text'] = $resData['caption']['text'];
            $image['thumb']        = $image_thumbnail;
            $image['full']         = $image_standard_resolution;
            $image['created_time'] = Carbon::createFromTimestamp($resData['caption']['created_time']);

            $image['category_id'] = $category;

            Image::insert($image);

            $this->update($this->userRecentMediaURL($profileId, $image['image_id']), $profileId);
        }
    }




    /**
     * Update images of a created Instagram profile.
     * 
     * @param  string  $url recent Instagram url
     * @param  integer  $profileId instagram profile id of the owner
     * @return string  command line message
     */
    public function update($url, $profileId)
    {
        // If profile id is virgin return not found message
        if ($this->virginProfile($profileId)) {
            return [$profileId, 'Not Found', 'Not Found'];
        }

        // Otherwise get the last image id
        $last_image = $this->lastFetchedImageId($profileId);

        // If profile is empty
        if ($this->emptyProfile($last_image)) {
            return [$profileId, 'Empty Profile', 'Empty Profile'];
        }

        // If last image was not empty get the last image id
        $last_image_id = $last_image->image_id;

        // Count of current images for given profile id before update.
        $imagesCountBeforeUpadate = Image::where('profile_id', '=', $profileId)->count('image_id');

        // Recursive function
        $this->updateImages($profileId, $url, $last_image_id);

        // Count of current images for given profile id after updating.
        $imagesCountAfterUpdate = Image::where('profile_id', '=', $profileId)->count('image_id');

        // number of inserted images after update.
        $imagesCount = $imagesCountAfterUpdate - $imagesCountBeforeUpadate;

        // Profile name
        $profileName = InstagramProfile::whereProfileId($profileId)->firstOrFail()->name;

        return [$profileId, $imagesCount, $profileName];
    }
}
