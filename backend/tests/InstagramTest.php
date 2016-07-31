<?php

use App\Image;
use App\InstagramProfile;
use App\Helpers\Instagram;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InstagramTest extends TestCase
{
    /**
     * Instagram instance.
     * 
     * @access private
     * @var obj
     */
    private $instagram;

    /**
     * setUp method.
     *
     * @since 1.0.0
     * @link  https://phpunit.de/manual/current/en/fixtures.html
     */
    protected function setUp()
    {
    	/**
    	 * Overriding the constructor so need to reinstantiate.
    	 *
	     * without this constructor it will make following error
	     * Fatal error: Call to a member function make() on null
	     * solution: https://laracasts.com/discuss/channels/general-discussion/call-to-a-member-function-make-on-null
    	 */
    	parent::createApplication();

    	$this->instagram = new Instagram();

        // Remove test instagram profile.
        InstagramProfile::where('name', '=', 'test')->delete();
    }

    /**
     * test media method.
     *
     * @return  void
     */
    public function testMedia()
    {
        // Self URL
        $this->assertRegExp('/^(https:\/\/www.instagram.com\/(self|([A-Za-z0-9._]){1,30})\/media\/\?(max_id|min_id)=((\d){19}_(\d){10})?)$/', $this->instagram->media());

        // Username URL
        $this->assertRegExp('/^(https:\/\/www.instagram.com\/(self|([A-Za-z0-9._]){1,30})\/media\/\?(max_id|min_id)=((\d){19}_(\d){10})?)$/', $this->instagram->media('test'));

        // ID URL
        $this->assertRegExp('/^(https:\/\/www.instagram.com\/(self|([A-Za-z0-9._]){1,30})\/media\/\?(max_id|min_id)=((\d){19}_(\d){10})?)$/', $this->instagram->media('test', '1111111111111111111_1111111111'));

        // Updating true URL
        $this->assertRegExp('/^(https:\/\/www.instagram.com\/(self|([A-Za-z0-9._]){1,30})\/media\/\?(min_id)=((\d){19}_(\d){10})?)$/', $this->instagram->media('test', '1111111111111111111_1111111111', true));

        // Updating false URL
        $this->assertRegExp('/^(https:\/\/www.instagram.com\/(self|([A-Za-z0-9._]){1,30})\/media\/\?(max_id)=((\d){19}_(\d){10})?)$/', $this->instagram->media('test', '1111111111111111111_1111111111', false));
    }

    /**
     * Test exists method.
     * 
     * @return 	void
     */
    public function testExists()
    {
        // Create instagram profile.
        factory(InstagramProfile::class)->create();

        $this->assertTrue($this->instagram->exists('test'));

        // Rollback instagram profile and images.
        InstagramProfile::where('name', '=', 'test')->delete();

        $this->assertFalse($this->instagram->exists('test'));
    }

    /**
     * Test lastImageID method.
     * 
     * @return void
     */
    public function testLastImageID()
    {
        // Create instagram profile.
        factory(InstagramProfile::class)->create();

        // Create sample image
        // Mock images:insert command
        factory(Image::class)->create();

        $this->assertRegExp('/^((\d){19}_(\d){10})$/', $this->instagram->lastImageID('test'));

        InstagramProfile::where('name', '=', 'test')->delete();
    }
}
