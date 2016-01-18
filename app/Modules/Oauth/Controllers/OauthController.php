<?php namespace App\Modules\Oauth\Controllers;
use Hash;
use App\User;
use App\Country;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Oauth\Models\OauthClient;
use Validator;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;

class OauthController extends Controller {

    protected $User;
    protected $server = null;
    public function __construct(User $user)
    {
        $this->User         = $user;
        $this->middleware('auth', ['except' => ['grantAccess', 'refreshToken']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $clients        = OauthClient::orderBy('name', 'DESC')->paginate(15);
        return view("Oauth::index", ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view("Oauth::create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator      = Validator::make($request->all(), [
            'name' => 'required|unique:oauth_clients|max:50',
            'id' => 'required|unique:oauth_clients',
            'secret' => 'required|unique:oauth_clients'
        ]);
        if($validator->fails()){
            flash()->error($validator->errors()->first());
            return redirect()->route('oauth.create')->withInput($request->except(['id', 'secret']))->withErrors($validator);
        }else{
            $credentials    = new OauthClient();
            $credentials->id    = $request->id;
            $credentials->secret    = $request->secret;
            $credentials->name      = $request->name;

            if($credentials->save()) {
                flash()->success('New credentials for oauth has been saved!!');
                return redirect()->route('oauth.index');
            }else{
                flash()->error('Error occured when saving data');
                return redirect()->route('oauth.create')->withInput($request->except(['id', 'secret']))->withErrors($validator);
            }

        }
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
        $base_uri       = secure_url('/');
        $client = new Client([
            'base_uri' => $base_uri,
            'verify' => false
        ]);
        $grant_type         = 'password';
        $client_id          = $request->id;
        $client_secret      = $request->secret;
        $verification_code  = preg_replace('/\s[\s]+/', '', $request->code);
        $verification_code  = preg_replace('/[\s\W]+/', '', $request->code);

        $email              = '';
        $phone_number       = '';
        $password           = '';
        $query              = User::where('verification_code', '=', ($verification_code == '') ? NULL : $verification_code);
        $user               = [];
        $return             = [];
        if($query->exists()){
            // return $query->first();
            // Update data users
            $query->update([
                'status' => true,
                'verification_code' => str_repeat('*', 6)
            ]);
            $user           = $query->first();
            if(!$user->hasRole('users')){
                $return['status']   = 404;
                $return['message']  = 'Not Found';
            }else{
                $country_id     = $user->country_id;
                $country        = Country::find($country_id);
                $calling_code   = $country->calling_code;
                $email          = $user->email;
                $phone_number   = $user->phone_number;
                $phone_number   = preg_replace('/\s[\s]+/', '', $phone_number);
                $phone_number   = preg_replace('/[\s\W]+/', '', $phone_number);
                $phone_number   = preg_replace('/^[\+]+/', '', $phone_number);
                $phone_number   = preg_replace('/^[(0)]{0,1}/i', $calling_code.'\1', $phone_number);
                $regexp         = sprintf('/^[(%d)]{%d}+/i', $calling_code, strlen($calling_code));
                $regex          = sprintf('/^[(%s)]{%s}[0-9]{3,}/i', $calling_code, strlen($calling_code));
                $phone_number   = preg_replace($regexp, '${2}', $phone_number);
                $username       = preg_replace($regexp, '${2}', $phone_number);
                $password       = '+'.$phone_number;
                $username       = $user->email;
                // return compact('username', 'password', 'phone_number');
                $oauth              = OauthClient::where('id', $client_id)
                    ->where('secret', $client_secret);

                if($oauth->exists()){
                    $params             = compact('grant_type', 'client_id', 'client_secret', 'username', 'password');
                    $response           = $client->request('POST', 'api/v1/oauth/access_token', [
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
                    $return['access_token']     = $result->access_token;
                    $return['refresh_token']    = $result->refresh_token;
                    $return['email']            = $email;
                    $return['phone_number']     = $phone_number;
                    $return['expires']          = $result->expires_in;
                }
            }
        }else{
            $return['status']   = 404;
            $return['message']  = 'Not Found';
        }


        return response()->json($return);
    }

    public function refreshToken(Request $request)
    {
        // setting oauth client
        $base_uri       = secure_url('/');
        $client = new Client([
            'base_uri' => $base_uri,
            'verify' => false
        ]);
        $return             = [];
        $grant_type         = 'refresh_token';
        $client_id          = $request->id;
        $client_secret      = $request->secret;
        $refresh_token      = $request->token;
        $oauth              = OauthClient::where('id', $client_id)
            ->where('secret', $client_secret);
            // return $request->all();

        if($oauth->exists()){
            $params             = compact('grant_type', 'client_id', 'client_secret', 'refresh_token');
            $response           = $client->request('POST', 'api/v1/oauth/access_token', [
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
            $return['access_token']     = $result->access_token;
            $return['refresh_token']    = $result->refresh_token;
            $return['expires']          = $result->expires_in;
        }

        return response()->json($return);
    }

    public function generateCredentials(Request $request)
    {
        // return response()->json(['name' => $request->name, 'state' => 'CA']);
        // $credentials    = $request->all();
        // get input request, to handle redudance data in table oauth_clients
        // param['name'] -> unique

        $credentials['name']    = $request->name;
        $chars          = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $buf            = [];
        $keys           = [0];
        $app_key        = env('APP_KEY');
        while (count($buf) <= strlen($chars)) {
            $key        = mt_rand(count($buf), strlen($chars));
            if($key == '62'){
                $key    = mt_rand(min($keys), strlen($chars)-1);
            }
            try {
                $buf[]      = $chars[$key];
            } catch (Exception $e) {
                // do nothing
            }
            $keys[]     = $key;
        }
        $buffers        = preg_replace('/[^A-Za-z0-9\-]/', '', Hash::make(uniqid($credentials['name']).''.implode('', $buf)));
        $key_buffer     = preg_replace('/[^A-Za-z0-9\-]/', '', Hash::make($app_key.uniqid($credentials['name']).''.implode('', $buf)));
        // return response()->json(['name' => $request->name, 'state' => 'CA']);
        $clients        = [];
        $secrets        = [];
        for ($i = 0; $i < 40; $i++) {
            $char       = $buffers[rand(0, strlen($buffers) - 1)];
            $kb         = $key_buffer[mt_rand(0, strlen($key_buffer) - 1)];
            $clients[]  = $char;
            $secrets[]  = $kb;
        }
        $client_id      = implode('', $clients);
        $client_secret  = implode('', $secrets);
        $exists         = OauthClient::where('id', $client_id)
            ->orWhere('secret', $client_secret)
            ->orWhere('name', $credentials['name'])
            ->exists();
        return response()->json(compact('client_id', 'client_secret', 'exists'));
    }
}
