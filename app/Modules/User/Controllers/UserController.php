<?php namespace App\Modules\User\Controllers;

use App\User;
use App\Role;
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
                    'message'=>'not found'
            ));
        }
        return response()->json(array(
                'status'=>200,
                'message'=>'success retrieve',
                'data'=>$user
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles      = Role::where('name', '<>', 'root')->lists('name', 'id');
        return view('User::create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $user= $this->User->createOrUpdateUser($request->all());
        if($user){
            return response()->json(array(
                'status'=>201,
                'message'=>'success saving'
            ));
        }else{
            return response()->json(array(
                'status'=>500,
                'message'=>'error saving'
            ));
        }
    }

    public function storeLocal(Request $request)
    {
        if (!$request->isMethod('post')) {
            \App::abort(403, 'Unauthorized action.');
        }else{
            $data           = $request->all();
            $validator      = Validator::make($data, [
                'role_id' => 'required',
                'firstname' => 'required',
                'name' => 'required',
                'email' => 'required|email|max:255',
                'password' => 'required|alpha_num',
                'retype-password' => 'required|same:password',
                'phone_number' => 'required|integer|regex:/^[0-9]{6,11}$/',
            ]);

            if($validator->fails()){
                flash()->error($validator->errors()->first());
                return redirect()->route('user.add')->withInput($request->except(['password', 'retype-password']))->withErrors($validator);
            }else{
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
    public function update(Request $request)
    {
        $ownerId =  Authorizer::getResourceOwnerId();
        $user=User::find($ownerId);

        if(is_null($user))
        {
            return response()->json(array(
                'status'=>404,
                'message'=>'not found'
            ));
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

        if(!is_null($request->file('image_file')))
        {
            $request->user_id = $ownerId;
            $processUpload = $this->Asset->uploadPhoto($request);
            if(!$processUpload)
            {
                return response()->json(array(
                    'status'=>500,
                    'message'=>'error upload photo'
                ));
            }
        }

        $success=$user->save();
        if(!$success)
        {
            return response()->json(array(
                    'status'=>500,
                    'message'=>'error updating'
            ));
        }
        return response()->json(array(
                'status'=>201,
                'message'=>'success updating'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize('destroy', $user);

        $user->delete();
        flash('Your data has been deleted');
        return redirect()->route('user.list');
    }

    public function getListUsers(Request $request)
    {
        $users       = User::orderBy('name', 'DESC')->paginate(15);
        return view('User::index', compact('users'));
    }

    public function showProfile($id)
    {
        $user       = User::findOrFail($id);
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
        $this->authorize('setStatus', $user);

        if($this->User->setActive($id)){
            flash()->success('Activated user success');
        }else{
            flash()->error('Error occured');
        }
        // $user       = $user->find($id);
        // $user->status   = true;

        // if($user->save()){
        //     flash()->success('Activated user success');
        // }else{
        //     flash()->error('Error occured');
        // }

        // $user->update([
        //     'status' => false
        // ]);

        // flash()->success('User activated');

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

}
