<?php

use App\Image;
use App\InstagramProfile;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InstagramLogicTest extends TestCase
{
    /**
     * Mock object for InstagramLogic trait
     * @var obj
     */
    protected $mock;

    /**
     * without this constructor it will make following error
     * Fatal error: Call to a member function make() on null
     * solution: https://laracasts.com/discuss/channels/general-discussion/call-to-a-member-function-make-on-null
     */
    public function __construct()
    {
        // Overriding the constructor so need to reinstantiate
        parent::createApplication();
    }

    protected function setUp()
    {
        $this->mock = $this->getMockForTrait('App\Helpers\Logics\InstagramLogic');

        // rollback instagram profile with id of 1 and its images
        InstagramProfile::where('profile_id', '=', 1)->delete();
    }

    /**
     * test instagram profile url.
     *
     * @return void
     */
    public function testUserRecentMediaURL()
    {
        $response = $this->mock->userRecentMediaURL();

        $this->assertRegExp('/^(https:\/\/api.instagram.com\/v1\/users\/){1}(self|[0-9]*){1}(\/media\/recent\/\?access_token=){1}([0-9]+)(\.)([a-z0-9]+)(\.)([a-z0-9]+)$/', $response);
    }

    /**
     * test virgin profiles.
     * 
     * @return void
     */
    public function testVirginProfile()
    {
        // create instagram profile
        factory(InstagramProfile::class)->create();

        $this->assertTrue($this->mock->virginProfile(1));

        // seed 10 sample images
        factory(Image::class, 10)->create();

        $this->assertFalse($this->mock->virginProfile(1));

        // rollback instagram profile and images
        InstagramProfile::where('profile_id', '=', 1)->delete();
    }

    /**
     * Test empty profile.
     * 
     * @return void
     */
    public function testEmptyProfile()
    {
        // create instagram profile
        factory(InstagramProfile::class)->create();

        // empty profile id from any images
        $this->assertTrue($this->mock->emptyProfile($this->mock->lastFetchedImageId(1)));

        // seed 10 sample images
        factory(Image::class, 10)->create();

        // profile id containt 10 images
        $this->assertFalse($this->mock->emptyProfile($this->mock->lastFetchedImageId(1)));
    }

    public function testUpdateImages()
    {
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}
