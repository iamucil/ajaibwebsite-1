/**
 * Created by yudha on 26/12/15.
 * below still hardcoded, and still dummy, notification has shown, minus: notification time and onclick remove/
 * change style to disable on notification icon
 */
<!-- Include the PubNub Library -->
var chatParameter = [];

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

// pubnub init properties
var authk = $('meta[name="csrf-token"]').attr('content');

var pubnub = '';

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
        //var chat = initChat();
        pubnub = initChat();

        InitOfflineUser();

        InitUnseenChat();

        // grant permission
        grantPermission();

        // subscribe on public channel
        if(public_channel !== undefined || public_channel != null){
            subscribe(public_channel);
        }

        // subscribe on private channel
        if(channel !== undefined || channel != null){
            subscribe(channel);
        }


        //$('.btn-ajaib').click(function () {
        //
        //});
        //
        //$('.chat-text').bind('keydown', function (event) {
        //    if ((event.keyCode || event.charCode) !== 13) return true;
        //    $('.chat-text').parent().siblings()[1].click();
        //    return false;
        //});
    }

});

//==================== init chat ====================
/**
 * Initializing chat feature
 * @constructor
 */
function initChat() {
    return PUBNUB.init({
        publish_key: pubnub_key,
        subscribe_key: subnub_key,
        secret_key: skey,
        auth_key: authk,
        ssl: (('https:' == document.location.protocol) ? true : false),
        uuid: roles + '-' + name
    });
}
//================== end of init chat ==================

//==================== init chat function ====================
/**
 *
 * @returns {{subscribe: subscribe, publish: publish}}
 */
