<?php

namespace App\Repositories;


use App\Models\Address;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class Taxi838 implements TaxiInterface
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiUrl = 'http://rainbow.evos.in.ua/';

    /**
     * @var Address
     */
    private $from;

    /**
     * @var Address
     */
    private $to;

    /**
     * Taxi838 constructor.
     *
     * @param Address $from
     * @param Address $to
     */
    public function __construct(Address $from, Address $to)
    {
        $this->client = new Client([
            'base_uri' => $this->apiUrl,
        ]);
        $this->from   = $from;
        $this->to     = $to;
    }

    /**
     * @return Request
     */
    public function sendRequest()
    {
        $request = new Request('POST', 'ru-RU/adfe0530-4bd0-4ac2-98bd-db25ef337af4/WebOrders/CalcCost', [
            'headers' => $this->getHeaders(),
        ]);

        $response = $this->client->sendAsync($request, [
            'form_params' => $this->getBody()
        ])->then(function (ResponseInterface $response) {
            $html = (string)$response->getBody();

            $span_start = strpos($html,'<span id="dCostBlock">') + 22;
            $span_end = strpos($html, '</span>', $span_start) - 8;


            $price = intval(substr($html,$span_start, $span_end - $span_start));


            dd($price);
            echo $response->getBody();
        });

        $response->wait();

        return $request;
    }

    public function parseRespond()
    {
        // TODO: Implement parseRespond() method.
    }

    public function getCost()
    {
        // TODO: Implement getCost() method.
    }

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

    protected function getBody()
    {
        return [
            'LocationFrom.Address'         => $this->from->street,
            'LocationFrom.AddressNumber'   => $this->from->home,
            'LocationFrom.Entrance'        => '',
            'LocationFrom.IsStreet'        => 'True',
            'LocationFrom.Comment'         => '',
            'IsRouteUndefined'             => 'false',
            'LocationsTo[0].Address'       => $this->to->street,
            'LocationsTo[0].AddressNumber' => $this->to->home,
            'LocationsTo[0].IsStreet'      => 'True',
            'ReservationType'              => 'None',
            'ReservationDate'              => '',
            'ReservationTime'              => '',
            'IsWagon'                      => 'false',
            'IsMinibus'                    => 'false',
            'IsPremium'                    => 'false',
            'IsConditioner'                => 'false',
            'IsBaggage'                    => 'false',
            'IsAnimal'                     => 'false',
            'IsCourierDelivery'            => 'false',
            'IsReceipt'                    => 'false',
            'UserFullName'                 => '',
            'UserPhone'                    => '',
            'AdditionalCost'               => '',
            'OrderUid'                     => '',
            'Cost'                         => '',
            'UserBonuses'                  => '',
            'calcCostInProgress'           => 'False',
            'IsPayBonuses'                 => 'False',
        ];
    }

    static public function researchAddress($address)
    {
        $client = new Client();
        $response = $client->request('GET','http://rainbow.evos.in.ua/uk-UA/adfe0530-4bd0-4ac2-98bd-db25ef337af4/Address/Find?q=' . $address . '&limit=5');

        $response = (string)$response->getBody();

        if (strpos($response,"<span disabled='disabled'>") !== false)
            return false;

        $response = array_filter(explode(PHP_EOL, $response));

        return $response;
    }
}