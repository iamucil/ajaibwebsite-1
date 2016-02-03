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

use Illuminate\Config\Repository;
use Illuminate\Http\Request;

class UserController extends Controller {
    protected $User;

    function __construct(UserRepository $user, AssetRepository $asset)
    {
        $this->User     = $user;
        $this->Asset    = $asset;
        $this->middleWare('auth', ['except' => ['index', 'store', 'update']]);
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
        flash()->success('Your data has been deleted');

        // $result         = DB::transaction(function ($id) use ($id) {
        //     $result     = true;
        //     $result     &= DB::table('users')->where('id', '=', $id)->update([
        //         'sttaus' => false
        //     ]);
        //     // $result     &= DB::table('role_user')->where('user_id', '=', $id)->delete();

        //     return $result;
        // });

        // if((bool)$result === true){
        // }else{
        //     flash()->error('Unable to delete data user');
        // }

        return redirect()->route('user.list');
    }

    public function getListUsers(Request $request)
    {
        // $data_user  = User::all();
        // dd($data_user);
        // foreach ($data_user as $usr) {
        //     echo '<pre>';
        //     print_r($usr->roles);
        //     echo '</pre>';
        // }

        // die();
        $users      = User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->whereNotIn('roles.name', ['root'])
            ->orderBy('users.name', 'DESC')
            ->orderBy('users.created_at', 'DESC')
            ->orderBy('roles.name', 'ASC')
            ->selectRaw('users.name as username, roles.id as role_id, users.*')
            // ->distinct()
            ->paginate(15);
        return view('User::index', compact('users'));
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

        if($this->User->setActive($id)){
            flash()->success('Activated user success');
        }else{
            flash()->error('Error occured');
        }

        return redirect()->route('user.list');
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

    public function getPhoto($id)
    {
        $user       = User::find($id);
        $pathPhoto  = storage_path() . '/' . $user->photo;

        return $this->Asset->downloadFile($pathPhoto);
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
        $user       = $User->find($id);
        $user->firstname    = $request->firstname;
        $user->lastname     = $request->lastname;
        $user->country_id   = $request->country_id;
        $user->address      = $request->address;
        $user->gender       = $request->gender;

        $user->save();

        flash()->success('Your data has been updated');

        return redirect()->route('user.profile', $id);
    }

}
