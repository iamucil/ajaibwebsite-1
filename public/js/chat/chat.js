/**
 * Created by yudha on 26/12/15.
 * below still hardcoded, and still dummy, notification has shown, minus: notification time and onclick remove/
 * change style to disable on notification icon
 */
<!-- Include the PubNub Library -->
var chatParameter = [];
var SenderDeviceId = [];
var senderId = '';
var receiverId = '';
var chatFeature;

// user properties
var name = '';
var firstname = '';
var lastname = '';
var roles = '';
var channel = '';
var phone = '';
var status = '';
var domain = '';

var timeSeparator = '';

// model/service properties
var sharedProperties = {};
var logResponse = '';

// pubnub init properties
var authk = $('meta[name="csrf-token"]').attr('content');

$(function () {
    // check if user has assigned to roles ??
    if (authRoles === undefined || authRoles.length == 0) {
        alertify.set({delay: 10000});
        alertify.error("<strong>Roles </strong>for current user is undefined yet!! Please contact system admin");
    } else {

        // get domain from accessed application url
        domain = window.location.hostname;

        // testing purpose only
        if (domain === 'localhost') {
            domain = 'ajaib-local';
        }

        // Web Notification feature detection
        if (!window.Notification) {
            alert('Your browser does not support Web Notifications API.');
            return;
        }

        // Web Notification permission
        Notification.requestPermission(function () {
            if (Notification.permission !== 'granted') {
                alert('Please allow Web Notifications feature to use Ajaib notifications.');
                return;
            }
        });

        // initialize user properties
        name = authUser.name;
        firstname = authUser.firstname;
        lastname = authUser.lastname;
        roles = authUser.roles[0].name;
        channel = authUser.channel;
        phone = authUser.phone_number;
        status = authUser.status;

        // initialize chat featre using PubNub
        InitChat();

        // operator grant access
        // grant global channel (without auth)
        GrantChat(roles, '', true, true, 0);

        // grant operator private channel
        GrantChat(channel, authk, true, true, 0);

        // grant global access to users
        GrantChat("", "", true, true, 0);

        // listening to 'OPERATOR' channel for group and operator private's channel
        SubscribeChat();

        $('.btn-ajaib').click(function () {

        });

        $('.chat-text').bind('keydown', function (event) {
            if ((event.keyCode || event.charCode) !== 13) return true;
            $('.chat-text').parent().siblings()[1].click();
            return false;
        });

        // init offline user
        InitOfflineUser();
    }

});

function InitOfflineUser() {
    // https://ajaib-local/dashboard/users/list
    $.ajax({
        type: "GET",
        url: "https://" + domain + "/dashboard/users/list",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
            if (data.status === 200) {
                var items = data.data
                for (var i = 0; i < items.length; i++) {
                    AppendListUsers(items[i], 'offline');
                }
            }
        }
    });
}

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
        ssl: (('https:' == document.location.protocol) ? true : false),
        uuid: roles + '-' + name
    });
}

function UsersOnline() {
    chatFeature.here_now({
        channel: 'users',
        callback: function (m) {
            console.log(m)
        }
    });
}

//=========================== channel group purpose ==================//
function GrantChannelGroup(channel) {
    chatFeature.grant({
        channel_group: "cg-" + channel,
        //auth_key      : authk,
        channel: authUser.channel,
        read: true,
        write: true,
        manage: true,      // <-- Manage Permission TRUE
        callback: function (c) {
            console.log(c);
        },
        error: function (c) {
            displayCallback(c)
        }
    });
}

function AddChannelToGroupChannel(channel) {
    chatFeature.channel_group_add_channel({
        channel_group: "cg-" + channel,
        channel: authUser.channel,
        callback: function (m) {
            console.log("CG-Add: ", m);
        }
    });
}

function RemoveChannelGroupList(channel) {
    chatFeature.channel_group_remove_channel({
        channel: authUser.channel,
        channel_group: "cg-" + channel,
        callback: function (c) {
            displayCallback(c)
        },
        error: function (c) {
            displayCallback(c)
        }
    });
}

