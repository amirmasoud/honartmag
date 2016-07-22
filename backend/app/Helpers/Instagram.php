<?php
/**
 * This file is part of the HonarMag application.
 *
 * @author amirmasoud sheidayi <amirmasood33@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\Helpers;

use Artisan;
use Storage;
use App\Image;
use App\Category;
use Carbon\Carbon;
use App\InstagramProfile;
use App\Helpers\Contracts\InstagramContract;

class Instagram implements InstagramContract
{
    private $imageID;
    /**
     * Generate recent media url.
     *
     * @since  1.0.0
     * @param  string  $name namename of the account
     * @param  integer  $id
     * @param  boolean  $updating
     * @return string
     */
    public function media($name = 'self', $id = '', $updating = true)
    {
        if ($updating == true) {
            return config('instagram.url') . $name . '/media/?min_id=' . $id;
        } else {
            return config('instagram.url') . $name . '/media/?max_id=' . $id;
        }
    }

    /**
     * If there is no image for this profile name return not found.
     *
     * @since  1.0.0
     * @param  string  $name
     * @return boolean
     */
    public function exists($name) 
    {
        $profile = InstagramProfile::where('name', $name)->first();
        if (!is_null($profile)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get last fetched image by profile id.
     *
     * @param  string  $name
     * @return Artisan|string
     */
    public function lastImageID($name) 
    {
        $image = InstagramProfile::where('name', $name)
                                 ->first()
                                 ->images()
                                 ->orderBy('created_time', 'desc')
                                 ->first();

        // Wheter or not images:store command executed.
        if (empty($image)) {
            // Execute images:store for the first time.
            return Artisan::call('images:store', [
                    'name' => $name
                ]);
        } else {
            return $image->image_id;
        }
    }

    /**
     * Update process for inserting new images.
     *
     * @since  1.0.0
     * @param  string  $name
     * @param  string  $url
     * @param  integer  $lastImageID
     * @return void
     */
    public function updateImages($name, $url, $lastImageID)
    {
        static $updating = true;
        $response = $this->getContentsOf($url);
        $profileID = InstagramProfile::where('name', $name)
                                     ->first()
                                     ->profile_id;

        $data = $this->getData($response, $lastImageID, $profileID, $updating);

        $result = Image::insert($data);

        /**
         * Recursively run same function until reaching the point that
         * there is no other next_url in pagination array or updating
         * is finished and updatin state sat to false.
         */
        if ($response['more_available'] == 'true' && $updating) {
            $next = $this->media($name, $this->imageID, false);
            $this->updateImages($name, $next, $lastImageID);
        }
    }

    /**
     * Store images of a instagram profile for the first time.
     * 
     * @param  string  $url recent instagram url
     * @param  integer  $name instagram profile id of the owner
     * @return  string   command line message
     */
    public function store($url, $name)
    {
        // Get associative arrays.
        $response = json_decode(file_get_contents($url), true);

        if ($response['more_available'] == 'true') {
            $imageID = end($response['items'])['id'];
            $this->store($this->media($name, $imageID, false), $name);
        } else {
            $resData = end($response['items']);
            $profileID = InstagramProfile::where('name', $name)
                                         ->first()
                                         ->profile_id;
            $category = Category::first()->id;

            $now = Carbon::now();

            // Create unique image name
            $imageName               = round(microtime(true) * 1000);
            $imageStandardResolution = $imageName . '.jpg';
            $imageThumbnail          = $imageName . 'thumbnail.jpg';

            $image['updated_at']   = $now;
            $image['created_at']   = $now;
            $image['profile_id']   = $profileID;
            $image['image_id']     = $resData['id'];
            $image['link']         = $resData['link'];
            $image['caption_text'] = $resData['caption']['text'];

            // store thumbnail on cloud
            $thumbURL = $resData['images']['low_resolution']['url'];
            $thumbURL = file_get_contents($thumbURL);
            Storage::put($imageThumbnail, $thumbURL);
            $image['thumb']         = $imageThumbnail;

            // store standard image on cloud
            $fullURL = $resData['images']['standard_resolution']['url'];
            $fullURL = file_get_contents($fullURL);
            Storage::put($imageStandardResolution, $fullURL);
            $image['full']          = $imageStandardResolution;
            
            $created_time = $resData['caption']['created_time'];
            $created_time = Carbon::createFromTimestamp($created_time);
            $image['created_time']  = $created_time;            

            $image['category_id']   = $category;

            Image::insert($image);

            $this->update($this->media($name, $image['image_id']), $name);
        }
    }

    /**
     * Update images of a created Instagram profile.
     * 
     * @param  string  $url recent Instagram url
     * @param  integer  $profileId instagram profile id of the owner
     * @return string  command line message
     */
    public function update($url, $name)
    {
        // If profile id is virgin return not found message
        if (!$this->exists($name)) {
            return [$name, 'Not Found', 'Not Found'];
        }

        // Otherwise get the last image id
        $lastImageID = $this->lastImageID($name);

        // Count of current images for given profile id before update.
        
        $imagesCountBeforeUpadate = InstagramProfile::where('name', $name)
                                                    ->first()
                                                    ->images()
                                                    ->count();

        // Recursive function
        $this->updateImages($name, $url, $lastImageID);

        // Count of current images for given profile id after updating.
        $imagesCountAfterUpdate = InstagramProfile::where('name', $name)
                                                    ->first()
                                                    ->images()
                                                    ->count();

        // number of inserted images after update.
        $imagesCount = $imagesCountAfterUpdate - $imagesCountBeforeUpadate;

        return [$name, $imagesCount, $name];
    }

    /**
     * Get and decode url contents.
     *
     * @since  1.0.0
     * @param  string  $url
     * @return JSON
     */
    private function getContentsOf($url)
    {
        return json_decode(file_get_contents($url), true);
    }

    /**
     * Iterate json data.
     * 
     * @todo combine store method
     * @since  1.0.0
     * @param  array  $response
     */
    private function getData($response, $lastImageID, $profileID, $updating) 
    {
        $category = Category::first()->id;
        $data = [];
        foreach ($response['items'] as $resData) {
            /**
             * If last image id met break update proccess and 
             * set updating to false in order to jump next
             * page proccessing.
             */
            if ($lastImageID == $resData['id']) {
                $updating = false;
                break;
            }

            // Create unique image name
            $imageName               = round(microtime(true) * 1000);
            $imageStandardResolution = $imageName . '.jpg';
            $imageThumbnail          = $imageName . 'thumbnail.jpg';

            /**
             * To initialize created_at and updated_at in bulk
             * insertion created_at and updated_at 
             * not working out of the box.
             * 
             * @var DateTime
             */
            $now = Carbon::now();
            
            $image['updated_at']    = $now;
            $image['created_at']    = $now;
            $image['profile_id']    = $profileID;
            $image['image_id']      = $resData['id'];
            $this->imageID          = $resData['id'];
            $image['link']          = $resData['link'];
            $image['caption_text']  = $resData['caption']['text'];
            $image['category_id']   = $category;

            // store thumbnail on cloud
            $thumbURL = $resData['images']['low_resolution']['url'];
            $thumbURL = file_get_contents($thumbURL);
            Storage::put($imageThumbnail, $thumbURL);
            $image['thumb']         = $imageThumbnail;

            // store standard image on cloud
            $fullURL = $resData['images']['standard_resolution']['url'];
            $fullURL = file_get_contents($fullURL);
            Storage::put($imageStandardResolution, $fullURL);
            $image['full']          = $imageStandardResolution;
            
            $created_time = $resData['caption']['created_time'];
            $created_time = Carbon::createFromTimestamp($created_time);
            $image['created_time']  = $created_time;

            // add current image to buck insertion array
            $data[] = $image;
        }
        return $data;
    }
}