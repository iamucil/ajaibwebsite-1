<?php namespace App\Modules\Chat\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Chat\Models\Chat;
use GuzzleHttp\Psr7\Response;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use Illuminate\Http\Request;

use App\Repositories\ChatRepository;

class ChatController extends Controller
{

    protected $pubnub;

    public function __construct(/*ChatRepository $pubnub*/)
    {
//        $this->pubnub = $pubnub;
        // end user access
        $this->middleware(
            "oauth",
            [
                'only' =>
                    ['index', 'store']
            ]
        );
        $this->middleware(
            "oauth-user",
            [
                'only' =>
                    ['index', 'store']
            ]
        );
        // backend acces
        $this->middleware('auth',
            [
                'except' =>
                    ['index', 'store', 'insertLog', 'oauthUpdateChat']
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $ownerId = Authorizer::getResourceOwnerId();
        $chat = Chat::where('sender_id', $ownerId)
            ->orWhere('receiver_id', $ownerId)
            ->get(['id', 'sender_id', 'message', 'read', 'created_at'])
			->toArray();

        return response()->json(array(
            'status' => 200,
            'message' => 'success retrieve',
            'data' => $chat
        ), 200);
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
        $chat = Chat::create($param);
        if ($chat) {
            $data = array("chat_id" => $chat["id"]);
            return response()->json(array(
                'status' => 201,
                'message' => 'Success Saving',
                'data' => $data
            ), 201);
        } else {
            return response()->json(array(
                'status' => 500,
                'message' => 'Error Saving'
            ), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, Request $request)
    {
//        dd($request->has("method"));
//        $this->fnUpdateChat($id,$request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
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
        $return = [];

//        $ownerId =  Authorizer::getResourceOwnerId();

        if (is_null($request->sender_id)) {
            $return['status'] = 404;
            $return['message'] = 'not found';
        } else {
            $chat = Chat::create([
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'ip_address' => $request->ip_address,
                'useragent' => $request->useragent,
//                'read' => $request->read
            ]);

            if ($chat) {
                $return['status'] = 201;
                $return['message'] = 'success';
                $return['data'] = $chat;
            } else {
                $return['status'] = 500;
                $return['message'] = 'error';
            }
        }

        return response()->json($return);
        // get user login
        #echo var_dump(auth()->user());Up
    }

    public function chatLog($id, Response $response)
    {
        $chat = Chat::whereRaw('((sender_id = ' . auth()->user()->id . ' or receiver_id = ' . auth()->user()->id . ') and (sender_id = ' . $id . ' or receiver_id = ' . $id . '))')
            ->orderBy("id","asc")
            ->get();

        return response()->json(array(
            'status' => 200,
            'message' => 'success retrieve',
            'data' => $chat
        ), 200);
    }

    //===================== PUBNUB PROSES =====================
    /**
     * grant channel group to be accessed
     * @param Request $request
     * @return mixed
     */
    public function grantChannelGroup(Request $request)
    {
        // _set magic method (ex: role = users)
        $this->pubnub->channelGroup = "cg-" . $request->role;
        // _get magic method
        $response = $this->pubnub->grantChannelGroup;
        // $data['token'] = csrf_token();
        return $this->responseChannelRequest($response);
    }

    /**
     * add user channel to specific group channel
     * @param Request $request
     * @return mixed
     */
    public function addChannelToGroup(Request $request)
    {
        // _set magic method (ex: role = users)
        $this->pubnub->channelGroup = "cg-" . $request->role;
        // set static variabel channel on chat repository to $request->channel
        $this->pubnub->channel = $request->channel;
        // response action using _get magic method
        $response = $this->pubnub->groupAddChannel();
        return $this->responseChannelRequest($response);
    }

    /**
     * remove user channel from group channel
     * @param Request $request
     * @return mixed
     */
    public function removeChannelFromGroup(Request $request)
    {
        // _set magic method (ex: role = users)
        $this->pubnub->channelGroup = "cg-" . $request->role;
        // set static variabel channel on chat repository to $request->channel
        $this->pubnub->channel = $request->channel;
        // response action using _get magic method
        $response = $this->pubnub->groupRemoveChannel();
        return $this->responseChannelRequest($response);
    }

    /**
     * used to return response from pubnub proses
     * @param $response
     * @return mixed
     */
    private function responseChannelRequest($response)
    {
        $code = $response['status'];
        return response()->json(array(
            'status' => $code,
            'message' => $response['message'] . "-" . $response['service'],
            'error' => $response['error']
        ), $code);
    }
    //=================== END PUBNUB PROSES ===================

    //================== UPDATE FUNCTION ===================

    /**
     * Used for backend proses (need auth middleware)
     * @param $id, chats id
     * @param Request $request, data to used to update chats table
     */
    public function authUpdateChat(Request $request, Response $response)
    {
        $return = $this->fnUpdateChat($request->data);
        return response()->json($return);
    }

    /**
     * Used for api proses (need oauth & oauth-users middleware)
     * @param $id, chats id
     * @param Request $request, data to used to update chats table
     */
    public function oauthUpdateChat($id, Request $request)
    {
        $ownerId = Authorizer::getResourceOwnerId();
        if (!($ownerId === nullOrEmptyString())) {
            $this->fnUpdateChat($id, $request->data);
        } else {
            return response()->json(array(
                'status' => 404,
                'message' => 'Sorry, you don\'t have access'
            ), 404);
        }
    }

    /**
     * @param $id, id message to be updated
     * @param $data, used to update chats table
     * @return mixed
     */
    protected function fnUpdateChat($data)
    {
        // jika id dan data valid
        if ($this->valueValidation($data)) {

            // get chat message by id
            $chat = Chat::find($data["message_id"]);

            // chat message defined by id is null
            if (!$this->valueValidation($chat)) {
                return response()->json(array(
                    'status' => 404,
                    'message' => 'Data Not Found'
                ), 404);
            }

            // handle data->action
            // 1: update chat message when user serviced at the first time by operator
            // 2: just update whatever you need
            switch ($data['action']) {
                case "1":
                    $return = $this->updateProcess($chat, $data);
                    break;
                default:
                    if ($this->valueValidation($chat->receiver_id) && !($this->valueValidation($chat->read)) && $chat->receiver_id === auth()->user()->id) {
                        // sudah ada operator yang handle dan pesan belum dibaca
                        $return = $this->updateProcess($chat, $data, false);
                    } else if ($this->valueValidation($chat->receiver_id) && $chat->receiver_id != auth()->user()->id) {
                        // if operator trying to handle users that still serviced by other operator
                        // return to be parse as json
                        $return = array(
                            "status" => 500,
                            "message" => 'Handled by others'
                        );
                    } else if (!$this->valueValidation($chat->receiver_id)){
                        // belum ada yg handle
                        $return = $this->updateProcess($chat, $data, true);
                    } else if ($this->valueValidation($chat->receiver_id) && $chat->receiver_id === auth()->user()->id) {
                        // show notif, this is the owner
                        // return to be parse as json
                        $return = array(
                            "status" => 201,
                            "message" => 'You are the owner'
                        );
                    }
                    break;
            }

            // return update process
            return $return;
        } else {
            return array(
                "status" => 500,
                "message" => "Data is not valid"
            );
        }
    }

    /**
     * This function used for update dynamically in chats table
     * @param $chat, message object from chat table defined by id
     * @param $data, used to be parameter and value to be updated
     * @return array
     */
    protected function updateProcess($chat, $data, $isPublic)
    {
        /**
        // pop the action key from data array
        $data = array_except($data,'action');

        // set chat field and value to be updated
        foreach ($data as $key => $item) {
            $chat->$key = $item;
        }
        'chats.receiver_id ' . $user. ' and chats.read '.$seenStatus.' and date(chats.created_at) > date(now())-integer \'3\''
         */

        // update chat
        if ($isPublic) {
            $parameter = ["read"=>$data["read"],"receiver_id"=>auth()->user()->id];
        } else {
            $parameter = ["read"=>$data["read"]];
        }

        $success = $chat::where("receiver_id",$chat->receiver_id)
            ->where("sender_id",$chat->sender_id)
            ->whereRaw("date(chats.created_at) > date(now())-integer '".env("UNSEEN_MESSAGE")."'")
            ->update($parameter);

        if ($success) {
            $status = 201;
            $message = 'Success Updating';
        } else {
            $status = 500;
            $message = 'Error Updating';
        }

        return array(
            "status" => $status,
            "message" => $message
        );
    }

    //================ END UPDATE FUNCTION =================

    //================ HISTORY FUNCTION ================

    /**
     * fungsi utk retrieve public unseen chat di sisi backend
     * @param $id
     * @return mixed
     */
    public function authHistoryPublic($read) {
        $data = $this->fnHistory($read,"");
        // $data = $unseenPrivate->merge($unseenPublic);
        return response()->json(array(
            'status' => 200,
            'message' => 'success retrieve',
            'data' => $data
        ), 200);
    }

    /**
     * fungsi utk retrieve private unseen chat di sisi backend
     * @param $read
     * @return mixed
     */
    public function authHistoryPrivate($read) {
        $data = $this->fnHistory($read,auth()->user()->id);
        // $data = $unseenPrivate->merge($unseenPublic);
        return response()->json(array(
            'status' => 200,
            'message' => 'success retrieve',
            'data' => $data
        ), 200);
    }

    /**
     * FUngsi untuk menampilkan history notification where date between now and now - 2
     * @param $data
     * @param $read, true if seen message and false if unseen message
     * @return mixed
     */
    protected function fnHistory($read,$user) {
        if ($read == 1) {
            $seenStatus = 'is not null';
        } else {
            $seenStatus = 'is null';
        }
        if ($user == "") {
            $user = "is null";
        } else {
            $user = "= $user";
        }
        $chat = Chat::join('users','users.id','=','chats.sender_id')
            ->whereRaw('chats.receiver_id ' . $user. ' and chats.read '.$seenStatus." and date(chats.created_at) > date(now())-integer '".env("UNSEEN_MESSAGE")."'")
            ->orderBy('chats.sender_id', 'message_id','desc')
            ->selectRaw('
            distinct on (chats.sender_id) chats.sender_id,
            chats.id as message_id,
            chats.receiver_id,
            chats.message,
            chats.read,
            chats.created_at as time,
            users.id as user_id,
            users.channel as sender_channel,
            users.name as user_name,
            users.device_id,
            case
             when users.firstname is null
             then
               users.name
             else
               users.firstname
             end as user')
            ->get();
        // debug query purpose
//            ->toSql();
//        dd($chat);


        return $chat;
    }
    //============== END HISTORY FUNCTION ===============


    //================ CUSTOM FUNCTION =================
    /**
     * @param $data, to be validate is empty or not is null or not, etc
     * @return bool, true for valid and false for not valid
     */
    protected function valueValidation($data)
    {
        switch ($data) {
            case is_array($data):
                if (!empty($data)) {
                    return true;
                } else {
                    return false;
                }
                break;
            case is_object($data):
                $tmpData = (array)$data;
                if (!empty($tmpData)) {
                    return true;
                } else {
                    return false;
                }
                break;
            case is_string($data):
                if (!($data == isEmptyOrNullString())) {
                    return true;
                } else {
                    return false;
                }
                break;
            case is_int($data):
                if ($data > 0)
                    return true;
                else
                    return false;
                break;
            default:
                return false;
        }
    }

    //============== END CUSTOM FUNCTION ===============


}
