<?php

namespace App\Http\Controllers\Auth;

use App\User;
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
    protected $redirectPath         = '/dashboard/';
    protected $redirectAfterLogout  = '/auth/login';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->user         = $user;
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
            'email' => 'required|email|max:255|unique:users',
            'phone_number' => 'required|integer|unique:users|regex:/^[0-9]{6,11}$/',
            'country_id' => 'required|exists:countries,id',
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
        $validator      = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect('/auth/register')
                ->withErrors($validator, 'register')
                ->withInput()
                ->with('errors', $validator->errors());
        }

        $user           = $this->user->createOrUpdateUser($request->all());
        return redirect()->route('auth.success.get')
            ->with('user', $user['user'])
            ->with('status', (bool)$user['exists']);
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
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }
}
