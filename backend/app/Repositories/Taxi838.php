<?php

namespace App\Repositories;

use GuzzleHttp\Psr7\Request;

class Taxi838 implements TaxiInterface
{

    /**
     * @var string
     */
    public $name = 'Taxi838';

    /**
     * @return Request
     */
    public function getRequest()
    {
        return new Request('POST', 'ru-RU/adfe0530-4bd0-4ac2-98bd-db25ef337af4/WebOrders/CalcCost', [
            'headers' => $this->getHeaders(),
        ]);
    }

    /**
     * @return array
     */
    protected function getHeaders()
    {
        return [
            "Accept: */*",
            "Accept-Encoding: gzip, deflate",
            "Accept-Language: en-GB,en;q=0.9,ru-UA;q=0.8,ru;q=0.7,en-US;q=0.6",
            "Cache-Control: no-cache",
            "Connection: keep-alive",
            "Content-Length: 845",
            "Content-Type: application/x-www-form-urlencoded",
            "Cookie: wrawrsatrsrweasrdxsf=7a0729de26bd4f87bcd2fe6cea4896c3=WUBEw87awMZXw8L2Ini3Jp4SdZu4Uhl20IeeEgfBvyqgbfTjw0LTSLwcX4H4vj9Kb/xiax3V0bK+k66TJzCCj24n5LGa44Skjrt6DTNBxU8aX7z9Gc0sqi3hn86Nw++0xc+vUD5ywg528wUkeWF5hvHQcGyyYOKpCzRRgfhM6jAt9M7AODjN3BXhS1icjcr8mtPYlqE3EvPOUPIwfi13oA==; wrawrsatrsrweasrdxsfw2ewasjret=",
            "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/63.0.3239.84 Chrome/63.0.3239.84 Safari/537.36",
            "X-Requested-With: XMLHttpRequest",
        ];
    }
}