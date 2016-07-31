<?php

namespace App\Console\Commands;

use App\Helpers\Instagram;
use Illuminate\Console\Command;

class StoreImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:store {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store all images of an instagram by name';

    /**
     * Instagram image saver
     * 
     * @var App\Helpers\Instagram
     */
    protected $instagram;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Instagram $instagram)
    {
        parent::__construct();

        $this->instagram = $instagram;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $media = $this->instagram->media($this->argument('name'));
        $this->comment($this->instagram->store( $media, $this->argument('name') ));
    }
}