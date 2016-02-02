/**
 * Created by yudha on 26/12/15.
 * below still hardcoded, and still dummy, notification has shown, minus: notification time and onclick remove/
 * change style to disable on notification icon
 */
<!-- Include the PubNub Library -->
var chatParameter = [];
var senderId = '';
var receiverId = '';
var chatFeature;

// user properties
var name='';
var firstname='';
var lastname='';
var roles='';
var channel='';
var phone='';
var status='';

// model/service properties
var sharedProperties={};
var logResponse='';

// pubnub init properties
var authk = $('meta[name="csrf-token"]').attr('content');

$(function () {
    // check if user has assigned to roles ??
    if(authRoles === undefined || authRoles.length == 0){
        alertify.set({ delay: 10000 });
        alertify.error("<strong>Roles </strong>for current user is undefined yet!! Please contact system admin");
    }else{
        // initialize user properties
        name        = authUser.name;
        firstname   = authUser.firstname;
        lastname    = authUser.lastname;
        roles       = authUser.roles[0].name;
        channel     = authUser.channel;
        phone       = authUser.phone_number;
        status      = authUser.status;

        // initialize chat featre using PubNub
        InitChat();

        // operator grant access
        // grant global channel (without auth)
        GrantChat(roles,'',true,true,0);
        // grant operator private channel
        GrantChat(channel,authk,true,true,0);
        // grant global access to users
        GrantChat("","",true,true,0);

        // listening to 'OPERATOR' channel for group and 'OP-USERNAME' channel for private
        SubscribeChat();
    }

});

/**
 * Initializing chat feature
 * @constructor
 */
function InitChat() {
    chatFeature = PUBNUB.init({
        publish_key: pubnub_key,
        subscribe_key: subnub_key,
        secret_key: skey,
        auth_key: authk,
        ssl : (('https:' == document.location.protocol) ? true : false),
        uuid: name
    });
}

/**
 * Function to granting user using Pubnub Access Manager
 * @param channel, specified channel to grant
 * @param auth, specified auth to grant
 * @param read, subscribe access
 * @param write, publish access
 * @param ttl, time to live => 0, forefer / without limit
 */
function GrantChat(channel, auth, read, write, ttl) {
    // channel-pnpres used because we are using pubnub presence
    // grant pubnub access on global channel and private channel
    if(channel === '') {
        chatFeature.grant({
            read: read,
            write: write,
            ttl: ttl,
            callback: function(m){
                //TODO: grant chat on subsribe key level -> don't forget to disable this debug when it goes online
                logging('grant chat on subsribe key level ');
                logging(m);
            },
            error: function(m){console.error(m)}
        });
    }  else if (auth === '') {
        // no need authentication
        chatFeature.grant({
            channel: channel+','+channel+'-pnpres',
            read: read,
            write: write,
            ttl: ttl,
            callback: function(m){
                //TODO: grant chat on channel level (without authentication) level -> don't forget to disable this debug when it goes online
                logging('grant chat on channel level (without authentication) ');
                logging(m);
            }
        });
    } else {
        // need authentication
        chatFeature.grant({
            channel: channel+','+channel+'-pnpres',
            auth_key: auth,
            read: read,
            write: write,
            ttl: ttl,
            callback: function(m){
                //TODO: grant chat on subsribe key level -> don't forget to disable this debug when it goes online
                logging('grant chat on user level (with authentication) ');
                logging(m);
            }
        });
    }
}

function RevokeChat(channel, auth) {
    pubnub.revoke({
        channel: channel,
        auth_key: auth,
        //callback: function(m){
        //    console.log(m);
        //}
    });
}

function getDate() {
    var d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();
    var hour = d.getHours();
    var minute = d.getMinutes();
    var second = d.getSeconds();

    var output = d.getFullYear() + '-' +
        ((''+month).length<2 ? '0' : '') + month + '-' +
        ((''+day).length<2 ? '0' : '') + day + ' ' +
        ((''+hour).length<2 ? '0' :'') + hour + ':' +
        ((''+minute).length<2 ? '0' :'') + minute + ':' +
        ((''+second).length<2 ? '0' :'') + second;
    return output;
}