var fnChat = function() {

    /**
     * Publish / send message PubNub function
     * @param pubnub, instance of pubnub object
     * @param channels, private channels, unique for each user AND public channels "ajaib", public for each user
     * @param message
     * @param callback
     */
    function publish(pubnub, channels, message,callback) {
        return pubnub.publish({
            channel:channels,
            message:message,
            callback:callback
        });
    };

    /**
     * Subscribe / receive message PubNub function
     * @param pubnub
     * @param channels
     * @param callback
     * @param connect
     * @param reconnect
     * @param error
     */
    function subscribe(channels, presence, message, callback, connect, reconnect, error) {
        pubnub.subscribe({
            channel     : channels,
            //heartbeat   : 10,
            presence    : presence,
            message     : message,
            callback    : callback,
            connect     : connect(pubnub,channels),
            reconnect   : reconnect,
            error       : error
        });
    };

    /**
     * Function to granting user using Pubnub Access Manager
     * @param channel, specified channel to grant
     * @param auth, specified auth to grant
     * @param read, subscribe access
     * @param write, publish access
     * @param ttl, time to live => 0, forefer / without limit
     */
    function grant(channel, auth, read, write, ttl) {
        // channel-pnpres used because we are using pubnub presence
        // grant pubnub access on global channel and private channel
        if(pubnub !== undefined || pubnub != null){
            // console.log(pubnub);
            // console.log(channel + ' -- ' + auth);
            // return false;
            if (channel === '') {
                pubnub.grant({
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
                pubnub.grant({
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
                pubnub.grant({
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
        } else {
            return false;
        }
    }

    //=========================== channel group purpose ==================//
    function GrantChannelGroup(channel) {
        pubnub.grant({
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
        pubnub.channel_group_add_channel({
            channel_group: "cg-" + channel,
            channel: authUser.channel,
            callback: function (m) {
                console.log("CG-Add: ", m);
            }
        });
    }

    function RemoveChannelGroupList(channel) {
        pubnub.channel_group_remove_channel({
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
    //======================== end ofchannel group purpose =================//

    function connect(channel) {
        pubnub.here_now({
            channel  : channel,
            callback : presence
        });
    }

    return {
        subscribe: function(channels, presence, message, callback, connect, reconnect, error) {
            subscribe(channels, presence, message, callback, connect, reconnect, error);
        },
        publish: function(pubnub, channels, message,callback) {
            publish(pubnub, channels, message,callback);
        },
        grant: function(channel, auth, read, write, ttl) {
            grant(channel, auth, read, write, ttl);
        },
        connect: function(channel) {
            connect(channel);
        },
        grantChannelGroup: function(channel) {
            GrantChannelGroup(channel);
        },
        addChannelToGroup: function(channel) {
            AddChannelToGroupChannel(channel);
        },
        removeChannelGroupList: function(channel) {
            RemoveChannelGroupList(channel);
        }
    }
};
//==================== init chat function ====================

//================== grant permission ==================
function grantPermission() {
    // operator grant access
    // grant global channel (without auth)
    // kenapa harus listen di channel operator?
    //fnChat().grant(pubnub,roles, '', true, true, 0);

    // grant operator private channel
    fnChat().grant(channel, authk, true, true, 0);

    // grant global access to users
    fnChat().grant(public_channel, "", true, true, 0);
}
//================== end of grant permission ==================

//===================== subscribe ======================
function subscribe(schannel) {
    fnChat().subscribe(
        schannel,
        presence,
        function(m){console.log(m)},
        subscribeCallback,
        function(){},
        function(){}
    );
}

function subscribeCallback(m) {
    //return function (m) {
    //console.log(m);return false;
    //TODO: subscribe chat -> don't forget to disable this debug when it goes online
    //logging('subscribe chat '+m);
    //logging(m);

    if (m.sender_id === authUser.id) {
        // operator it self
        //renderMessage('operator', m.message, m.time, m.user_name);
    } else {
        //GrantChannelGroup(pubnub,m.sender_channel);
        fnChat().grantChannelGroup(m.sender_channel);
        // get other operators that handle this users
        pubnub.channel_group_list_channels({
            channel_group: "cg-" + m.sender_channel,
            callback: function (cg) {
                var serviceSender = ServiceSenderDeviceId(m.sender_auth);
                serviceSender.success(function (success) {
                    m.device_id = success.data.device_id;
                });
                // cek channel group nya dia
                // jika sudah ada operator yang handle maka hanya munculkan notifikasi di operator yang handle

                //console.log("FRIENDLIST: ", cg);
                if (cg.channels.length > 1) {
                    //logging('impossible !');
                } else if (cg.channels.length === 0) {
                    // belum dihandle oleh operator lain
                    // broadcast ke semua operator

                    // notifications
                    $.playSound('audio/chat');
                    $('.edumix-msg-noft').html('*');

                    // Grant user access
                    fnChat().grant(m.sender_channel, m.sender_auth, true, true, 0);
                    //GrantChat(m.sender_channel, m.sender_auth, true, true, 0);

                    // if users have been chat with this operator, then just change the style
                    if ($('#ss_pb_' + m.user_name).length !== 0) {
                        // users has old notification then remove it
                        // alert($('#ss_'+ m.sender_id).length);
                        $('div#ss_pb_' + m.user_name).remove();
                    }

                    // Set parameter for the next usage of AppendChat function
                    SetParam(m.sender_id+".public", m);
                    if ($('#cn_pb_' + m.user_name) !== 0) {
                        $('#cn_pb_' + m.user_name).remove();
                    }

                    // create new notification
                    appendChatNotificationsPublic(m.user_name, m.sender_id, m.user, m.time);

                    // append chat to chat-conversation div
                    if (ElementIsExist('cb_' + m.user_name)) {
                        renderMessage('client', m.message, m.time, m.user_name);
                    }

                    showNotification(m, false);
                } else if (cg.channels.length === 1 && cg.channels[0] === authUser.channel) {
                    if ($('#ss_pr_' + m.user_name).length !== 0) {
                        // users has old notification then remove it
                        $('div#ss_pr_' + m.user_name).remove();
                    }

                    // operator itu sendiri
                    $.playSound('audio/chat');
                    $('.edumix-noft').html('*');

                    // Set parameter for the next usage of AppendChat function
                    SetParam(m.sender_id+".private", m);
                    if ($('#cn_pr_' + m.user_name) !== 0) {
                        $('#cn_pr_' + m.user_name).remove();
                    }

                    // create new notification
                    appendChatNotifications(m.user_name, m.sender_id, m.user, m.time);
                    //$('#chat-notification ul').prepend('<li class="edumix-sticky-title" id="cn_' + m.user_name + '"><a href="#" onclick="AppendChat(\'' + m.sender_id + '\')"><h3 class="text-black "> <i class="icon-warning"></i>' + m.user + '<span class="text-red fontello-record" ></span></h3><p class="text-black">' + parseTime(m.time) + '</p></a></li>');

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
    //}
}
//================== end of subscribe chat ==================

//================== element functions ==================
/**
 * fungsi untuk create chat notif element
 * @param user_name, phone number ex: 85227052004
 * @param sender_id, sender user id
 * @param user, firstname === '' ? user_name : firstname
 * @param time, 2016-
 */
function appendChatNotifications(user_name,sender_id,user,time) {
    $('#chat-notification ul').prepend('<li class="edumix-sticky-title" id="cn_pr_' + user_name + '"><a href="#" data="0-' + sender_id + '" onclick="AppendChat($(this))"><h3 class="text-black "> <i class="icon-warning"></i>' + user + '<span class="text-red fontello-record" ></span></h3><p class="text-black">' + parseTime(time) + '</p></a></li>');
}

function appendChatNotificationsPublic(user_name,sender_id,user,time) {
    $('#chat-notification-public ul').prepend('<li class="edumix-sticky-title" id="cn_pb_' + user_name + '"><a href="#" data="1-' + sender_id + '" onclick="AppendChat($(this))"><h3 class="text-black "> <i class="icon-warning"></i>' + user + '<span class="text-red fontello-record" ></span></h3><p class="text-black">' + parseTime(time) + '</p></a></li>');
}

function prependChatNotifications(user_name,sender_id,user,time) {
    $('#chat-notification').find(".slim-scroll").prepend('<div id="ss_pr_' + user_name + '"><i class="fontello-megaphone"></i><a href="#"><h3>' + user + ' <span class="text-green fontello-record"></span></h3><p>' + parseTime(time) + '</p></a></div>');
}

function prependChatNotificationsPublic(user_name,sender_id,user,time) {
    $('#chat-notification-public').find(".slim-scroll").prepend('<div id="ss_pb_' + user_name + '"><i class="fontello-megaphone"></i><a href="#"><h3>' + user + ' <span class="text-green fontello-record"></span></h3><p>' + parseTime(time) + '</p></a></div>');
}
//================ end element functions ================

//================== presence function ===================
// The State of User Occupancy has Changed.
// This Function is Called when Someone Joins/Leaves.
function presence(details) {
    var uuid = 'uuid' in details && (''+details.uuid).toLowerCase();
    if (uuid && uuid.split("-",1)[0]!=="operator") {
        AppendListUsers(details.data,details.action);
    }
}
//================== end presence function ===================


//==================== right bar list users ====================
/**
 * Fungsi yang digunakan untuk membuat list online/offline user pada sidebar di kanan aplikasi
 * sekali user terdaftar maka selamanya dia akan leave dari sebuah channel, karena kita btuh datanya
 * yang diperlukan hanyalah status online dan offline
 * @param m, object passing from pubnub state
 * @param action, join || leave || timeout
 */
function AppendListUsers(m, action) {
    var time = "";
    // show online users
    // here still has undefined error on console
    if(m !== undefined){
        if(m.time === undefined || m.time == null) {
        // if (typeof(m.time) === "undefined") {
            time = calendar(moment(getDate(), "YYYY-MM-DD HH:mm").toDate());
        } else {
            time = calendar(moment(m.time, "YYYY-MM-DD HH:mm").toDate());
            /*26/01/2016 07:00 am*/
        }

        if (!m.user) {
            m.user = m.user_name;
        }

        if (typeof m.user !== "undefined") {
            if (action === 'join' /*pertama kali user join di sebuah channel*/ || action === 'state-change' /*selanjutnya berubah dari join jadi state-change*/) {
                switch (m.status) {
                    case "isOnline":
                        ShowOnlineElement(m,time);
                        break;
                    case "isOffline":
                        ShowOfflineElement(m,time);
                        break;
                    default:
                        ShowOnlineElement(m,time);
                }
            } else {
                ShowOfflineElement(m,time);
            }
        }
    }

}

/**
 * Show list online users on the rightbar chat modules
 * @param m
 * @param time
 * @constructor
 */
function ShowOnlineElement(m, time) {
    // trapping if undefined id & channel
    if (m.sender_id === undefined) {
        m.sender_id = m.id;
    }

    if (m.sender_channel === undefined) {
        m.sender_channel = m.channel;
    }

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

    // if chat box already shown then give it active class
    toggleChatBox(m.user_name,"active");
}

/**
 * Show list offline users on the rightbar chat modules
 * @param m
 * @param time
 * @constructor
 */
function ShowOfflineElement(m, time) {
    // trapping if undefined id & channel
    if (m.id === undefined) {
        m.id = m.sender_id;
    }

    if (m.channel === undefined) {
        m.channel = m.sender_channel;
    }

    time = "";
    // jika user leave || timeout, cek apakah user tersebut ada di list online user?
    // jika ada maka hapus terlebih dahulu dari list online user
    if (ElementIsExist('online-user-' + m.user_name)) {
        $('#online-user-' + m.user_name).remove();
    }

    // jika belum ada di list offline user maka akan dibuat
    if (!ElementIsExist('offline-user-' + m.user_name)) {
        var elm = '<li><a class="list-offline"  href="#" cn-data="' + m.channel + '" data="' + m.id + '-' + m.user_name + '-' + m.user + '" id="offline-user-' + m.user_name + '"><img alt="" class="chat-pic chat-pic-gray" src="https://randomuser.me/api/portraits/thumb/men/30.jpg"><b>' + m.user + '</b><br>' + time + '</a></li>';
        $('.offline-list').append(elm);
    }

    // if chat box already shown then give it idle class
    toggleChatBox(m.user_name,"idle");
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
//==================== end right bar list users ====================


// togle chat box
function toggleChatBox(user_name,status) {
    if (ElementIsExist('cb_' + user_name)) {
        switch (status) {
            case "active":
                $("#cb_"+ user_name).removeClass("chat-idle");
                $("#cb_"+ user_name).addClass("chat-active");
                break;
            case "idle":
                $("#cb_"+ user_name).removeClass("chat-active");
                $("#cb_"+ user_name).addClass("chat-idle");
                break;
            default:
                ShowOnlineElement(m,time);
        }
    }
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
    console.log(obj);

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

            pubnub.publish({
                channel: obj.sender_channel,
                message: {
                    "message_id"    : data.data.id,
                    "user_name"     : firstname,
                    "message"       : text,
                    "ip"            : geoip.ip_address,
                    "sender_id"     : authUser.id,
                    "sender_channel": channel,
                    "receiver_id"   : obj.sender_id,
                    "time"          : datetime,
                    "role"          : roles,
                    "pn_gcm"        : {"data": {"title": 'Ajaib', "message": text}}
                },
                callback: function (m) {
                    //TODO: publish event -> don't forget to disable this debug when it goes online
                    //logging('publish event '+m);
                    //logging(m);
                }
            });

            // publish message to my channel
            // used to: if operator use difference device/browser
            pubnub.publish({
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


function InitOfflineUser() {
    // https://ajaib-local/dashboard/users/list
    $.ajax({
        type: "GET",
        url: "https://" + domain + "/dashboard/users/list",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        //beforeSend: function (xhr, settings){
        //   // check if url is accessible
        //   if( xhr.status != 200 ){
        //       return false;
        //   }
        //},
        success: function (data) {
            if (data.status === 200) {
                var items = data.data;

                // check who are users online on this channel
                pubnub.here_now( {
                    channel: public_channel,
                    callback: function(m){
                        // check every users who is online
                        for (var i = 0; i < items.length; i++) {

                            var contains = $.inArray(items[i].channel, m.uuids);

                            // if users has subscribed on this public channel then show it as online users
                            if (contains > -1) {
                                AppendListUsers(items[i], 'join');
                            } else {
                                AppendListUsers(items[i], 'leave');
                            }
                        }
                    }
                });
            }
        }
    });
}

function InitUnseenChat() {
    // render unseen public message
    RenderUnseenChat("https://" + domain + "/dashboard/chat/public/0","1");
    // render unseen private message
    RenderUnseenChat("https://" + domain + "/dashboard/chat/private/0","0");
}

/**
 * Used to render private (flag=>0) & public chat (flag=>1)
 * @param flag, flagging for public/private chat (1,0)
 * @constructor
 */
function RenderUnseenChat(url,flag) {
    $.ajax({
        type: "GET",
        url: url,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
            // sender_channel
            // sender_id
            // message_id
            // user_name
            // user
            // time
            // message
            var messages = data.data;
            if (messages.length > 0) {
                for (var i = 0; i < messages.length; i++) {
                    // created_at is a UTC format, so need to convert it to local timezone
                    messages[i].time = moment(moment.utc(messages[i].time).toDate()).format('YYYY-MM-DD HH:mm:ss');

                    if (flag === "1") {
                        SetParam(messages[i].user_id+".public", messages[i]);
                        // public
                        $('.edumix-msg-noft').html('*');
                        appendChatNotificationsPublic(messages[i].user_name,messages[i].user_id,messages[i].user,messages[i].time);
                    } else {
                        SetParam(messages[i].user_id+".private", messages[i]);
                        // private
                        $('.edumix-noft').html('*');
                        appendChatNotifications(messages[i].user_name,messages[i].user_id,messages[i].user,messages[i].time);
                    }
                }
            }

        }
    });
}


//=========================== custom function =======================//

/**
 *
 * @returns {string}
 */
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

/**
 *
 * @param param
 * @returns {*}
 * @constructor
 */
function InsertLogChat(param) {
    //var datetime = getDate();
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
            //read: datetime
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

//================ end chat ===============
function TriggerCloseChat() {
    $('.close-box').click(function () {
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
    fnChat().removeChannelGroupList(elm.siblings("a").attr("data-cn"));
    $("#"+elm.siblings("a").attr("data-target")).remove();
    elm.parent().remove();
}
//================ end chat ===============

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
        fnChat().grantChannelGroup(channel);

        // get other operators that handle this users
        pubnub.channel_group_list_channels({
            channel_group: "cg-" + channel,
            callback: function (m) {
                //console.log("FRIENDLIST: ", m);
                if (m.channels.length > 1) {
                    //logging('impossible !');
                } else if (m.channels.length === 0) {
                    // belum dihandle oleh operator lain
                    fnChat().addChannelToGroup(channel);
                    var obj = {
                        sender_id: arrData[0],
                        user_name: arrData[1],
                        user: arrData[2],
                        sender_channel: channel
                    };
                    SetParam(obj.sender_id+".private", obj);
                    GenerateChatBox(obj,0);
                } else if (m.channels.length === 1 && m.channels[0] === authUser.channel) {
                    // operator itu sendiri
                    var obj = {
                        sender_id: arrData[0],
                        user_name: arrData[1],
                        user: arrData[2],
                        sender_channel: channel
                    };
                    SetParam(obj.sender_id+".private", obj);
                    GenerateChatBox(obj,0);
                } else {
                    // operator yang melayani lebih dari satu
                    // cek channel groupnya
                    return alertify.error("Handled by others");
                }
            }
        });
    });
}

function ValidateValue(value) {
    if (value === 'undefined' || !value) {
        return false;
    } else {
        return true;
    }
}

function GenerateChatBox(obj,public) {
    // user_name : 085227052004
    // user : firstname is exist or phone number if firstname not exist
    // time : to parsing time
    // message : chat text
    // sender_id : user id
    if (public === 1) {
        var publish_object = obj.sender_id+".public";
    } else {
        var publish_object = obj.sender_id+".private";
    }
    // if chat box exist then leave it, if not exist then generate
    //cb_85227052004
    if (!ElementIsExist('cb_' + obj.user_name)) {
        if (ValidateValue(obj.time) && ValidateValue(obj.message)) {
            var chatText = '<p class="ajaib-client"><small>' + parseTime(obj.time) + '</small>' + obj.message + '</p>';
        } else {
            var chatText = '';
        }
        var elm = '<div id=\"cb_' + obj.user_name + '\"class="chat-list chat-active">' +
            '<div class="close-box">X</div>' +
            '<a class="chat-pop-over" data-cn="' + obj.sender_channel + '" data-title="' + obj.user + '" href="#">' + obj.user + '</a>' +
            '<div class="webui-popover-content">' +
            '<div class="chat-conversation slim-scroll-chat" id="cc_' + obj.user_name + '">' +
                //chatText +
            '</div>' +
            '<div class="textarea-nest">' +
            '<div class="form-group">' +
            '<textarea class="form-control chat-text" id="ct_' + obj.user_name + '" rows="3"></textarea>' +
            '</div>' +
            '<span class="btn btn-default btn-file-ajaib"><i class="fontello-attach"></i><input type="file" class="input-file"></span>' +
            '<button type="submit" class="btn pull-right btn-default btn-ajaib" onclick="publish(\'' + publish_object + '\')">Submit</button>' +
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
        $("#cb_" + obj.user_name).find("a").click();
        //logging($("#cc_"+obj.user_name));
        $("#cc_" + obj.user_name).animate({scrollTop: $("#cc_" + obj.user_name).prop("scrollHeight")}, 500);
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
function AppendChat(elm) {
    var attr = elm.attr("data").split("-");
    var senderId = attr[1];
    var is_public = attr[0];

    if (is_public === "1") {
        var obj = GetParam(senderId+".public");
        var data =
        {
            "data":{
                "message_id":obj.message_id,
                "receiver_id":"",
                "sender_id":obj.sender_id,
                "read":getDate(),
                "action":"0"
            }
        }
    } else {
        var obj = GetParam(senderId+".private");
        var data =
        {
            "data":{
                "message_id":obj.message_id,
                "receiver_id":authUser.id,
                "sender_id":obj.sender_id,
                "read":getDate(),
                "action":"0"
            }
        }
    }

    // update receiver id and read timestamp
    $.ajax({
        url: "https://" + domain + "/dashboard/chat/update",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        method:"POST",
        data: JSON.stringify(data),
        success: function (data) {
            console.log(data);
            if (data.status === 201) {
                fnChat().grantChannelGroup(obj.sender_channel);
                fnChat().addChannelToGroup(obj.sender_channel);

                // move to div slim scroll
                if (is_public === "1") {
                    // remove notification sign
                    $('.edumix-msg-noft').html('');

                    // remove old notification
                    $('#cn_pb_' + obj.user_name).remove();

                    // mark notification as read
                    prependChatNotificationsPublic(obj.user_name,obj.sender_id,obj.user,obj.time);
                } else {
                    // remove notification sign
                    $('.edumix-noft').html('');

                    // remove old notification
                    $('#cn_pr_' + obj.user_name).remove();

                    // mark notification as read
                    prependChatNotifications(obj.user_name,obj.sender_id,obj.user,obj.time);
                }

                if ($('#cb_' + obj.user_name).length === 0 || !$('#cb_' + obj.user_name)) {
                    GenerateChatBox(obj, parseInt(is_public));
                } else {
                    // if chat bottom with this id exist, then just append text
                    //$('#cb_'+obj.sender_id);

                    // blinking chat bottom
                    $('#cb_' + obj.user_name).addClass('');
                    $("#cb_" + obj.user_name).find("a").click();
                }
            } else {
                // move to div slim scroll
                if (is_public === "1") {
                    $('.edumix-msg-noft').html('');
                    // remove old notification
                    $('#cn_pb_' + obj.user_name).remove();
                } else {
                    $('.edumix-noft').html('');
                    // remove old notification
                    $('#cn_pr_' + obj.user_name).remove();
                }
                return alertify.error(data.message);
            }
        }
    });
}

/**
 * It used to reload webuipopover.js, because after render on the fly, the popup doesn't show
 */
function load_js() {
    $('.input-file').change(function(){
        alert($(this).val().split('\\'));
    });

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

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image_upload_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
//=========================== custom function =======================//

function ServiceSenderDeviceId(sender_auth) {
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
    pubnub.mobile_gw_provision ({
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

function SetParam(senderId, messageObject) {
    chatParameter[senderId] = messageObject;
}

function GetParam(senderId) {
    return chatParameter[senderId];
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
            appendElm += '<p class="ajaib-devider-chat"><span>' + splitMoment[0] + '</span></p>';

        } else if (splitMoment[0] !== timeSeparator) {
            // add separator
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