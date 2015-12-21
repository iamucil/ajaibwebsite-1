<?php namespace App\Modules\Oauth\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;

class OauthController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("Oauth::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        die('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function client()
    {
        printf("uniqid('php_'): %s\r\n", uniqid('php_'));
        $client = new Client([
            'base_uri' => 'http://getajaib.local'
        ]);
        $res = $client->request('POST', '/oauth/access_token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => 'f3d259ddd3ed8ff3843839b',
                'client_secret' => '4c7f6f8fa93d59c45502c0ae8c4a95b',
                'username' => 'ecko.ucil@gmail.com',
                'password' => '+6285640427774'
            ]
        ]);

        echo '<pre>';
        print_r(json_decode($res->getBody()->getContents(), true));
        echo self::_getPseudoString(6);
        echo '</pre>';
        // {"type":"User"...'

        // // Send an asynchronous request.
        // $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
        // $promise = $client->sendAsync($request)->then(function ($response) {
        //     echo 'I completed! ';
        //     print_r($response->getBody());
        // });
        // echo '</pre>';
        // $promise->wait();
    }

    private function _getPseudoString($range = 8)
    {
        $range_start      = 48;
        $range_end        = 122;
        $random_string          = "";
        $random_string_length   = $range;

        for ($i = 0; $i < $random_string_length; $i++) {
            // generates a number within the range
            $ascii_no = round( mt_rand( $range_start , $range_end ) );
            // finds the character represented by $ascii_no and adds it to the random string
            // study **chr** function for a better understanding
            $random_string .= chr( $ascii_no );
        }

        return $random_string;
   }
}
