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
		$this->User 	= $user;
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
		if(!is_null($request->photo))
		{
            $user->gender=$request->photo;
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
	public function destroy($id)
	{
		//
	}

}