function ManipulateChannelGroupList(channel) {
    chatFeature.channel_group_list_channels({
        channel_group: "cg-" + channel,
        callback: function (m) {
            console.log("FRIENDLIST: ", m);

            var list = {};

            if (m.channels.length > 1) {
                list.status = '0';
                list.data = m;
                //logging('impossible !');
            } else if (m.channels.length === 0) {
                // belum dihandle oleh operator lain
                AddChannelToGroupChannel(channel);
                list.status = '1';
                list.data = m;
            } else {
                list.status = '0';
                list.data = m;
                //alertify.error("This user is chatting by other operator");
                //return false;
            }
            SetSharedProperties("cg-" + channel, list);
        }
        //error: function(){
        //displayCallback();
        //alertify.error("This user is chatting by other operator");
        //return false;
        //}
    });
}
//=========================== channel group purpose ==================//

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
    if (channel === '') {
        chatFeature.grant({
            read: read,
            write: write,
            ttl: ttl,
            callback: function (m) {
                //TODO: grant chat on subsribe key level -> don't forget to disable this debug when it goes online
                //logging('grant chat on subsribe key level ');
                //logging(m);
            },
            error: function (m) {
                console.error(m)
            }
        });
    } else if (auth === '') {
        // no need authentication
        chatFeature.grant({
            channel: channel + ',' + channel + '-pnpres',
            read: read,
            write: write,
            ttl: ttl,
            callback: function (m) {
                //TODO: grant chat on channel level (without authentication) level -> don't forget to disable this debug when it goes online
                //logging('grant chat on channel level (without authentication) ');
                //logging(m);
            }
        });
    } else {
        // need authentication
        chatFeature.grant({
            channel: channel + ',' + channel + '-pnpres',
            auth_key: auth,
            read: read,
            write: write,
            ttl: ttl,
            callback: function (m) {
                //TODO: grant chat on subsribe key level -> don't forget to disable this debug when it goes online
                //logging('grant chat on user level (with authentication) ');
                //logging(m);
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

    var month = d.getMonth() + 1;
    var day = d.getDate();
    var hour = d.getHours();
    var minute = d.getMinutes();
    var second = d.getSeconds();

    var output = d.getFullYear() + '-' +
        (('' + month).length < 2 ? '0' : '') + month + '-' +
        (('' + day).length < 2 ? '0' : '') + day + ' ' +
        (('' + hour).length < 2 ? '0' : '') + hour + ':' +
        (('' + minute).length < 2 ? '0' : '') + minute + ':' +
        (('' + second).length < 2 ? '0' : '') + second;
    return output;
}

function InsertLogChat(param) {
    var datetime = getDate();
    if (param.receiver_id === '') {
        param.receiver_id = authUser.id;
    }

    if (param.message === '' || !param.message) {
        param.message = param.text;
    }


    // Send to API chat
    var ajaxResponse = $.ajax({
        type: "POST",
        url: "https://" + domain + "/dashboard/chat/insertlog",
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
        beforeSend: function (xhr) {
            // Set the OAuth header from the session ID
            xhr.setRequestHeader("Authorization", 'Bearer ' + param['sender_auth']);
        }
    });

    //TODO: logresponse from insert chat  -> don't forget to disable this debug when it goes online
    //logging('logresponse from insert chat ');
    //logging(ajaxResponse);

    return ajaxResponse;
}

function SetSharedProperties(key, value) {
    sharedProperties[key] = value;
}

function GetSharedProperties(key) {
    return sharedProperties[key];
}

/**
 * Fungsi untuk retrieve state dari user
 * @param p, pubnub presence api
 */
function GenerateListUsers(p) {
    //logging(p);
    if (p.uuid.split('-')[0] !== 'operator' || p.uuid.split('-')[0] !== 'admin') {
        chatFeature.state({
            channel: p.uuid,
            uuid: p.uuid,
            callback: function (m) {
                if (!jQuery.isEmptyObject(m))
                // if not exist then create it
                    AppendListUsers(m, p.action);
            },
            error: function (m) {
                console.log(m)
            }
        });
    }
}

function TriggerCloseChat() {
    $('.close-box').click(function () {
        //alertify.confirm('Are you sure want to close this conversation?',RemoveChannelGroupList());
        //alertify.confirm('Are you sure want to close this conversation?',);
        var elm = $(this);
        return alertify.confirm("Are you sure want to close this conversation?", function (e) {
            if (e) {
                CloseChatBox(elm);
            } else {
                // nothing happend
            }
        });
    });
}

function CloseChatBox(elm) {
    RemoveChannelGroupList(elm.siblings("a").attr("data-cn"));
    elm.parent().remove();
}

/**
 * fungsi untuk handle ketika list online user diklik
 * @constructor
 */
function TriggerChatOnline() {
    // jika list online user diklik maka akan menampilkan chatbox dan history untuk user tersebut
    $('.list-online').click(function () {
        // user_name : 085227052004
        // user : firstname is exist or phone number if firstname not exist
        // sender_id : user id
        var arrData = $(this).attr('data').split('-');
        var channel = $(this).attr('cn-data');

        // grant this operator
        GrantChannelGroup(channel);

        // get other operators that handle this users
        chatFeature.channel_group_list_channels({
            channel_group: "cg-" + channel,
            callback: function (m) {
                console.log("FRIENDLIST: ", m);
                if (m.channels.length > 1) {
                    //logging('impossible !');
                } else if (m.channels.length === 0) {
                    // belum dihandle oleh operator lain
                    AddChannelToGroupChannel(channel);
                    var obj = {
                        sender_id: arrData[0],
                        user_name: arrData[1],
                        user: arrData[2],
                        sender_channel: channel
                    };
                    SetParam(obj.sender_id, obj);
                    GenerateChatBox(obj);
                } else if (m.channels.length === 1 && m.channels[0] === authUser.channel) {
                    // operator itu sendiri
                    var obj = {
                        sender_id: arrData[0],
                        user_name: arrData[1],
                        user: arrData[2],
                        sender_channel: channel
                    };
                    SetParam(obj.sender_id, obj);
                    GenerateChatBox(obj);
                } else {
                    // operator yang melayani lebih dari satu
                    // cek channel groupnya
                }
            }
        });

        // check if this user is not handled by other operator
        //chatFeature.where_now({
        //    channel  : channel,
        //    uuid: channel,
        //    callback : function(m){
        //        logging('here now');
        //        logging(m);
        //    }
        //});
    });
}

/**
 * Fungsi yang digunakan untuk membuat list online/offline user pada sidebar di kanan aplikasi
 * @param m, object passing from pubnub state
 * @param action, join || leave || timeout
 */
function AppendListUsers(m, action) {
    // show online users
    if (!m.time) {
        var time = '';
    } else {
        var time = calendar(moment(m.time, "YYYY-MM-DD HH:mm").toDate());
        /*26/01/2016 07:00 am*/
    }
    if (action === 'join' || action === 'state-change') {
        // jika user ini ada di list offline user, maka hapus terlebih dahulu elementnya
        if (ElementIsExist('offline-user-' + m.user_name)) {
            $('#offline-user-' + m.user_name).remove();
        }

        // pada saat join, jika element list online user untuk username ini tidak ada, maka akan dibuat
        if (!ElementIsExist('online-user-' + m.user_name)) {
            var elm = '<li class="li-class-online-user"><a href="#" class="list-online" cn-data="' + m.sender_channel + '" data="' + m.sender_id + '-' + m.user_name + '-' + m.user + '" id="online-user-' + m.user_name + '"><img alt="" class="chat-pic" src="https://randomuser.me/api/portraits/thumb/men/25.jpg"><b>' + m.user + '</b><br>' + time + '</a></li>';
            $('.online-list').append(elm);
        }

        // register list-online class to click event
        TriggerChatOnline(m);

    } else {
        // jika user leave || timeout, cek apakah user tersebut ada di list online user?
        // jika ada maka hapus terlebih dahulu dari list online user
        if (ElementIsExist('online-user-' + m.user_name)) {
            $('#online-user-' + m.user_name).remove();
        }

        // jika belum ada di list offline user maka akan dibuat
        if (!ElementIsExist('offline-user-' + m.user_name)) {
            var elm = '<li><a href="#" id="offline-user-' + m.user_name + '"><img alt="" class="chat-pic chat-pic-gray" src="https://randomuser.me/api/portraits/thumb/men/30.jpg"><b>' + m.user + '</b><br>' + time + '</a></li>';
            $('.offline-list').append(elm);
        }
    }
}

/**
 * Fungsi yang digunakan untuk mengetahui apakah sebuah element exist or not (by id)
 * @param idname, nama id dari element
 * @returns {boolean}, true : jika element exist || false : jika element not exist
 */
function ElementIsExist(idname) {
    if ($('#' + idname).length === 0 || !$('#' + idname)) {
        return false;
    } else {
        return true;
    }
}

/**
 * Initializing for subscribe on group channel and private channel
 * @constructor
 */
function SubscribeChat() {
    // Subscribe/listen to the OPERATOR channel
    chatFeature.subscribe({
        channel: ['users', channel],
        presence: function (p) {
            GenerateListUsers(p);
        },
        //presence: function(m){console.log(m)},
        message: function (m) {
            //TODO: subscribe chat -> don't forget to disable this debug when it goes online
            //logging('subscribe chat '+m);
            //logging(m);

            if (m.sender_id === authUser.id) {
                // operator it self
                //renderMessage('operator', m.message, m.time, m.user_name);
            } else {
                console.log("masuk sini");
                console.log(m);
                GrantChannelGroup(m.sender_channel);
                // get other operators that handle this users
                chatFeature.channel_group_list_channels({
                    channel_group: "cg-" + m.sender_channel,
                    callback: function (cg) {

                        // cek channel group nya dia
                        // jika sudah ada operator yang handle maka hanya munculkan notifikasi di operator yang handle

                        console.log("FRIENDLIST: ", cg);
                        if (cg.channels.length > 1) {
                            //logging('impossible !');
                        } else if (cg.channels.length === 0) {
                            // belum dihandle oleh operator lain
                            // broadcast ke semua operator
                            var serviceSender = ServiceSenderDeviceId(m.sender_auth);
                            serviceSender.success(function (success) {
                                m.device_id = success.data.device_id;
                            });

                            // notifications
                            $.playSound('audio/chat');
                            $('.edumix-noft').html('*');

                            // Grant user access
                            GrantChat(m.sender_channel, m.sender_auth, true, true, 0);

                            // if users have been chat with this operator, then just change the style
                            if ($('#ss_' + m.user_name).length !== 0) {
                                // users has old notification then remove it
                                // alert($('#ss_'+ m.sender_id).length);
                                $('div#ss_' + m.user_name).remove();
                            }

                            // Set parameter for the next usage of AppendChat function
                            SetParam(m.sender_id, m);
                            if ($('#cn_' + m.user_name) !== 0) {
                                $('#cn_' + m.user_name).remove();
                            }

                            // create new notification
                            $('#chat-notification ul').prepend('<li class="edumix-sticky-title" id="cn_' + m.user_name + '"><a href="#" onclick="AppendChat(\'' + m.sender_id + '\')"><h3 class="text-black "> <i class="icon-warning"></i>' + m.user + '<span class="text-red fontello-record" ></span></h3><p class="text-black">' + parseTime(m.time) + '</p></a></li>');

                            // append chat to chat-conversation div
                            if (ElementIsExist('cb_' + m.user_name)) {
                                renderMessage('client', m.message, m.time, m.user_name);
                            }

                            showNotification(m, false);
                        } else if (cg.channels.length === 1 && cg.channels[0] === authUser.channel) {
                            if ($('#ss_' + m.user_name).length !== 0) {
                                // users has old notification then remove it
                                $('div#ss_' + m.user_name).remove();
                            }

                            // operator itu sendiri
                            $.playSound('audio/chat');
                            $('.edumix-noft').html('*');
                            // Set parameter for the next usage of AppendChat function
                            SetParam(m.sender_id, m);
                            if ($('#cn_' + m.user_name) !== 0) {
                                $('#cn_' + m.user_name).remove();
                                $('#cn_' + m.user_name).remove();
                            }

                            // create new notification
                            $('#chat-notification ul').prepend('<li class="edumix-sticky-title" id="cn_' + m.user_name + '"><a href="#" onclick="AppendChat(\'' + m.sender_id + '\')"><h3 class="text-black "> <i class="icon-warning"></i>' + m.user + '<span class="text-red fontello-record" ></span></h3><p class="text-black">' + parseTime(m.time) + '</p></a></li>');

                            // append chat to chat-conversation div
                            if (ElementIsExist('cb_' + m.user_name)) {
                                renderMessage('client', m.message, m.time, m.user_name);
                            }

                            showNotification(m, true);
                        } else {
                            // operator yang melayani lebih dari satu
                            // cek channel groupnya

                        }
                    },
                    error: function (m) {//logging('error on channel group list');
                        console.log(m)
                    }
                });
            }
        },
        /**
         * using callback
         */
        connect: function () {
            console.log("Connected");
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

function ValidateValue(value) {
    if (value === 'undefined' || !value) {
        return false;
    } else {
        return true;
    }
}

function GenerateChatBox(obj) {
    // user_name : 085227052004
    // user : firstname is exist or phone number if firstname not exist
    // time : to parsing time
    // message : chat text
    // sender_id : user id

    // if chat box exist then leave it, if not exist then generate
    //cb_85227052004
    if (!ElementIsExist('cb_' + obj.user_name)) {
        if (ValidateValue(obj.time) && ValidateValue(obj.message)) {
            var chatText = '<p class="ajaib-client"><small>' + parseTime(obj.time) + '</small>' + obj.message + '</p>';
        } else {
            var chatText = '';
        }
        var elm = '<div id=\"cb_' + obj.user_name + '\"class="chat-list chat-active">' + '<div class="close-box">X</div>' +
            '<a class="chat-pop-over" data-cn="' + obj.sender_channel + '" data-title="' + obj.user + '" href="#">' + obj.user + '</a>' +
            '<div class="webui-popover-content">' +
            '<div class="chat-conversation" id="cc_' + obj.user_name + '">' +
                //chatText +
            '</div>' +
            '<div class="textarea-nest">' +
            '<div class="form-group">' +
            '<span class="fontello-attach"></span>' +
            '<span class="fontello-camera"></span>' +
            '</div>' +
            '<div class="form-group">' +
            '<textarea class="form-control chat-text" id="ct_' + obj.user_name + '" rows="3"></textarea>' +
            '</div>' +
            '<button type="submit" class="btn pull-right btn-default btn-ajaib" onclick="publish(\'' + obj.sender_id + '\')">Submit</button>' +
            '</div>' +
            '</div>' +
            '</div>';
        //onkeyup="whileTyping(\'' + obj.sender_channel + '\');" isTyping method add it to the textarea property
        $('.chat-bottom').append(elm);
        RenderHistory(obj, obj.user_name);
        // reload js
        load_js();

        //PUBNUB.bind( 'keyup', $("#ct_"+obj.user_name), function(e) {
        //
        //    (e.keyCode || e.charCode) === 13 && publish('\'' + obj.sender_id + '\'');
        //});
        TriggerCloseChat();
        //logging($("#cc_"+obj.user_name));
        $("#cc_" + obj.user_name).animate({scrollTop: $("#cc_" + obj.user_name).prop("scrollHeight")}, 1000);
    }
}


function RenderHistory(obj, username) {
    $.ajax({
        type: "GET",
        url: "https://" + domain + "/dashboard/chat/" + obj.sender_id,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
            if (data.status === 200) {
                var historyData = data.data;
                timeSeparator = '';
                for (i = 0; i < historyData.length; i++) {
                    // since timezone set to UTC in config/app.php then convert its create_at & updated_at to
                    // local time

                    var utcTime = moment.utc(historyData[i].created_at);
                    var localTime = moment(utcTime).toDate();

                    if (historyData[i].sender_id === authUser.id) {
                        // operator
                        renderMessage('operator', historyData[i].message, localTime, username);
                    } else {
                        // user
                        renderMessage('client', historyData[i].message, localTime, username);
                    }
                }
            } else {
                alert('can\'t retrieve chat history');
            }
        }
    });
}

/**
 * Append chat to chat-conversation box on chat panel
 * @param senderId
 * @constructor
 */
function AppendChat(senderId) {
    $('.edumix-noft').html('');

    var obj = GetParam(senderId);

    // update receiver id and read timestamp
    $.ajax({
        type: "PUT",
        url: "https://" + domain + "/dashboard/chat/" + obj.message_id,
        data: {
            "receiver_id": authUser.id,
            "read": getDate()
        },
        success: function (data) {
            console.log(data);
            if (data.status === 201) {
                GrantChannelGroup(obj.sender_channel);
                AddChannelToGroupChannel(obj.sender_channel);

                // move to div slim scroll
                $('.slim-scroll').prepend('<div id="ss_' + obj.user_name + '"><i class="fontello-megaphone"></i><a href="#"><h3>' + obj.user + ' <span class="text-green fontello-record"></span></h3><p>' + parseTime(obj.time) + '</p></a></div>');

                // remove old notification
                $('#cn_' + obj.user_name).remove();

                if ($('#cb_' + obj.user_name).length === 0 || !$('#cb_' + obj.user_name)) {
                    GenerateChatBox(obj);
                } else {
                    // if chat bottom with this id exist, then just append text
                    //$('#cb_'+obj.sender_id);

                    // blinking chat bottom
                    $('#cb_' + obj.user_name).addClass('');
                }
            } else {
                // remove old notification
                $('#cn_' + obj.user_name).remove();
            }
        }
    });
}

/**
 * It used to reload webuipopover.js, because after render on the fly, the popup doesn't show
 */
function load_js() {
    // file js to be reload on the page
    var jsToBeLoaded = 'https://' + domain + '/js/jquery.webui-popover.js';

    // remove webui-popover js if exist
    var head = document.getElementsByTagName('head')[0];
    var webui = $(head).find('script', ['src', jsToBeLoaded]);
    if (webui.length > 0) {
        webui.remove();
    }

    // add it back to the head
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = jsToBeLoaded;
    head.appendChild(script);

    $('.chat-pop-over').webuiPopover({
        placement: 'auto-top',
        padding: false,
        width: '300',//can be set with  number
        //height:'300',//can be set with  number
        height: '400',//can be set with  number
        animation: 'pop',
        offsetTop: -5,  // offset the top of the popover
        multi: true,//allow other popovers in page at same time
        dismissible: true, // if popover can be dismissed by  outside click or escape key
        closeable: true, //display close button or not
        onShow: function ($element) {
            lmnt = $element;
            //console.log(lmnt);
            $(lmnt).find('.chat-conversation').scrollTop(9999);
        }
    });
}

/**
 * function to publish message/chat text to users
 * @param senderId
 */
function publish(senderId) {
    // get user chat object
    var obj = GetParam(senderId);

    //TODO: sender object -> don't forget to disable this debug when it goes online
    //logging('sender object '+obj);
    //logging(obj);

    // adding device
    addDeviceToChannel(obj);

    // get message to publish
    var text = $('.chat-text#ct_' + obj.user_name).val();
    if (typeof Cookies.get('geoip') !== "undefined") {
        var geoip = JSON.parse(Cookies.get('geoip'));
        var ip = geoip.ip_address;
    } else {
        var ip = "null";
    }

    var param = {
        sender_id: authUser.id,
        receiver_id: obj.sender_id,
        message: text,
        ip: ip,
        useragent: navigator.userAgent,
        read: getDate(),
        sender_auth: obj.sender_auth
    };

    //TODO: parameter to insert chat log -> don't forget to disable this debug when it goes online
    //logging('parameter to insert chat log '+param);
    //logging(param);

    var logResponse = InsertLogChat(param);

    // valid user permit to chat
    logResponse.success(function (data) {

        if (data.status == '201') {
            // success then publish message
            var datetime = getDate();

            logging({
                channel: obj.sender_channel,
                "user_name": firstname,
                "message": text,
                "ip": geoip.ip_address,
                "sender_id": authUser.id,
                "sender_channel": channel,
                "receiver_id": obj.sender_id,
                "time": datetime,
                "pn_gcm": {"data": {"title": 'Ajaib', "message": text}}
            });

            chatFeature.publish({
                channel: obj.sender_channel,
                message: {
                    "user_name": firstname,
                    "message": text,
                    "ip": geoip.ip_address,
                    "sender_id": authUser.id,
                    "sender_channel": channel,
                    "receiver_id": obj.sender_id,
                    "time": datetime,
                    "pn_gcm": {"data": {"title": 'Ajaib', "message": text}}
                },
                callback: function (m) {
                    //TODO: publish event -> don't forget to disable this debug when it goes online
                    //logging('publish event '+m);
                    //logging(m);
                }
            });

            // publish message to my channel
            // used to: if operator use difference device/browser
            chatFeature.publish({
                channel: authUser.channel,
                message: {
                    "user_name": obj.user_name,
                    "sender_id": authUser.id,
                    "message": text,
                    "time": datetime
                },
                callback: function (m) {
                    //TODO: publish event -> don't forget to disable this debug when it goes online
                    //logging('publish event '+m);
                    //logging(m);
                }
            });

            renderMessage('operator', text, datetime, obj.user_name);

            // append the text to conversation area
            //var appendElm = '<p class="ajaib-operator"><small>'+parseTime(datetime)+'</small>'+text+'</p><br />';
            //$('.chat-conversation#cc_'+obj.user_name).append(appendElm);

            // set chat text to null
            $('.chat-text#ct_' + obj.user_name).val('');
        } else {
            // fail
            alertify.error("Gagal insert log chat. Periksa koneksi database!");
        }
    });
}


function ServiceSenderDeviceId(sender_auth) {
    var domain = window.location.hostname;
    // Send to API chat
    var ajaxResponse = $.ajax({
        type: "GET",
        url: "https://" + domain + "/api/v1/user",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        beforeSend: function (xhr) {
            // Set the OAuth header from the session ID
            xhr.setRequestHeader("Authorization", 'Bearer ' + sender_auth);
        }
    });

    return ajaxResponse;
}

function addDeviceToChannel(obj) {
    chatFeature.mobile_gw_provision ({
        device_id: obj.device_id, // Reg ID you got on your device
        channel: obj.sender_channel,
        op: 'add',
        gw_type: 'gcm',
        error: function (msg) {
            console.log(msg);
        },
        callback: function (msg) {
            console.log(msg);
        }
    });
}

function whileTyping(ch) {
    chatFeature.state({
        channel: ch,
        uuid: roles + '-' + name,
        state: {"action": "isTyping"},
        callback: function (m) {
            console.log(JSON.stringify(m))
        }
    });
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
    var now = "04/09/2013 15:00:00";
    var then = "02/09/2013 14:20:30";

    var ms = moment(now, "DD/MM/YYYY HH:mm:ss").diff(moment(then, "DD/MM/YYYY HH:mm:ss"));
    var d = moment.duration(ms);
    var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");
}

function logging(m) {
    console.log(m);
}

function showNotification(data, handled) {
    if (handled && data.receiver_id === authUser.id) {
        // inginnya dimunculkan hanya di operator yang menyervis si user
        var ms = 5000; // close notification after 30sec
        var notification = new Notification(data.message || 'Ajaib!', {
            body: 'From: ' + data.user,
            tag: data.sender_channel,
            icon: 'img/icon-ajaib-80.png'
        });
        notification.onshow = function () {
            setTimeout(notification.close, ms);
        };
    } else {
        // inginnya dimunculkan hanya di operator yang menyervis si user
        var ms = 5000; // close notification after 30sec
        var notification = new Notification(data.message || 'Ajaib!', {
            body: 'From: ' + data.user,
            tag: data.sender_channel,
            icon: 'img/icon-ajaib-80.png'
        });
        notification.onshow = function () {
            setTimeout(notification.close, ms);
        };
    }
}

function calendar(time) {
    return moment(time).calendar(null, {
        lastDay: '[Yesterday] h:hh a',
        sameDay: '[Today] LT',
        lastWeek: 'dddd h:hh a',
        sameElse: 'DD/MM/YY h:hh a'
    });
}

function parseTime(datetime) {
    // get local time
    var localTime = moment(datetime, "YYYY-MM-DD HH:mm").toDate();

    // whatsapp wannabe
    return calendar(moment(localTime));
    /*26/01/2016 07:00 am*/
}

function renderMessage(actor, text, time, user) {
    //var timeSeparator = '';

    // time to parse
    var parsedTime = '';

    // get local time
    //var localTime  = moment(time,       "YYYY-MM-DD HH:mm").toDate();

    // whatsapp wannabe
    var momentTime = calendar(moment(time));
    /*26/01/2016 07:00 am*/
    var splitMoment = momentTime.split(' ');
    /*['26/01/2016','07:00','am']*/
    if (splitMoment.length > 2) {
        parsedTime = splitMoment[1] + ' ' + splitMoment[2];
        var appendElm = '';
        if (timeSeparator === '') {
            // add separator for the first time
            //elm.append('<li class="history-chat-time"><span>'+splitMoment[0]+'</span></li>');
            //logging(splitMoment[0]);
            appendElm += '<p class="ajaib-devider-chat"><span>' + splitMoment[0] + '</span></p>';

        } else if (splitMoment[0] !== timeSeparator) {
            // add separator
            //elm.append('<li class="history-chat-time"><span>'+splitMoment[0]+'</span></li>');
            //logging(splitMoment[0]);
            appendElm += '<p class="ajaib-devider-chat"><span>' + splitMoment[0] + '</span></p>';
        }
        appendElm += '<p class="ajaib-' + actor + '"><small>' + parsedTime + '</small>' + text + '</p><br />';
        timeSeparator = splitMoment[0];
    }

    $('.chat-conversation#cc_' + user).append(appendElm);
    $('.chat-conversation#cc_' + user).scrollTop(9999);
}

function displayCallback(m, e, c, d, f) {
    //logging(JSON.stringify(m, null, 4));
}