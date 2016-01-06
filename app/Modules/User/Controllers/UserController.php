<?php namespace App\Modules\User\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;

class UserController extends Controller {
    protected $User;

    function __construct(UserRepository $user)
    {
        $this->User     = $user;
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
        //
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
            $user->photo="http://api.randomuser.me/portraits/men/98.jpg";
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
        $userId = $request->user_id;
        $destinationPath = 'file/'.$this->directoryNaming($userId);

        if ($request->hasFile('image_file'))
        {
            $file 		= $request->file('image_file');
            $fileName 	= $file->getClientOriginalName();
            $fileExt 	= $file->getClientOriginalExtension();
            $fileRename = $this->fileNaming($fileName) . '.' . $fileExt;
            $resultUpload 	= $file->move($destinationPath, $fileRename);
            if ($resultUpload) {
                $user = User::find($userId);
                $user->photo = "/".$destinationPath."/".$fileRename;
                $resultUpdate=$user->save();
            }
        }

        if ($resultUpdate) {
            return \Response::json(['success' => true, "path" => $user->photo], 200);
        } else {
            return \Response::json('error', 400);
        }
    }

    public function directoryNaming($name)
    {
        return hash('sha256', $name);
    }

    public function fileNaming($name)
    {
        return hash('sha256', sha1(microtime()) . '.' . gethostname() . '.' . $name);
    }
}
