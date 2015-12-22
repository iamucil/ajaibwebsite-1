<?php namespace App\Modules\Chat\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Chat\Models\Chat;

use Illuminate\Http\Request;

class ChatController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$chat=Chat::all();
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
				'sender_id' => $request->senderid,
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
		$chat=Chat::find($id);
		if(is_null($chat))
		{
			return response()->json(array(
					'status'=>404,
					'message'=>'not found'
			));
		}
		return response()->json(array(
				'status'=>200,
				'message'=>'success retrieve',
				'data'=>$chat
		));
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
		$chat=Chat::find($id);
		if(is_null($chat))
		{
			return response()->json(array(
					'status'=>404,
					'message'=>'not found'
			));
		}

		if(!is_null($request->read))
		{
			$chat->read=$request->read;
		}
		if(!is_null($request->receiverid))
		{
			$chat->receiver_id=$request->receiverid;
		}
		$success=$chat->save();
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
		$chat=Chat::find($id);
		if(is_null($chat))
		{
			return response()->json(array(
					'status'=>404,
					'message'=>'not found'
			));
		}

		$success=$chat->delete();
		if(!$success)
		{
			return response()->json(array(
					'status'=>500,
					'message'=>'error deleting'
			));
		}

		return response()->json(array(
				'status'=>200,
				'message'=>'success deleting'
		));
	}

}
