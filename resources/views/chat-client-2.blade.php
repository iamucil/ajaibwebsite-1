<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Ajaib - @yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/chat-style.css')}}"/>

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>


</head>
<body>


<div class="chat-title">
    <h3>Client Chat Feature</h3>
</div>
<div class="chat-content">

    <section class="module">

        <ol class="discussion">
            {{--<li class="self">--}}
                {{--<div class="avatar">--}}

                {{--</div>--}}
                {{--<div class="messages">--}}
                    {{--<time datetime="2009-11-13T20:14">37 mins</time>--}}
                {{--</div>--}}
            {{--</li>--}}
        </ol>

    </section>

</div>
<div class="chat-input">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <input type="text" id="chat_tf" class="form-control" placeholder="Apa yang bisa kami bantu ?">
                      <span class="input-group-btn">
                        <button id="send_bt" name="send" class="btn btn-default" type="button">SEND</button>
                      </span>
                </div><!-- /input-group -->

            </div>
        </div>

    </div>

</div>


<br/>

<div class="chat-logs">

</div>
<!-- View the Full Documentation. -->
<!-- Include the PubNub Library -->
<script src="https://cdn.pubnub.com/pubnub-dev.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script type='text/javascript' src="{{ secure_asset('/js/vendor/js-cookie/js.cookie.js') }}"></script>
<!-- Get Client Ip Address -->
<script type="text/javascript" src="https://l2.io/ip.js?var=myip"></script>

<!-- Instantiate PubNub -->
<script type="text/javascript">
    console.log(Cookies);
    var token = '';
    var senderId = '';
    var receiverId = '';
    var receiverChannel = 'operator';
    var user_auth = 'auth_key_user-olivia';

    GenerateToken("O9F72B");

    if (Cookies.get('geoip') === undefined) {
        Cookies.set('geoip', data, { expires: 1, path : '/'})
    }

    var PUBNUB_demo = PUBNUB.init({
        publish_key: 'pub-c-b9a7e925-c096-4eee-b72b-c68cba8e7ce2',
        subscribe_key: 'sub-c-946edbfa-ba70-11e5-85eb-02ee2ddab7fe',
        auth_key: user_auth,
        ssl : (('https:' == document.location.protocol) ? true : false),
        uuid: 'user-olivia'
    });

    PUBNUB_demo.subscribe({
        channel: 'ch-085432123456',
        presence: function(m){console.log(m)},
        message: function (m) {
            receiverId = m.sender_id;
            receiverChannel = m.sender_channel;
            $('.discussion').append('<li class="other"><div class="avatar"></div><div class="messages">'+ m.text +'<time datetime="2009-11-13T20:00">Timothy • 51 min</time></div></li>');
        }
    });

    function SetToken(token) {
        this.token = token;
    }

    function GenerateToken(vercode) {
        // get access token
        $.ajax({
            type: "POST",
            url: "https://ajaib-local/api/v1/oauth/grant_access",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: JSON.stringify({
                id:"1rtllily0HU1he171GhrybMFC0l0U7T0Ub0tfmEe",
                secret:"glp37di4iU360r70pTqwJhrybiadySgd7CXThmqG",
                code:vercode
            }),
            success: function (data, status, jqXHR) {
                // success handler
                token = data['access_token'];
                console.log(token);
            },
            error: function (jqXHR, status) {
                // error handler
                console.log(jqXHR);
                alert('fail' + status.code);
            }
        });
    }

    function GetToken() {
        return token;
    }


    // Get token
    $('#get_token').click(function () {

    });

    $(document).ready(function () {
        var now = new Date().today() + new Date().timeNow();
        var then = "31/12/2015 12:20:30";

        var ms = moment(now, "DD/MM/YYYY HH:mm:ss").diff(moment(then, "DD/MM/YYYY HH:mm:ss"));
        var d = moment.duration(ms);
        var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");
        console.log(s);
        console.log(moment(now, "DD/MM/YYYY HH:mm:ss").fromNow());
        PUBNUB_demo.history({
            channel : receiverChannel,
            count : 10,
            callback : function(m){
                RenderHistory(m);
            }
        });
    });

    function RenderHistory(m) {

    }

    // For todays date;
    Date.prototype.today = function () {
        return ((this.getDate() < 10) ? "0" : "") + this.getDate() + "/" + (((this.getMonth() + 1) < 10) ? "0" : "") + (this.getMonth() + 1) + "/" + this.getFullYear();
    }

    // For the time now
    Date.prototype.timeNow = function () {
        return ((this.getHours() < 10) ? "0" : "") + this.getHours() + ":" + ((this.getMinutes() < 10) ? "0" : "") + this.getMinutes() + ":" + ((this.getSeconds() < 10) ? "0" : "") + this.getSeconds();
    }

    $('#send_bt').click(function () {
        var text = $('#chat_tf').val();
        $('.discussion').append('<li class="self"><div class="avatar"></div><div class="messages"><p>'+text+'</p><time datetime="2009-11-13T20:14">37 mins</time></div></li>')
        var datetime = "LastSync: " + new Date().today() + " @ " + new Date().timeNow();
        PUBNUB_demo.publish({
            channel: receiverChannel,
            message: {
                "user_name": 'Olivia',
                "text": text,
                "ip": myip,
                "sender_id": '7',
                "sender_channel": 'ch-085432123456',
                "sender_auth": user_auth,
                "receiver_id": receiverId,
                "time": datetime
            },
            connect: function(){

            }
        });
        $('#chat_tf').val('');
    });

    $('#req_bt').click(function () {
        /**
         * generate random channel to create peer to peer like with operator
         */
        var generated_channel;

        // Publish a simple message to the demo_tutorial channel
        PUBNUB_demo.publish({
            "channel": "OPERATOR",
            message: {
                command: "new-chat",
                channel: "085227155554"
            },
            callback: function (m) {
                /**
                 * m = [1,"Sent","14498084926163911"], which means success
                 */
                console.log(m[0])
            }
        });
    });

    // Subscribe to the demo_tutorial channel
    //            PUBNUB_demo.subscribe({
    //                channel: 'agent',
    //                message: function(m){
    //                    $('.chat-logs').append(m.text+'<br />');
    //                }
    //            });
    function makeid() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 5; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    function InitUser(id) {
        // Send to API chat
        $.ajax({
            type: "POST",
            url: "https://ajaib-local/dashboard/chat/insertlog",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: JSON.stringify({
                sender_id: authUser.id,
                receiver_id: '7',
                message: 'test',
                ip_address: '10.10.10.1',
                useragent: 'firefox',
                read: '2016-01-11',
            }),
            beforeSend: function(xhr) {
                // Set the OAuth header from the session ID
                xhr.setRequestHeader("Authorization", 'Bearer ' + param['access_token']);
            },
            success: function (data, status, jqXHR) {
                // success handler
                // console.log(data);
                // alert("success");
                return data.status;
            },
            error: function (jqXHR, status) {
                // error handler
                // console.log(jqXHR);
                // alert('fail' + status.code);
                return status;
            }
        });
    }

</script>
</body>
</html>