function InsertLogChat(param) {
    var datetime=getDate();
    if (param.receiver_id==='') {
        param.receiver_id = authUser.id;
    }

    var domain = window.location.hostname;
    if (domain === 'localhost') {
        domain = 'ajaib-local';
    }

    if (param.message === '' || !param.message) {
        param.message = param.text;
    }


    // Send to API chat
    var ajaxResponse = $.ajax({
        type: "POST",
        url: "https://"+domain+"/dashboard/chat/insertlog",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        data: JSON.stringify({
            sender_id: param.sender_id,
            receiver_id: param.receiver_id,
            message: param.message,
            ip_address: param.ip,
            useragent: param.useragent,
            read: datetime
        }),
        beforeSend: function(xhr) {
            // Set the OAuth header from the session ID
            xhr.setRequestHeader("Authorization", 'Bearer ' + param['sender_auth']);
        }
    });

    //TODO: logresponse from insert chat  -> don't forget to disable this debug when it goes online
    logging('logresponse from insert chat ');
    logging(ajaxResponse);

    return ajaxResponse;
}

function SetSharedProperties(key,value) {
    sharedProperties[key] = value;
}

function GetSharedProperties(key) {
    return sharedProperties[key];
}

/**
 * Initializing for subscribe on group channel and private channel
 * @constructor
 */
function SubscribeChat() {
    // Subscribe/listen to the OPERATOR channel
    chatFeature.subscribe({
        channel: [roles,channel],
        //presence: function(m){console.log(m)},
        message: function (m) {
            //TODO: subscribe chat -> don't forget to disable this debug when it goes online
            logging('subscribe chat '+m);
            logging(m);

            // cek valid user based on insert log proses
            var logResponse = InsertLogChat(m);

            // valid user permit to chat
            logResponse.success(function(data){

                if (data.status===201) {
                    // notifications
                    sounds.play('audio/chat');
                    $('.edumix-noft').html('*');

                    // Grant user access
                    GrantChat(m.sender_channel, m.sender_auth, true, true, 0);

                    // handle times
                    var times = moment(m.time, "DD/MM/YYYY HH:mm:ss").fromNow();

                    // user notification should be here
                    if (!m.user_name || 0 === m.user_name.length) {
                        // it means users are not serviced yet.
                        // then push notifications to all operator
                        // if notification with this id doesn't exist then create it
                        //if ($('#cn_' + m.sender_id).length === 0) {
                        //console.log(m);

                        // Set parameter for the next usage of AppendChat function


                        // debugging to see the data
                        // console.log(m.user_name+'||'+JSON.stringify(GetParam(m.sender_id)));
                        //}
                        var serviced = false;
                    } else {
                        var serviced = true;
                        // users has been serviced
                        // if users have been chat with this operator, then just change the style
                        if ($('#ss_' + m.user_name).length !== 0) {
                            // users has old notification then remove it
                            // alert($('#ss_'+ m.sender_id).length);
                            $('div#ss_' + m.user_name).remove();

                            //ChatBoxToggle($('#cb_'+ m.sender_id));

                            //$('#cb_'+ m.sender_id).click(function(){
                            //    alert($(this).attr('class'));
                            //    if ($('#cb_'+ m.sender_id).hasClass('chat-blink')) {
                            //        $('#cb_'+ m.sender_id).removeClass('chat-blink');
                            //    }
                            //});
                        }
                    }
                    // Set parameter for the next usage of AppendChat function
                    SetParam(m.sender_id, m);
                    if ($('#cn_' + m.user_name) !== 0) {
                        $('#cn_' + m.user_name).remove();
                    }

                    // create new notification
                    $('#chat-notification ul').prepend('<li class="edumix-sticky-title" id="cn_' + m.user_name + '"><a href="#" onclick="AppendChat(\'' + m.sender_id + '\',' + serviced + ')"><h3 class="text-black "> <i class="icon-warning"></i>' + m.user + '<span class="text-red fontello-record" ></span></h3><p class="text-black">' + times + '</p></a></li>');

                    // append chat to chat-conversation div
                    var appendElm = '<p class="ajaib-client"><small>Sat 7:19 PM</small>'+m.message+'</p><br />';
                    $('.chat-conversation#cc_'+m.user_name).append(appendElm);

                    // $('.chat-logs').append(m.command+'<br />');
                    //console.log(m);
                } else {
                    logging("There are unauthenticated user's coming");
                }
            });
        },
        /**
         * using callback
         */
        connect: function () {
            console.log("Connected")
        },
        disconnect: function () {
            console.log("Disconnected")
        },
        reconnect: function () {
            console.log("Reconnected")
        },
        error: function () {
            console.log("Network Error")
        }
    });
}

