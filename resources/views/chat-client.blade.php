<!DOCTYPE html>
<html>
<head>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: top;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }

        .chat-logs {
            margin: 0;
            padding: 0;
            width: 100%;
            font-weight: 100;
            font-family: 'Lato';
            text-align: left;
            color: #880000;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Client Chat Feature</div>
        <label>GET TOKEN HERE</label>
        <div>
            <input type="text" id="vercode" placeholder="verification code" size="40" value=""/>
            <button id="get_token" name="get_token">TOKEN</button>
        </div>
        <div>
            <input type="text" id="access_token" placeholder="access token" size="49" value="" readonly/>
        </div>
        <br/>
        <label>LETS CHAT HERE</label>
        <div>
            <input type="text" id="chat_tf" placeholder="message" size="40" value=""/>
            <button id="send_bt" name="send" >SEND &nbsp;</button>
        </div>
        {{--<button id="req_bt" name="request">REQUEST CHAT</button>--}}
    </div>
</div>
<br/>

<div class="chat-logs">

</div>
<!-- View the Full Documentation. -->
<!-- Include the PubNub Library -->
<script src="https://cdn.pubnub.com/pubnub-dev.js"></script>

<!-- Get Client Ip Address -->
<script type="text/javascript" src="https://l2.io/ip.js?var=myip"></script>

<!-- Instantiate PubNub -->
<script type="text/javascript">
    // For todays date;
    Date.prototype.today = function () {
        return ((this.getDate() < 10)?"0":"") + this.getDate() +"/"+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +"/"+ this.getFullYear();
    }

    // For the time now
    Date.prototype.timeNow = function () {
        return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
    }

    // Get token
    $('#get_token').click(function () {
        var vercode = $('#vercode').val();
        // get access token
        $.ajax({
            type: "POST",
            url: "https://getajaib.local/api/v1/oauth/grant_access",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: JSON.stringify({
                id:"f3d259ddd3ed8ff3843839b",
                secret:"4c7f6f8fa93d59c45502c0ae8c4a95b",
                code:vercode
            }),
            success: function (data, status, jqXHR) {
                // success handler
                $("#access_token").val(data['access_token']);
            },
            error: function (jqXHR, status) {
                // error handler
                console.log(jqXHR);
                alert('fail' + status.code);
            }
        });
    });

    var PUBNUB_demo = PUBNUB.init({
        publish_key: 'pub-c-20764d9e-b436-4776-b03a-adcae96c2a6b',
        subscribe_key: 'sub-c-6bad3874-9efa-11e5-baf7-02ee2ddab7fe',
        ssl : (('https:' == document.location.protocol) ? true : false),
        uuid: 'user-yudha'
    });

    PUBNUB_demo.subscribe({
        channel:'ch-085227052004',
        message: function(m){
            console.log(m+'<br />');
        }
    });

    $('#send_bt').click(function () {
        var text = $('#chat_tf').val();
        var access_token = $('#access_token').val();
        var datetime = "LastSync: " + new Date().today() + " @ " + new Date().timeNow();
        PUBNUB_demo.publish({
            channel: 'OPERATOR',
            message: {
                "token":'token value',
                "user_channel": 'ch-085227052004',
                "text": text,
                "ip":myip,
                "sender_id":'085227052004',
                "receiver_id":'',
                "time":datetime
            }
        });

        // Send to API chat
        $.ajax({
            type: "POST",
            url: "https://getajaib.local/api/v1/chat",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: JSON.stringify({
                message:text,
                ipaddress:myip
            }),
            beforeSend: function(xhr) {
                // Set the OAuth header from the session ID
                xhr.setRequestHeader("Authorization", 'Bearer ' + access_token);
            },
            success: function (data, status, jqXHR) {
                // success handler
                console.log(data);
                alert("success");
            },
            error: function (jqXHR, status) {
                // error handler
                console.log(jqXHR);
                alert('fail' + status.code);
            }
        });
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
</script>
</body>
</html>
