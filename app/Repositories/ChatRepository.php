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
    protected $pubnub;
    protected $channelGroup;

    public function __construct()
    {
        $this->pubnub = new Pubnub(
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
            //etc.
        }
    }

    protected function grantChannelGroup()
    {
        $this->pubnub->pamGrantChannelGroup(true, true, $this->channelGroup, null, 0);
    }

    protected function revokeChannelGroup()
    {

    }

    protected function groupChannelList()
    {
        $this->pubnub->channelGroupListChannels($this->channelGroup);
    }
}