function ChatBoxToggle(elm) {
    // if chat-box already shown then blink it
    if (elm.length !== 0) {
        elm.addClass('chat-blink');
    }
}

/**
 * Append chat to chat-conversation box on chat panel
 * @param senderId
 * @param serviced
 * @constructor
 */
function AppendChat(senderId,serviced) {
    $('.edumix-noft').html('');

    var obj = GetParam(senderId);

    // move to div slim scroll
    $('.slim-scroll').prepend('<div id="ss_' + obj.user_name + '"><i class="fontello-megaphone"></i><a href="#"><h3>' + obj.user + ' <span class="text-green fontello-record"></span></h3><p>Just Now !</p></a></div>');

    // remove old notification
    $('#cn_' + obj.user_name).remove();

    //alert($('.chat-bottom').find('div').attr('id',senderId).attr('id'));
    //if ($('div#cb_' + obj.sender_id).length === 0) {
    if ($('#cb_'+ obj.user_name).length === 0 || !$('#cb_'+ obj.user_name)) {
        $('.chat-bottom').append('<div id=\"cb_'+ obj.user_name + '\"class="chat-list chat-active">' +
            '<a class="chat-pop-over" data-title="' + obj.user + '" href="#">' + obj.user + '</a>' +
            '<div class="webui-popover-content">' +
            '<div class="chat-conversation" id="cc_'+obj.user_name+'">' +
            '<p class="ajaib-client"><small>Sat 7:19 PM</small>'+obj.message+'</p>' +
            '</div>' +
            '<div class="textarea-nest">' +
            '<div class="form-group">' +
            '<span class="fontello-attach"></span>' +
            '<span class="fontello-camera"></span>' +
            '</div>' +
            '<div class="form-group">' +
            '<textarea class="form-control chat-text" id="ct_'+obj.user_name+'" onkeyup="" rows="3"></textarea>' +
            '</div>' +
            '<button type="submit" class="btn pull-right btn-default btn-ajaib" onclick="publish(\'' + obj.sender_id + '\')">Submit</button>' +
            '</div>' +
            '</div>' +
            '</div>');
        // reload js
        load_js();
    } else {
        // if chat bottom with this id exist, then just append text
        //$('#cb_'+obj.sender_id);

        // blinking chat bottom
        $('#cb_'+ obj.user_name).addClass('');
    }
}

/**
 * It used to reload webuipopover.js, because after render on the fly, the popup doesn't show
 */
function load_js() {
    var head = document.getElementsByTagName('head')[0];
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://ajaib-local/js/jquery.webui-popover.js';
    head.appendChild(script);

    $('.chat-pop-over').webuiPopover({
        placement: 'auto',
        padding: false,
        width: '300',//can be set with  number
        //height:'300',//can be set with  number
        height: '400',//can be set with  number
        animation: '',
        offsetTop: -18,  // offset the top of the popover
        multi: true,//allow other popovers in page at same time
        dismissible: false, // if popover can be dismissed by  outside click or escape key
        closeable: true//display close button or not
    });
}

