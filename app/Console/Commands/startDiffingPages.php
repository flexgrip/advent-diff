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
            'https://www.fanatec.com/us-en/bundle/product/forza-motorsport-wheel-bundle-for-xbox-one-and-pc.html',
            'https://www.fanatec.com/us-en/bundle/product/xbox-one-competition-pack.html',
            'https://www.fanatec.com/us-en/bundle/product/csl-elite-wheel-advanced-pack-for-xbox-one-and-pc.html',
            'https://www.fanatec.com/us-en/bundle/product;bundle_id;250',
            'https://www.fanatec.com/us-en/bundle/product/csl-elite-ps4-starter-kit-for-pc-and-ps4.html',
            'https://www.fanatec.com/us-en/bundle/product/csl-elite-wheel-starter-pack-for-xbox-one-and-pc.html',
            'https://www.fanatec.com/us-en/racing-wheels/clubsport-racing-wheel-forza-motorsport-for-xbox-one-and-pc.html',
            'https://www.fanatec.com/us-en/racing-wheels/clubsport-racing-wheel-bmw-for-pc.html',
            'https://www.fanatec.com/us-en/racing-wheels/csl-elite-f1-set-officially-licensed-for-ps4-usa.html',
            'https://www.fanatec.com/us-en/racing-wheels/csl-elite-racing-wheel-formula-black-usa.html',
            'https://www.fanatec.com/us-en/racing-wheels/csl-elite-racing-wheel-ps4.html',
            'https://www.fanatec.com/us-en/racing-wheels/csl-elite-racing-wheel-p1-for-xbox-one-usa.html',
            'https://www.fanatec.com/us-en/shifters/clubsport-shifter-sq-us.html',
            'https://www.fanatec.com/us-en/wheel-base-accessories/clubsport-static-shifter-paddles-us.html',
            'https://www.fanatec.com/us-en/wheel-bases/podium-wheel-base-dd2-usa.html',
            'https://www.fanatec.com/us-en/wheel-bases/podium-wheel-base-dd1-usa.html',
            'https://www.fanatec.com/us-en/wheel-bases/clubsport-wheel-base-v2-5.html',
            'https://www.fanatec.com/us-en/wheel-bases/csl-elite-wheel-base-officially-licensed-for-ps4-usa.html',
            'https://www.fanatec.com/us-en/wheel-bases/csl-elite-wheel-base-usa.html',
            'https://www.fanatec.com/us-en/pedals/clubsport-pedals-v3-inverted-usa.html',
            'https://www.fanatec.com/us-en/pedals/clubsport-pedals-v3-usa.html',
            'https://www.fanatec.com/us-en/pedals/csl-elite-pedals-lc-usa.html',
            'https://www.fanatec.com/us-en/pedals/csl-elite-pedals-usa.html',
            'https://www.fanatec.com/us-en/racing-cockpits-simulators/rennsport-cockpit-v2-us.html',
            'https://www.fanatec.com/us-en/steering-wheels/clubsport-steering-wheel-porsche-918-rsr-us.html',
            'https://www.fanatec.com/us-en/steering-wheels/clubsport-steering-wheel-oval-xbox-one-usa.html',
            'https://www.fanatec.com/us-en/steering-wheels/clubsport-steering-wheel-round-1-xbox-one-usa.html',
            'https://www.fanatec.com/us-en/steering-wheels/clubsport-steering-wheel-gt-forza-motorsport-usa.html',
            'https://www.fanatec.com/us-en/steering-wheels/clubsport-steering-wheel-drift-xbox-one-usa.html',
            'https://www.fanatec.com/us-en/steering-wheels/clubsport-steering-wheel-flat-1-xbox-one-usa.html',
            'https://www.fanatec.com/us-en/steering-wheels/clubsport-steering-wheel-gt-xbox-one-usa.html',
            'https://www.fanatec.com/us-en/steering-wheels/clubsport-steering-wheel-bmw-m3-gt2-us.html',
            'https://www.fanatec.com/us-en/steering-wheels/clubsport-steering-wheel-formula-carbon-us.html',
            'https://www.fanatec.com/us-en/steering-wheels/csl-elite-mclaren-gt3-csqr-usa.html',
            'https://www.fanatec.com/us-en/steering-wheels/clubsport-steering-wheel-formula-black-us.html',
            'https://www.fanatec.com/us-en/steering-wheels/clubsport-steering-wheel-formula-one-usa.html',
            'https://www.fanatec.com/us-en/steering-wheels/csl-elite-steering-wheel-p1.html',
            'https://www.fanatec.com/us-en/steering-wheels/csl-steering-wheel-p1-for-xbox-one-usa.html',
            'https://www.fanatec.com/us-en/sim-racing-hardware/clubsport-handbrake-v1-5.html',
            'https://www.fanatec.com/us-en/wheel-stands-table-clamps/clubsport-table-clamp-v2-us.html',
            'https://www.fanatec.com/us-en/wheel-stands-table-clamps/clubsport-shifter-table-clamp-us.html',
            'https://www.fanatec.com/us-en/games/f1-2018-for-pc-usa.html',
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