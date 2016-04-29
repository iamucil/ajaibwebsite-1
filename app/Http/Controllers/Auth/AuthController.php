<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Country;
use Illuminate\Support\Facades\Lang;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $user;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->user         = $user;
        // set in constructor or set as protected variable
        $this->redirectAfterLogout  = route("login");
        $this->loginPath            = route("login");
        $this->redirectPath         = route("admin::dashboard");
        $this->redirectTo           = route("admin::dashboard");
        $this->beforeFilter(function() {
            $country_code       = request()->country_code;
            if((isset(request()->country_code) OR !empty(request()->country_code))) {
                $country_code   = 'ID';
            }
            // $country_code   = (isset(request()->country_code) OR !empty(request()->country_code)) ?: 'ID';
            // dd($country_code);
            $country        = Country::where('iso_3166_2', '=', strtoupper($country_code))
                ->get(['calling_code', 'id'])
                ->first();
            $calling_code   = $country->calling_code;
            $regexp         = sprintf('/^[(%d)]{%d}+/i', $calling_code, strlen($calling_code));
            $regex          = sprintf('/^[(%s)]{%s}[0-9]{3,}/i', $calling_code, strlen($calling_code));
            $phone_number   = request()->phone_number ?: null;
            $phone_number   = preg_replace('/\s[\s]+/', '', $phone_number);
            $phone_number   = preg_replace('/[\s\W]+/', '', $phone_number);
            $phone_number   = preg_replace('/^[\+]+/', '', $phone_number);
            request()->phone_number = $phone_number;
            $phone_number   = preg_replace($regexp, '', $phone_number);
            $phone_number   = preg_replace('/^[(0)]{0,1}/i', $calling_code.'\1', $phone_number);
            $data['ext_phone']  = $phone_number;
            $data['country_id'] = $country->id;
            return request()->merge($data);

        }, ['on' => 'post', 'only' => 'doRegister']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /**
         * Set Validation field is not unique
         * If Found data user with current credential,
         * Send Fresh Token
         */

        return Validator::make($data, [
            'email' => 'required|email|max:255',
            'phone_number' => 'required|regex:/^[0-9]{6,}$/',
            'ext_phone' => 'required|regex:/^[0-9]{6,}$/',
            'country_id' => 'required|exists:countries,id',
        ], [
            'ext_phone.required' => 'Please fill your phone number',
            'ext_phone.integer' => 'Phone number must be integer',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::firstOrCreate([
            'name' => $data['phone_number'],
            'email' => $data['email'],
            'password' => bcrypt($data['phone_number']),
            'phone_number' => $data['phone_number'],
            'channel' => 1
        ]);
    }

    public function doRegister(Request $request)
    {
        $validator          = $this->validator($request->all());

        if ($validator->fails()) {
            if(request()->ajax()){
                return response()->json([
                    'status' => 400,                        
                    'message' => 'The server cannot or will not process the request due to something that is perceived to be a client error (e.g., malformed request syntax, invalid request message framing, or deceptive request routing)',
                    'data' => $request->all(),
                    'errors' => $validator->errors()
                ]);
            }else{
                return redirect()->route('register')
                    ->withErrors($validator, 'register')
                    ->withInput()
                    ->with('errors', $validator->errors());
            }
        }

        $user           = $this->user->createOrUpdateUser($request->all());
        if($user){
            if(request()->ajax()){
                return response()->json(
                    ['status' => 200,                
                    'message' => 'Success',
                    'data' => $request->all(), 'errors' => NULL]
                );
            }else{
                return redirect()->route('auth.success.get')
                    ->with('user', $user['user'])
                    ->with('status', (bool)$user['exists']);
            }
        }else{
            if(request()->ajax()){
                return response()->json(
                    ['status' => 200,                
                    'message' => 'Failed to register. Please contact our Administrator.'                    
                    ]
                );
            }else{
                return redirect()->route('register')
                    ->withErrors($validator, 'register')
                    ->withInput()
                    ->with('errors', $validator->errors());
            }
        }
    }

    public function doLogin(Request $request)
    {
        $field          = filter_var($request[$this->loginUsername()], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $request->merge([
            $field => $request->input($this->loginUsername()),
            'status' => true
        ]);
        $this->validate($request, [
            $this->loginUsername() => 'required',
            'password' => 'required',
        ], [
            $this->loginUsername().'.required' => 'Please fill your username or email',
            'password.required' => 'Please define your password'
        ]);
        $credentials    = $request->only([$field, 'password', 'status']);
        $throttles      = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }


        if (Auth::attempt($credentials, $request->has('remember'))) {
            // return $this->handleUserWasAuthenticated($request, $throttles);
            if ($throttles) {
                $this->clearLoginAttempts($request);
            }

            if(request()->ajax()){
                return response()->json([
                    'status' => 200,
                    'message' => '',                    
                    'data' => $request->all()                
                ]);
            }else{
                return redirect($this->loginPath())
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([
                    $this->loginUsername() => $this->getFailedLoginMessage(),
                ]);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        if($this->getFailedLoginMessage() != ''){
            if(request()->ajax()){
                return response()->json([
                    'status' => 400,
                    'message' => $this->getFailedLoginMessage()?: 'The server cannot or will not process the request due to something that is perceived to be a client error (e.g., malformed request syntax, invalid request message framing, or deceptive request routing)',
                    'data' => $request->all()                    
                ]);
            }else{
                return redirect($this->loginPath())
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([
                    $this->loginUsername() => $this->getFailedLoginMessage(),
                ]);
            }
        }
    }

    public function getLogout()
    {
        Auth::logout();        
        if(request()->ajax()){
            return response()->json([
                'status' => 200,
                'message' => 'You are logged out.'                            
            ]);
        }else{
            return redirect($this->redirectAfterLogout);
        }        
    }
}
