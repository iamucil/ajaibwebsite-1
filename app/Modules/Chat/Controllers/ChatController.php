<?php namespace App\Modules\Chat\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Chat\Models\Chat;
use GuzzleHttp\Psr7\Response;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use Illuminate\Http\Request;

class ChatController extends Controller {

    public function __construct()
    {
        $this->middleware("oauth", ['only' => ['index', 'store']]);
        $this->middleware("oauth-user", ['only' => ['index', 'store']]);
        $this->middleware('auth', ['except' => ['index', 'store', 'insertLog']]);
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
            ->orWhere('receiver_id',$ownerId)
            ->get();
        return response()->json(array(
            'status'=>200,
            'message'=>'success retrieve',
            'data'=>$chat
        ),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        echo 'create';
        echo '<script>console.log("test")</script>';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $param = array();
        $param['sender_id'] = Authorizer::getResourceOwnerId();
        foreach ($request->data as $key => $item) {
            $param[$key] = $item;
        }
        $chat=Chat::create($param);
        if($chat){
			$data = array("chat_id"=>$chat["id"]);
            return response()->json(array(
                'status'=>201,
                'message'=>'Success Saving',
                'data'=>$data
            ),201);
        }else{
            return response()->json(array(
                'status'=>500,
                'message'=>'Error Saving'
            ),500);
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
        $chat = Chat::find($id);
        if(is_null($chat))
        {
            return response()->json(array(
                'status'=>404,
                'message'=>'Data Not Found'
            ),404);
        }
        if (!$chat->receiver_id == nullOrEmptyString())
        {
            $chat->receiver_id = $request->receiver_id;
            $chat->read = $request->read;
            $success=$chat->save();
            if ($success)
            {
                $status = 201;
                $message = 'Success Updating';
            } else
            {
                $status = 500;
                $message = 'Error Updating';
            }

        } else
        {
            if ($chat->receiver_id != auth()->user()->id)
            {
                $status = 500;
                $message = 'Handled by others';
            } else
            {
                $status = 201;
                $message = 'You are the owner';
            }
        }

        return response()->json(array(
            'status'=>$status,
            'message'=>$message
        ),200);
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

    /**
     * Insert into chat logs from user dashboard (operator/admin)
     *
     * @param Request $request
     */
    public function insertLog(Request $request)
    {
        /**
         * sender id,
         * receiver id,
         * message,
         * ip address
         * useragent
         * read,
         * created at
         * updated at
         */
        $return 	= [];

//        $ownerId =  Authorizer::getResourceOwnerId();

        if(is_null($request->sender_id))
        {
            $return['status']= 404;
            $return['message']= 'not found';
        } else {
            $chat=Chat::create([
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'ip_address' => $request->ip_address,
                'useragent' => $request->useragent,
                'read' => $request->read
            ]);

            if($chat){
                $return['status'] = 201;
                $return['message'] = 'success';
                $return['data'] = $chat;
            }else{
                $return['status'] = 500;
                $return['message'] = 'error';
            }
        }

        return response()->json($return);
        // get user login
        #echo var_dump(auth()->user());
    }

    public function chatLog($id,Response $response)
    {
        $ownerId = auth()->user()->id;
        $chat= Chat::whereRaw('((sender_id = '.$ownerId.' or receiver_id = '.$ownerId.') and (sender_id = '.$id.' or receiver_id = '.$id.'))')
            ->get();
        return response()->json(array(
            'status'=>200,
            'message'=>'success retrieve',
            'data'=>$chat
        ),200);
    }

}
