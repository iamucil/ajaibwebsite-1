<?php
/**
 * Created by PhpStorm.
 * User: unyil
 * Date: 25/02/16
 * Time: 11:16
 */
namespace App\Repositories;

use Pubnub\Pubnub;
use Pubnub\PubnubPAM;

class ChatRepository
{
    protected $pubnub, $channelGroup, $channel;

    public function __construct()
    {
        $this->pubnub = new Pubnub(
        /**
        publish_key: pubnub_key,
        subscribe_key: subnub_key,
        secret_key: skey,
        auth_key: authk,
        ssl: (('https:' == document.location.protocol) ? true : false),
        uuid: roles + '-' + name
         */
            env("PAM_PUBNUB_KEY"),  ## PUBLISH_KEY
            env("PAM_SUBNUB_KEY"),  ## SUBSCRIBE_KEY
            env("PAM_SECRET_KEY"),      ## SECRET_KEY
            true    ## SSL_ON?
        );
    }

    public function __get($property)
    {
        switch ($property)
        {
            case 'grantChannelGroup':
                return $this->grantChannelGroup();
            case 'groupAddChannel':
                return $this->groupAddChannel();
            case 'groupRemoveChannel':
                return $this->groupRemoveChannel();
            //etc.
        }
    }

    public function __set($property, $value)
    {
        switch ($property)
        {
            case 'channelGroup':
                $this->channelGroup = $value;
                break;
            case 'channel':
                $this->channel = $value;
                break;
            //etc.
        }
    }

    protected function grantChannelGroup()
    {
        $this->pubnub->pamGrantChannelGroup(true, true, $this->channelGroup, null, 0);
    }

    /**
     * Pubnub feature that add a channel to a group channel
     * @return array
     */
    public function groupAddChannel()
    {
        return $this->pubnub->channelGroupAddChannel($this->channelGroup, [$this->channel]);
    }

    public function groupRemoveChannel()
    {
        return $this->pubnub->channelGroupRemoveChannel($this->channelGroup, [$this->channel]);
    }

    protected function groupChannelList()
    {
        $this->pubnub->channelGroupListChannels($this->channelGroup);
    }
}