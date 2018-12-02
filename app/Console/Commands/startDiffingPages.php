<?php
/**
 *
 * PHP version >= 7.2
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use App\Jobs\DiffPages;

use Exception;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;


/**
 * Class startDiffingPages
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class startDiffingPages extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "start:diffingpages";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Starts off all jobs needed to diff these pages";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $urls = [
            'https://2ndraiders.com/diff2.html'
        ];
        # Let's get an original copy of each page
        $client = new Client();

        foreach($urls as $url) {
            $response = $client->request('GET', $url);
            $body = $response->getBody()->getContents();
            Cache::put($url,$body,'60');
            dispatch(new DiffPages($url));
        }
    }
}