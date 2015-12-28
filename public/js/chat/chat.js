/**
 * Created by yudha on 26/12/15.
 */
<!-- Include the PubNub Library -->

$(function() {
    var PUBNUB_demo = PUBNUB.init({
        publish_key: 'pub-c-20764d9e-b436-4776-b03a-adcae96c2a6b',
        subscribe_key: 'sub-c-6bad3874-9efa-11e5-baf7-02ee2ddab7fe',
        uuid: 'op-yudha'
    });

    $('#send_bt').click(function(){
        var text = $('#chat_tf').val();
        // Publish a simple message to the demo_tutorial channel
        PUBNUB_demo.publish({
            channel: 'OPERATOR',
            message: {"text":text}
        });

    });

    // Subscribe to the demo_tutorial channel
    PUBNUB_demo.subscribe({
        channel: 'OPERATOR',
        message: function(m){
            // user notification should be here
            if (!m.receiver_id || 0 === m.receiver_id.length) {
                // it means users are not serviced yet.
                // then push notifications to all operator
                // alert($('#notifications ul').length);
                $('#notifications ul').prepend('<li class="edumix-sticky-title"><a href="#" onclick="AppendChat('+m.sender_id+');"><h3 class="text-black "> <i class="icon-warning"></i>'+m.sender_id+'<span class="text-red fontello-record" ></span></h3><p class="text-black">1 minute ago</p></a></li>');
            }

            // $('.chat-logs').append(m.command+'<br />');
            console.log(m+'<br />');
        },
        /**
         * using callback
         connect: function(){console.log("Connected")},
         disconnect: function(){console.log("Disconnected")},
         reconnect: function(){console.log("Reconnected")},
         error: function(){console.log("Network Error")}
         */
    });

});

function AppendChat(senderId) {
    //alert($('.chat-bottom').find('div').attr('id',senderId).attr('id'));
    //if($('.chat-bottom').find('div').attr('id',senderId) === 'undefined') {
    $('.chat-bottom').prepend('<div class="chat-list chat-active">' +
        '<a class="chat-pop-over" data-title="Olivia Zalianti Putri" href="#">Olivia Zalianti Putri</a>' +
        '<div class="webui-popover-content">' +
        '<div class="chat-conversation">' +
        '<p>popover contenbnbnbnbt</p>' +
        '<p>popover contenbnbnbnbt</p>' +
        '<p>popover contenbnbnbnbt</p>' +
        '</div>' +
        '<div class="textarea-nest">' +
        '<div class="form-group">' +
        '<span class="fontello-attach"></span>' +
        '<span class="fontello-camera"></span>' +
        '</div>' +
        '<div class="form-group">' +
        '<textarea class="form-control" rows="3"></textarea>' +
        '</div>' +
        '<button type="submit" class="btn pull-right btn-default btn-ajaib">Submit</button>' +
        '</div>' +
            <!-- /input-group -->
        '</div>' +
        '</div>');
    //}

}