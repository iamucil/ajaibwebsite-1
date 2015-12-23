<?php namespace App\Modules\Oauth\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Oauth\Models\OauthClient;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;

class OauthController extends Controller {

    protected $User;

    public function __construct(User $user)
    {
        $this->User         = $user;
    }
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

    public function grantAccess(Request $request)
    {
        // setting oauth client
        $client = new Client([
            'base_uri' => 'http://getajaib.local'
        ]);
        $grant_type         = 'password';
        $client_id          = $request->get('id');
        $client_secret      = $request->get('secret');
        $verification_code  = $request->get('code');
        $email              = '';
        $phone_number       = '';
        $password           = '';
        $query              = User::where('verification_code', $verification_code);
        $user               = [];
        $return             = [];
        if($query->exists()){
            // Update data users
            $query->update([
                'status' => true
            ]);
            $user           = $query->first();
            $email          = $user->email;
            $phone_number   = $user->phone_number;
            $password       = $user->phone_number;
            $username       = $user->email;
        }

        $oauth              = OauthClient::where('id', $client_id)
            ->where('secret', $client_secret);

        if($oauth->exists()){
            $params             = compact('grant_type', 'client_id', 'client_secret', 'username', 'password');
            $response           = $client->request('POST', '/oauth/access_token', [
                'form_params' => $params,
                'header' => [
                    'Content-Type' => 'application/json'
                ], 'Accept'     => 'application/json',
            ]);

            $code               = $response->getStatusCode(); // 200
            $reason             = $response->getReasonPhrase(); // OK
            $body               = $response->getBody();
            $result             = $body->getContents();
            $result             = json_decode($result);
            $return['access_token'] = $result->access_token;
            $return['email']        = $email;
            $return['phone_number'] = $phone_number;
        }

        return response()->json($return);
    }
}
