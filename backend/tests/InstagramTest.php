<?php

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
    }

    /**
     * test media method.
     *
     * @return void
     */
    public function testMedia()
    {
    	// Self URL
        $this->assertRegExp('/^(https:\/\/www.instagram.com\/(self|([A-Za-z0-9._]){1,30})\/media\/\?(max_id|min_id)=((\d){19}_(\d){10})?)$/', $this->instagram->media());

        // username URL
        $this->assertRegExp('/^(https:\/\/www.instagram.com\/(self|([A-Za-z0-9._]){1,30})\/media\/\?(max_id|min_id)=((\d){19}_(\d){10})?)$/', $this->instagram->media('amirmasoud.32'));

        // id URL
        $this->assertRegExp('/^(https:\/\/www.instagram.com\/(self|([A-Za-z0-9._]){1,30})\/media\/\?(max_id|min_id)=((\d){19}_(\d){10})?)$/', $this->instagram->media('amirmasoud.32', '1111111111111111111_1111111111'));

        // updating true URL
        $this->assertRegExp('/^(https:\/\/www.instagram.com\/(self|([A-Za-z0-9._]){1,30})\/media\/\?(min_id)=((\d){19}_(\d){10})?)$/', $this->instagram->media('amirmasoud.32', '1111111111111111111_1111111111', true));

        // updating false URL
        $this->assertRegExp('/^(https:\/\/www.instagram.com\/(self|([A-Za-z0-9._]){1,30})\/media\/\?(max_id)=((\d){19}_(\d){10})?)$/', $this->instagram->media('amirmasoud.32', '1111111111111111111_1111111111', false));
        
    }
}
