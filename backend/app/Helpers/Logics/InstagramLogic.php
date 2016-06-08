<?php

namespace app\Helpers\Logics;

use Storage;
use App\Image;
use App\Category;
use Carbon\Carbon;
use App\InstagramProfile;

trait InstagramLogic {
    
    /**
     * Generate recent media by a user url.
     * 
     * @param  integer  $userId user id of target user or empty fot current user media
     * @return string
     */
    public function userRecentMediaURL($profileId = 'self', $id = '', $update = true)
    {
        $recentMedia = '/media/';
        if ($update == true) {
            $recentMedia .= '?min_id=';
            return config('instagram.url') . $profileId . $recentMedia . $id;
        } else {
            $recentMedia .= '?max_id=';
            return config('instagram.url') . $profileId . $recentMedia . $id;
        }

    }

    /**
     * If there is no image for this profile id return not found.
     * 
     * @param  integer $profileId
     * @return boolean
     */
    public function virginProfile($profileId) 
    {
        if (! InstagramProfile::where('name', $profileId)->first()->count() ) {
            return true;
        } else {
        	return false;
        }
    }

    /**
     * Get last fetched image by profile id.
     *
     * @param  integer $profileId
     * @return collection
     */
    public function lastFetchedImageId($profileId) 
    {
		return Image::where('profile_id', '=', InstagramProfile::where('name', $profileId)->first()->profile_id)
                    ->orderBy('created_time', 'desc')
                    ->first()->image_id;
    }

    /**
     * If profile id is empty
     * 
     * @param  collection $last_image
     * @return array
     */
    public function emptyProfile($last_image)
    {
        if (is_null($last_image)) {
            return true;
        } else {
            return false;
        }
    }

    public function image_name()
    {
        $image_name = round(microtime(true) * 1000);
        $image_standard_resolution = $image_name . '.jpg';
        $image_thumbnail = $image_name . 'thumbnail.jpg';
        return ['image_standard_resolution' => $image_standard_resolution,
                'image_thumbnail' => $image_thumbnail];
    }

    /**
     * Update process for inserting new images.
     * 
     * @param  integer $profileId
     * @param  string  $url
     * @param  integer $last_image_id
     * @return void
     */
    public function updateImages($profileId, $url, $last_image_id)
    {
        static $updating = true;

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
            /**
             * If last image id met break update proccess and 
             * set updating to false in order to jump next
             * page proccessing.
             */
            if ($last_image_id == $resData['id']) {
                $updating = false;
                break;
            }

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
            
            $image['updated_at']            = $now;
            $image['created_at']            = $now;
            $image['profile_id']            = $profielIdddd;
            $image['image_id']              = $resData['id'];
            $image_id                       = $resData['id'];
            $image['link']                  = $resData['link'];
            $image['caption_text']          = $resData['caption']['text'];
            $image['category_id'] = $category;

            // store thumbnail on cloud
            Storage::put($image_thumbnail, 
                        file_get_contents($resData['images']['low_resolution']['url']));
            $image['thumb']                 = $image_thumbnail;

            // store standard image on cloud
            Storage::put($image_standard_resolution, 
                        file_get_contents($resData['images']['standard_resolution']['url']));
            $image['full'] = $image_standard_resolution;
            
            $image['created_time']          = Carbon::createFromTimestamp($resData['caption']['created_time']);

            // add current image to buck insertion array
            $data[] = $image;
        }

        $result = Image::insert($data);

        /**
         * Recursively run same function until reaching the point that
         * there is no other next_url in pagination array or updating
         * is finished and updatin state sat to false.
         */
        echo $this->userRecentMediaURL($profileId, $image_id, false) . PHP_EOL;
        if ($response['more_available'] == 'true' && $updating)
            $this->updateImages($profileId, $this->userRecentMediaURL($profileId, $image_id, false), $last_image_id);
    }
}