<?php namespace App\Modules\Chat\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Chat\Models\Chat;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use Illuminate\Http\Request;

class ChatController extends Controller {

	public function __construct()
	{
		$this->middleware("oauth");
		$this->middleware("oauth-user");
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$ownerId =  Authorizer::getResourceOwnerId();
		$chat= Chat::where('sender_id',$ownerId)
				->orwhere('receiver_id',$ownerId)
				->get();
		return response()->json(array(
				'status'=>200,
				'message'=>'success retrieve',
				'data'=>$chat
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
		$chat=Chat::create([
				'sender_id' => Authorizer::getResourceOwnerId(),
				'message' => $request->message,
				'ip_address' => $request->ipaddress
		]);
		if($chat){
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
	public function update($id, Request $request)
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

}