/**
 * function to publish message/chat text to users
 * @param senderId
 */
function publish(senderId) {
    // get user chat object
    var obj=GetParam(senderId);

    //TODO: sender object -> don't forget to disable this debug when it goes online
    logging('sender object '+obj);
    logging(obj);

    // get message to publish
    var text = $('.chat-text#ct_'+obj.user_name).val();
    var geoip   = JSON.parse(Cookies.get('geoip'));
    var param = {
        sender_id: authUser.id,
        receiver_id: obj.sender_id,
        message: text,
        ip: geoip.ip_address,
        useragent: navigator.userAgent,
        read: getDate(),
        sender_auth: obj.sender_auth
    };

    //TODO: parameter to insert chat log -> don't forget to disable this debug when it goes online
    logging('parameter to insert chat log '+param);
    logging(param);

    var logResponse = InsertLogChat(param);

    // valid user permit to chat
    logResponse.success(function(data) {

        if (data.status=='201') {
            // success then publish message
            var datetime = getDate();
            chatFeature.publish({
                channel: obj.sender_channel,
                message: {
                    "user_name": firstname,
                    "message": text,
                    "ip": geoip.ip_address,
                    "sender_id": authUser.id,
                    "sender_channel": channel,
                    "receiver_id": obj.sender_id,
                    "time": datetime
                },
                callback: function(m) {
                    //TODO: publish event -> don't forget to disable this debug when it goes online
                    logging('publish event '+m);
                    logging(m);

                    // push notification
                    //var pushParam = {
                    //    "channel" : obj.sender_channel,
                    //    "text" : text
                    //};
                    //pushNotification(pushParam);
                }
            });

            // append the text to conversation area
            var appendElm = '<p class="ajaib-operator"><small>Sat 7:19 PM</small>'+text+'</p><br />';
            $('.chat-conversation#cc_'+obj.user_name).append(appendElm);

            // set chat text to null
            $('.chat-text#ct_'+obj.user_name).val('')
        } else {
            // fail
            alertify.error("Gagal insert log chat. Periksa koneksi database!");
        }
    });
}

function whileTyping() {

}

// For todays date;
Date.prototype.today = function () {
    return ((this.getDate() < 10) ? "0" : "") + this.getDate() + "/" + (((this.getMonth() + 1) < 10) ? "0" : "") + (this.getMonth() + 1) + "/" + this.getFullYear();
}

// For the time now
Date.prototype.timeNow = function () {
    return ((this.getHours() < 10) ? "0" : "") + this.getHours() + ":" + ((this.getMinutes() < 10) ? "0" : "") + this.getMinutes() + ":" + ((this.getSeconds() < 10) ? "0" : "") + this.getSeconds();
}

function SetParam(senderId, messageObject) {
    chatParameter[senderId] = messageObject;
}

function GetParam(senderId) {
    return chatParameter[senderId];
}

function DiffTheTimes() {
    var now  = "04/09/2013 15:00:00";
    var then = "02/09/2013 14:20:30";

    var ms = moment(now,"DD/MM/YYYY HH:mm:ss").diff(moment(then,"DD/MM/YYYY HH:mm:ss"));
    var d = moment.duration(ms);
    var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");
}

function logging(m) {
    console.log(m);
}

/*
function pushNotification(obj) {
    chatFeature.publish({
        channel: obj.channel,
        message: {
            "aps": {
                "alert": obj.text,
                "badge": 9,
                "sound": "bingbong.aiff"
            },
            "acme 1": 42
        }
    });
}

function notification(count) {
    if (count === 0 || !count) {
        // empty notif
        $('.edumix-noft').html('');
    } else {
        $('.edumix-noft').html(count);
    }

}
*/
