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
        <input type="text" id="chat_tf" value=""/>
        <button id="send_bt" name="send">SEND</button>
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
<script type="text/javascript" src="http://l2.io/ip.js?var=myip"></script>

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

    var PUBNUB_demo = PUBNUB.init({
        publish_key: 'pub-c-20764d9e-b436-4776-b03a-adcae96c2a6b',
        subscribe_key: 'sub-c-6bad3874-9efa-11e5-baf7-02ee2ddab7fe',
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
