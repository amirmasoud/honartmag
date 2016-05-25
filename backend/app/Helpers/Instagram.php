<?php

namespace app\Helpers;

use App\Helpers\Contracts\InstagramContract;

class Instagram implements InstagramContract
{
    use InstagramLogic;

    /**
     * Store images of a instagram profile for the first time.
     */
    public function store()
    {

    }

    /**
     * Update images of a created Instagram profile.
     */
    public function update()
    {

    }
}
