<?php namespace App\Modules\User\Controllers;

use DB;
use App;
use App\User;
use App\Role;
use App\Country;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use App\Repositories\AssetRepository;
use Storage;
use File;
use Hash;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
// use Twilio;


class UserController extends Controller {
    protected $User;

    function __construct(UserRepository $user, AssetRepository $asset)
    {
        $this->User     = $user;
        $this->Asset    = $asset;
        $this->middleWare('auth', ['except' => ['index', 'store', 'update', 'getPhotoApiService']]);
        $this->beforeFilter(function() {
            $country        = Country::where('iso_3166_2', '=', 'ID')
                ->get(['calling_code', 'id'])
                ->first();
            $calling_code   = $country->calling_code;
            $regexp         = sprintf('/^[(%d)]{%d}+/i', $calling_code, strlen($calling_code));
            $regex          = sprintf('/^[(%s)]{%s}[0-9]{3,}/i', $calling_code, strlen($calling_code));
            $phone_number   = request()->phone_number ?: null;
            $phone_number   = preg_replace('/\s[\s]+/', '', $phone_number);
            $phone_number   = preg_replace('/[\s\W]+/', '', $phone_number);
            $phone_number   = preg_replace('/^[\+]+/', '', $phone_number);
            $phone_number   = preg_replace($regexp, '', $phone_number);
            $phone_number   = preg_replace('/^[(0)]{0,1}/i', $calling_code.'\1', $phone_number);
            $data['ext_phone']  = $phone_number;
            $data['country_id'] = $country->id;
            $data['calling_code']   = $calling_code;
            return request()->merge($data);

        }, ['on' => 'post', 'only' => ['store','storeLocal']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $ownerId =  Authorizer::getResourceOwnerId();
        $user=User::find($ownerId);

        if(is_null($user))
        {
            return response()->json(array(
                    'status'=>404,
                    'message'=>'Data Not Found'
            ),404);
        }else{
            $datauser = [
                'id'=>$user['id'],
                'name'=>$user['name'],
                'firstname'=>$user['firstname'],
                'lastname'=>$user['lastname'],
                'address'=>$user['address'],
                'gender'=>$user['gender'],
                'phone_number'=>$user['phone_number'],
                'email'=>$user['email'],
                'photo'=>$user['photo'],
                'channel'=>$user['channel'],
                'device_id'=>$user['device_id']
            ];

            return response()->json(array(
                'status'=>200,
                'message'=>'Success Retrieve Data',
                'data'=>$datauser
            ),200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles      = Role::whereNotIn('name', ['root', 'users'])->lists('name', 'id');
        $user['gender'] = 'male';
        return view('User::create', compact('roles', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator      = Validator::make($request->all(), [
            'phone_number' => 'required|regex:/^[0-9]{6,}$/',
            'email' => 'required|email|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);
        if($validator->fails()){
            return response()->json(array(
                'status' => 500,
                'message' => $validator->errors()->first()
            ),500);
        }else {
            $input          = $request->except(['_token', 'role_id', 'retype-password', 'country_name', 'ext_phone', 'calling_code']);
            // $input['phone_number']  = $request->ext_phone;
            array_set($input, 'phone_number', $request->ext_phone);
            $user = $this->User->createOrUpdateUser($input);
            if ($user) {
                return response()->json(array(
                    'status' => 201,
                    'message' => 'Success Saving'
                ),201);
            } else {
                return response()->json(array(
                    'status' => 500,
                    'message' => 'Error Saving'
                ),500);
            }
        }
    }

    public function storeLocal(Request $request)
    {
        if (!$request->isMethod('post')) {
            App::abort(403, 'Unauthorized action.');
        }else{
            $data           = $request->all();
            $validator      = Validator::make($data, [
                'role_id' => 'required|exists:roles,id',
                'firstname' => 'required',
                'name' => 'required|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|alpha_num',
                'retype-password' => 'required|same:password',
                'phone_number' => 'required|unique:users|regex:/^[0-9]{6,}$/',
                'country_id' => 'required|exists:countries,id',
                'ext_phone' => 'required|unique:users,phone_number|regex:/^[0-9]{6,}$/',
            ], [
                'country_id.required' => 'You must define your country',
                'ext_phone.required' => 'Please fill your phone number',
                'ext_phone.integer' => 'Phone number must be integer',
                'ext_phone.unique' => 'Phone number already been taken',
            ]);

            if($validator->fails()){
                flash()->error($validator->errors()->first());
                return redirect()->route('user.add')->withInput($request->except(['password', 'retype-password']))->withErrors($validator);
            }else{
                $data['channel']    = hash('crc32b', bcrypt(uniqid(rand()*time())));
                $calling_code       = $data['calling_code'];
                $regexp             = sprintf('/^[(%d)]{%d}/i', $calling_code, strlen($calling_code));
                $regex              = sprintf('/^[(%s)]{%s}[0-9]{3,}/i', $calling_code, strlen($calling_code));
                $data['channel']    = preg_replace($regexp, '${2}', $data['ext_phone']);
                $data['channel']    = hash('crc32b', bcrypt(uniqid($data['channel'])));
                $data['channel']    = preg_replace('/(?<=\w)([A-Za-z])/', '-\1', $data['channel']);
                $data['status']         = true;
                $data['password']       = bcrypt($data['password']);
                $data['verification_code']  = '******';
                $request->merge($data);
                $input          = $request->except(['_token', 'role_id', 'retype-password', 'country_name', 'ext_phone', 'calling_code']);
                array_set($input, 'phone_number', $request->ext_phone);
                $user           = User::firstOrCreate($input);
                $user->roles()->attach($request->role_id);

                flash()->success('Penambahan data berhasil!');
                return redirect()->route('user.list');
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
    public function edit($id, Request $request, User $User)
    {
        if(!auth()->user()->hasRole(['admin', 'root']) AND (!auth()->user()->hasRole(['admin', 'root']) AND (int)auth()->user()->id !== (int)$id)){
            App::abort(403, 'Unauthorized action.');
        }

        $user       = User::findOrFail($id);
        $roles      = Role::whereNotIn('name', ['root', 'users'])->lists('name', 'id');
        $this->authorize('showProfile', $User);
        return view('User::edit', compact('user', 'url', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
        $ownerId    = Authorizer::getResourceOwnerId();
        $user       = User::find($ownerId);

        if(is_null($user))
        {
            return response()->json(array(
                'status'=>404,
                'message'=>'Data Not Found'
            ),404);
        }

        if(!is_null($request->firstname))
        {
            $user->firstname=$request->firstname;
        }
        if(!is_null($request->lastname))
        {
            $user->lastname=$request->lastname;
        }
        if(!is_null($request->address))
        {
            $user->address=$request->address;
        }
        if(!is_null($request->gender))
        {
            $user->gender=$request->gender;
        }
        if(!is_null($request->device_id))
        {
            $user->device_id=$request->device_id;
        }

        if(!is_null($request->file('image_file')))
        {
            $request->user_id = $ownerId;
            $processUpload = $this->Asset->uploadPhoto($request);
            if(!$processUpload)
            {
                return response()->json(array(
                    'status'=>500,
                    'message'=>'Error Upload Photo'
                ),500);
            }
        }

        $success=$user->save();
        if(!$success)
        {
            return response()->json(array(
                    'status'=>500,
                    'message'=>'Error Updating'
            ),500);
        }
        return response()->json(array(
                'status'=>201,
                'message'=>'Success Updating'
        ),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Request $request, User $user)
    {
        $this->authorize('destroy', $user);
        if(!$request->has('_method') OR $request->_method !== 'DELETE'){
            App::abort(403, 'Unauthorized action.');
        }

        $result         = $user->where('id', '=', $id)->update(['status' => false]);
        if (request()->ajax()){
            if((bool)$result === true) {
                return response()->json([
                    'result' => true,
                    'message' => 'Your data has been deleted',
                    'status' => 201
                ], 201, [], JSON_PRETTY_PRINT)->header('Content-Type', 'application/json');
            } else {
                return response()->json([
                    'result' => false,
                    'message' => 'Error occured when deleting your data',
                    'status' => 500
                ], false, [], JSON_PRETTY_PRINT)->header('Content-Type', 'application/json');
            }
        }else{
            flash()->success('Your data has been deleted');

            return redirect()->route('user.list');
        }
    }

    public function getListUsers(Request $request)
    {
        $users          = [];
        return view('User::index', compact('users'));
    }

    /**
     * Get list user (role = users) and accessed by operator to be parsed to offline user list
     * will be init at the first time operator access his/her dashboard
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListUsersOperator(Request $request)
    {
        $users = User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->whereIn('roles.name', ['users'])
            ->orderBy('users.name', 'DESC')
            ->selectRaw('users.id,users.device_id,users.name as user_name,case when users.firstname = \'\' then users.name else users.firstname end as user,users.lastname,users.channel,users.photo')
            ->get();
        return response()->json(array(
            'status'=>200,
            'message'=>'Success Retrieve Data',
            'data'=>$users
        ),200);
    }

    public function showProfile($id, User $User)
    {
        if(!auth()->user()->hasRole(['admin', 'root']) AND (!auth()->user()->hasRole(['admin', 'root']) AND (int)auth()->user()->id !== (int)$id)){
            App::abort(403, 'Unauthorized action.');
        }

        $user       = User::findOrFail($id);
        $this->authorize('showProfile', $User);
        if(is_null($user->photo))
        {
            if($user->gender == 'female') {
                $user->photo = "/img/avatar_female.png";
            }else{
                $user->photo = "/img/avatar_male.png";
            }
        }else{
            $user->photo = '/profile/photo/'.$id;
        }
        $url        = secure_url('/');
        return view('User::profile', compact('user', 'url'));
    }

    public function setActive($id, Request $request, User $user)
    {
        // dd($user->roles());
        $this->authorize('setStatus', $user);

        if(!$request->has('_method') OR $request->_method !== 'PUT'){
            App::abort(403, 'Unauthorized action.');
        }
        $result         = $this->User->setActive($id);
        if (request()->ajax()){
            if((bool)$result === true) {
                return response()->json([
                    'result' => true,
                    'message' => 'User has ben activated',
                    'status' => 201
                ], 201, [], JSON_PRETTY_PRINT)->header('Content-Type', 'application/json');
            } else {
                return response()->json([
                    'result' => false,
                    'message' => 'Error occured when processing your request. Please try again',
                    'status' => 500
                ], false, [], JSON_PRETTY_PRINT)->header('Content-Type', 'application/json');
            }
        }else{
            if($result){
                flash()->success('Activated user success');
            }else{
                flash()->error('Error occured');
            }

            return redirect()->route('user.list');
        }
    }

    public function uploadPhoto(Request $request)
    {
        $processUpload = $this->Asset->uploadPhoto($request);

        if ($processUpload) {
            return response()->json(['success' => true, 'path' => 'photo/'.$request->user_id], 200);
        } else {
            return response()->json('error', 400);
        }
    }

    public function getPhotoPath($id) {
        $user       = User::find($id);
        return response()->json(['code' => 200, 'message' => 'success', 'data' => array('path' => $user->photo)], 200);
    }

    public function getPhoto($id,$path=false)
    {
        $user       = User::find($id);
        return $this->Asset->downloadFile($user->photo);
    }

    public function getPhotoApiService()
    {
        $id =  Authorizer::getResourceOwnerId();
        $user       = User::find($id);
        if(!is_null($user->photo)){
            $return = $this->Asset->downloadFile($user->photo);
        }else{
            $return = response()->json('Not Found', 404);
        }

        return $return;
    }

    public function updateProfile($id, Request $request, User $User)
    {
        if(!$request->has('_method') OR $request->_method !== 'PUT'){
            App::abort(403, 'Unauthorized action.');
        }

        if(!auth()->user()->hasRole(['admin', 'root']) AND (!auth()->user()->hasRole(['admin', 'root']) AND (int)auth()->user()->id !== (int)$id)){
            App::abort(403, 'Unauthorized action.');
        }

        $this->authorize('showProfile', $User);
        $user               = $User->find($id);
        $user->firstname    = $request->firstname;
        $user->lastname     = $request->lastname;
        $user->country_id   = $request->country_id;
        $user->address      = $request->address;
        $user->gender       = $request->gender;

        $user->save();

        flash()->success('Your data has been updated');

        return redirect()->route('user.profile', $id);
    }

    public function getUsers()
    {
        $users      = User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', function ($join) {
                return $join->on('roles.id', '=', 'role_user.role_id')->whereNotIn('roles.name', ['administrator', 'root']);
            })
            ->select('roles.name as role_name', 'roles.id as role_id', 'users.*')
            ->orderBy('users.status', 'ASC')
            ->orderBy('users.created_at', 'DESC')
            ->where('users.id', '!=', auth()->user()->id)
            ->get();

        $rows       = [];
        $idx        = 0;
        foreach ($users as $user) {
            $rows[$idx]['id']       = (int)$user->id;
            $link_profile           = route("user.profile", $args = ['id' => $user->id]);
            if(auth()->user()->hasRole(['administrator', 'admin'])) {
                $link_reset_password    = '<i class="glyphicon glyphicon-lock">&nbsp;</i>^javascript:resetPassword("'.$user->id.'");;^_self';
            } else {
                $link_reset_password    = null;
            }
            switch ((bool)$user->status) {
                case true:
                    $status_img     = asset("/img/icons/green.gif");
                    $link_aktivasi  = '<i class="fontello-ok-outline">&nbsp;</i>^javascript:alertify.log("This user is already active");;^_self';
                    if(strtoupper($user->role_name) == 'USERS'){
                        $link_delete    = '<i class="fontello-cancel-circled">&nbsp;</i>^javascript:setStatus("deactive", "'.$user->id.'");^_self';
                    }else{
                        $link_delete    = '<i class="fontello-cancel-circled-outline">&nbsp;</i>^javascript:alertify.log("You can not delete this data. Data is not yet activated.");;^_self';
                    }
                    break;
                case false:
                    $status_img     = asset("/img/icons/red.gif");
                    $link_aktivasi  = '<i class="fontello-ok">&nbsp;</i>^javascript:setStatus("activate", "'.$user->id.'");^_top';
                    $link_delete    = '<i class="fontello-cancel-circled-outline">&nbsp;</i>^javascript:alertify.log("You can not delete this data. Data is not yet activated.");;^_self';
                    break;
                default:
                    $status_img     = asset("/img/icons/yellow.gif");
                    $link_aktivasi  = '<i class="fontello-ok-outline">&nbsp;</i>^javascript:alertify.log("This user is already active");;^_self';
                    $link_delete    = '<i class="fontello-cancel-circled-outline">&nbsp;</i>^javascript:alertify.log("You can not delete this data. Data is not yet activated.");;^_self';
                    break;
            }
            $rows[$idx]['data']   = [
                (int)$user->id,
                $user->firstname ?: $user->name,
                $user->phone_number,
                $user->email,
                $user->role_name,
                date('F d, Y', strtotime($user->created_at)),
                $status_img,
                '<i class="glyphicon glyphicon-user" title="Profile User">&nbsp;</i>^'.$link_profile.'^_self',
                $link_delete,
                $link_aktivasi,
                $link_reset_password
            ];

            $idx++;
        }

        // id - (mixed) the column's id
        // width - (number) the column's width
        // type - (string) the column's type
        // align - (string) the column's alignment
        // sort - (mixed) the sorting type
        // value - (string) the column's title

        return response()->json(compact('head', 'rows'), 200, [], JSON_PRETTY_PRINT)->header('Content-Type', 'application/json');
    }

    public function resetPasswordDefault(Request $request)
    {
        if (!$request->isMethod('post') OR !request()->ajax()) {
            App::abort(403, 'Unauthorized action.');
        } else {
            $user               = User::find($request->id);
            $user->password     = bcrypt(env('PASSWORD_DEFAULT','secret'));
            $result             = $user->save();
            if($result === false) {
                $return         = [
                    'result' => false,
                    'message' => 'Error occured when processing your request. Please try again',
                    'status' => 500
                ];
            }else{
                $return         = [
                    'result' => true,
                    'message' => 'Password reset to default',
                    'status' => 201
                ];
            }
            return response()->json($return, 200, [], JSON_PRETTY_PRINT)->header('Content-Type', 'application/json');
        }
    }

    public function getResetPassword($id, Request $request)
    {
        $user   = User::findOrFail($id);

        return view('User::reset_password', compact('user'));
    }

    public function postResetPassword(Request $request)
    {
        $data       = $request->all();
        Validator::extend('check_hash', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, auth()->user()->password);
        });
        $this->validate($request, [
            'user_id' => 'required',
            'current_password' => 'required|check_hash',
            'password' => 'required|alpha_num',
            'password_confirmation' => 'required_with:password|same:password'
        ], [
            'current_password.check_hash' => 'Current Password yang Anda masukkan tidak valid.',
            'current_password.required' => 'Current Password Mandatory',
            'password.required' => 'Password Mandatory',
            'password.alpha_num' => 'Masukkan Password Alpha Numeric',
            'password_confirmation.required_with' => 'Konfirmasi password anda'
        ]);

        $user           = User::findOrFail($request->user_id);
        $user->password = bcrypt($request->password);

        $user->save();
        auth()->login($user);
        $request->session()->flash('warning', 'Task was successful!');

        return response()->json([
            'message' => 'Perubahan password berhasil',
            'status' => 201,
            'url' => route("admin::dashboard")
        ], 200, [], JSON_PRETTY_PRINT)->header('Content-Type', 'application/json');
    }
}
