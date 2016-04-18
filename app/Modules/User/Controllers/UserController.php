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
use Auth;

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
        return response()->json(['roles' => $roles],200);
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
            return response()->json(['status' =>403, 'message' => 'Unauthorized action.'] , 403);
        }else{
            $data           = $request->all();
            $validator      = Validator::make($data, [
                'role_id' => 'required|exists:roles,id',
                'firstname' => 'required',
                'name' => 'required|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|alpha_num',
                'retype_password' => 'required|same:password',
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
                // flash()->error($validator->errors()->first());
                return response()->json(['status' =>500, 'message' => $validator->errors()->first() ] , 200);
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
                $input          = $request->except(['_token', 'role_id', 'retype_password', 'country_name', 'ext_phone', 'calling_code']);
                array_set($input, 'phone_number', $request->ext_phone);
                $user           = User::firstOrCreate($input);
                $user->roles()->attach($request->role_id);

                if($user)
                    return response()->json(['status' =>200, 'message' => 'Penambahan data berhasil.'] , 200);
                else
                    return response()->json(['status' =>500, 'message' => 'Penambahan gagal.'] , 500);
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
        return response()->json($user,200);
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
        if(!$request->has('_method') OR $request->_method !== 'delete'){
            return response()->json(['status' =>403, 'message' => 'Unauthorized action.'] , 403);
        }
        $result         = $user->where('id', '=', $id)->update(['status' => false]);
        flash()->success('Your data has been deleted');
        if($result){
            return response()->json(['status' =>200, 'message' => 'Your data has been deleted.'] , 200);
        }else{
            return response()->json(['status' =>500, 'message' => 'Your data cannot be deleted.'] , 200);
        }        
    }

    public function getListUsers(Request $request)
    {
        $users      = User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->whereNotIn('roles.name', ['root'])
            ->where('status',true)
            ->orderBy('users.name', 'DESC')
            ->orderBy('users.created_at', 'DESC')
            ->orderBy('roles.name', 'ASC')
            ->selectRaw('users.name as username, roles.id as role_id, users.*')
            // ->distinct()
            // ->paginate(15)
            ->get()
            ;
        foreach ($users as $key => $value) {
            # code...
            if($value->hasRole(['root','admin']))
                $users[$key]['has_role'] = 'admin';
            else
                $users[$key]['has_role'] = '';
        }
        // $sms    = Twilio::message('+6285640427774', 'Your Ajaib Verification code is 801753');

        // dd(Twilio::message('+6285227052004', 'shit'));
        // return view('User::index', compact('users'));
            if(Auth::user()->hasRole(['root', 'admin']))
                $has_role = 1;
            else
                $has_role = 0;
            $data = compact('users','has_role');
        return response()->json($data,200);
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
            ->selectRaw('users.id,users.name as user_name,case when users.firstname = \'\' then users.name else users.firstname end as user,users.lastname,users.channel,users.photo')
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
        $pathPhoto  = File::exists(storage_path() . '/' . $user->photo);
        $this->authorize('showProfile', $User);
        if(is_null($user->photo))
        {        
            if($user->gender == 'female') {
                $user->photo = "/img/avatar_female.png";
            }else{
                $user->photo = "/img/avatar_male.png";
            }
        }else{
            if($pathPhoto)
                $user->photo = '/ajaib/profile/photo/'.$id;
            else{
                if($user->gender == 'female') {
                    $user->photo = "/img/avatar_female.png";
                }else{
                    $user->photo = "/img/avatar_male.png";
                }   
            }
        }        
        return response()->json($user,200);
    }

    public function setActive($id, Request $request, User $user)
    {
        // dd($user->roles());
        $this->authorize('setStatus', $user);
        if($this->User->setActive($id)){            
            return response()->json(['status' => 200,'message' => 'Activated user success'] , 200);
        }else{
            return response()->json(['status' => 500,'message' => 'Error occured.'] , 200);
        }

        
    }

    public function uploadPhoto(Request $request)
    {
        $processUpload = $this->Asset->uploadPhoto($request);

        if ($processUpload) {
            return response()->json(['success' => true,'status' => 200,'message' => 'Your data cannot update. Error on save data' , 'path' => '/ajaib/profile/photo/'.$request->user_id] , 200);            
        } else {
            return response()->json(['status' => 500,'message' => 'Your data cannot update. Error on save data'] , 200);
        }
    }

    public function getPhoto($id)
    {
        $user       = User::find($id);
        $pathPhoto  = storage_path() . '/' . $user->photo;

        return $this->Asset->downloadFile($pathPhoto);
    }

    public function getPhotoApiService()
    {
        $id =  Authorizer::getResourceOwnerId();
        $user       = User::find($id);

        if(!is_null($user->photo)){
            $pathPhoto  = storage_path() . '/' . $user->photo;
            $return = $this->Asset->downloadFile($pathPhoto);
        }else{
            $return = response()->json('Not Found', 404);
        }

        return $return;
    }

    public function updateProfile($id, Request $request, User $User)
    {
        if(!$request->has('_method') OR $request->_method !== 'put'){
            return response()->json(['status' =>403, 'message' => 'Unauthorized action.'] , 403);
        }
        if(!auth()->user()->hasRole(['admin', 'root']) AND (!auth()->user()->hasRole(['admin', 'root']) AND (int)auth()->user()->id !== (int)$id)){
            return response()->json(['status' =>403, 'message' => 'Unauthorized action.'] , 403);
        }

        $this->authorize('showProfile', $User);
        $user       = $User->find($id);
        $user->firstname    = $request->firstname;
        $user->lastname     = $request->lastname;
        $user->country_id   = $request->country_id;
        $user->address      = $request->address;
        $user->gender       = $request->gender;

        $user->save();

        if($user){            
            return response()->json(['status' => 200, 'message' => 'Your data has been updated'] , 200);
        }else{
            return response()->json(['status' => 500,'message' => 'Your data cannot update. Error on save data'] , 200);            
        }

    }

}
