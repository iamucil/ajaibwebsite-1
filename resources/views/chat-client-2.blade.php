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

<!-- Get Client Ip Address -->
<script type="text/javascript" src="https://l2.io/ip.js?var=myip"></script>

<!-- Instantiate PubNub -->
<script type="text/javascript">
    var senderId = '';
    var receiverId = '';
    var receiverChannel = 'operator';
    $(document).ready(function () {
        var now = new Date().today() + new Date().timeNow();
        var then = "31/12/2015 12:20:30";

        var ms = moment(now, "DD/MM/YYYY HH:mm:ss").diff(moment(then, "DD/MM/YYYY HH:mm:ss"));
        var d = moment.duration(ms);
        var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");
        console.log(s);
        console.log(moment(now, "DD/MM/YYYY HH:mm:ss").fromNow());
    });


    // For todays date;
    Date.prototype.today = function () {
        return ((this.getDate() < 10) ? "0" : "") + this.getDate() + "/" + (((this.getMonth() + 1) < 10) ? "0" : "") + (this.getMonth() + 1) + "/" + this.getFullYear();
    }

    // For the time now
    Date.prototype.timeNow = function () {
        return ((this.getHours() < 10) ? "0" : "") + this.getHours() + ":" + ((this.getMinutes() < 10) ? "0" : "") + this.getMinutes() + ":" + ((this.getSeconds() < 10) ? "0" : "") + this.getSeconds();
    }

    var PUBNUB_demo = PUBNUB.init({
        publish_key: 'pub-c-20764d9e-b436-4776-b03a-adcae96c2a6b',
        subscribe_key: 'sub-c-6bad3874-9efa-11e5-baf7-02ee2ddab7fe',
        ssl : (('https:' == document.location.protocol) ? true : false),
        uuid: 'user-olivia'
    });

    PUBNUB_demo.subscribe({
        channel: 'ch-085432123456',
        message: function (m) {
            receiverId = m.sender_id;
            receiverChannel = m.user_channel;
            $('.discussion').append('<li class="other"><div class="avatar"></div><div class="messages">'+ m.text +'<time datetime="2009-11-13T20:00">Timothy • 51 min</time></div></li>');
        }
    });

    $('#send_bt').click(function () {
        var text = $('#chat_tf').val();
        $('.discussion').append('<li class="self"><div class="avatar"></div><div class="messages"><p>'+text+'</p><time datetime="2009-11-13T20:14">37 mins</time></div></li>')
        var datetime = "LastSync: " + new Date().today() + " @ " + new Date().timeNow();
        PUBNUB_demo.publish({
            channel: receiverChannel,
            message: {
                "token": 'token value',
                "user_channel": 'ch-085432123456',
                "user_name": 'Olivia',
                "text": text,
                "ip": myip,
                "sender_id": '085432123456',
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
</script>
</body>
</html>
