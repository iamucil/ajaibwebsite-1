<?php namespace App\Modules\Chat\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Chat\Models\Chat;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use Illuminate\Http\Request;

class ChatController extends Controller {

    public function __construct()
    {
        $this->middleware("oauth", ['only' => ['index', 'store', 'insertLog']]);
        $this->middleware("oauth-user", ['only' => ['index', 'store']]);
        $this->middleware('auth', ['except' => ['index', 'store']]);
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
        ));
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

        $ownerId =  Authorizer::getResourceOwnerId();
        $user=User::find($ownerId);

        if(is_null($user))
        {
            $return['status']= 404;
            $return['message']= 'not found';
        } else {
            $id = DB::table('chats')->insertGetId(
                [
                    'sender_id' => $request->sender_id,
                    'receiver_id' => $request->receiver_id,
                    'message' => $request->message,
                    'ip_address' => $request->ip_address,
                    'useragent' => $request->useragent,
                    'read' => $request->read
                ]
            );
            if($id>0){
                $return['status'] = 201;
                $return['message'] = 'success';
            }else{
                $return['status'] = 500;
                $return['message'] = 'error';
            }
        }

//		$chat=Chat::create([
//				'sender_id' => $request->sender_id,
//				'receiver_id' => $request->receiver_id,
//				'message' => $request->message,
//				'ip_address' => $request->ip_address,
//				'useragent' => $request->useragent,
//				'read' => $request->read
////				'ceated_at' => $request->created_at,
////				'updated_at' => $request->updated_at
//		]);

        return response()->json($return);
        // get user login
        #echo var_dump(auth()->user());
    }

}
