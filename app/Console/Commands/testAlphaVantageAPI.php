<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Listing;

class testAlphaVantageAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-alpha-vantage-a-p-i';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $api_key = 'EASEPIZGNNT03ZR4';
        $state = 'active';
        $date = Carbon::now()->format('Y-m-d');
        $api_function = 'LISTING_STATUS';

        $data = file_get_contents("https://www.alphavantage.co/query?function=$api_function&date=$date&state=$state&apikey=$api_key");
        $rows = explode("\n", $data);
        $s = array();

        $skip = false;

        foreach ($rows as $row) {

            if (!$skip) {
                $skip = true;
                continue;
            }

            $s[] = str_getcsv($row);

            // $listing = new Listing;
            // $listing->name = $s[1];
            // $listing->symbol = $s[0];
            // $listing->exchange = $s[2];
            // $listing->asset_type = $s[3];
            // $listing->ipo_date = $s[4];
            // $listing->delisting_date = $s[5] === 'null' ? null : $s[5];
            // $listing->status = $s[6];
            // $listing->save();

            // [
            //     0 => "symbol"
            //     1 => "name"
            //     2 => "exchange"
            //     3 => "assetType"
            //     4 => "ipoDate"
            //     5 => "delistingDate"
            //     6 => "status"
            // ]

            // [
            //     0 => "AIRG"
            //     1 => "Airgain Inc"
            //     2 => "NASDAQ"
            //     3 => "Stock"
            //     4 => "2016-08-12"
            //     5 => "null"
            //     6 => "Active"
            // ]
        }

        foreach ($s as $row) {

            if (is_null($row[0])) {
                continue;
            }

            if ($row[2] !== 'NASDAQ') {
                continue;
            }

            $listing = new Listing;
            $listing->name = $row[1];
            $listing->symbol = $row[0];
            $listing->exchange = $row[2];
            $listing->asset_type = $row[3];
            $listing->ipo_date = $row[4];
            $listing->delisting_date = $row[5] === 'null' ? null : $row[5];
            $listing->status = $row[6];
            $listing->save();
        }

        return 'done';
    }
}
