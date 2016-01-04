<!-- Chat bottom -->
<div class="chat-bottom">
    {{--<div class="chat-list chat-active">--}}
        {{--<a class="chat-pop-over" data-title="Olivia Zalianti Putri" href="#">Olivia Zalianti Putri</a>--}}
        {{--<div class="webui-popover-content">--}}
            {{--<div class="chat-conversation">--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--</div>--}}
            {{--<div class="textarea-nest">--}}
                {{--<div class="form-group">--}}
                    {{--<span class="fontello-attach"></span>--}}
                    {{--<span class="fontello-camera"></span>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<textarea class="form-control" rows="3"></textarea>--}}
                {{--</div>--}}
                  {{--<button type="submit" class="btn pull-right btn-default btn-ajaib">Submit</button>--}}
            {{--</div>--}}
            {{--<!-- /input-group -->--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="chat-list">Agus</div>--}}
    {{--<div class="chat-list">Widi</div>--}}
    {{--<div class="chat-list chat-active">--}}
        {{--<a class="chat-pop-over" data-title="Olivia Zalianti Putri" href="#">Olivia Zalianti Putri</a>--}}
        {{--<div class="webui-popover-content">--}}
            {{--<div class="chat-conversation">--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--</div>--}}
            {{--<div class="textarea-nest">--}}
                {{--<div class="form-group">--}}
                    {{--<span class="fontello-attach"></span>--}}
                    {{--<span class="fontello-camera"></span>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<textarea class="form-control" rows="3"></textarea>--}}
                {{--</div>--}}
                  {{--<button type="submit" class="btn pull-right btn-default btn-ajaib">Submit</button>--}}
            {{--</div>--}}
            {{--<!-- /input-group -->--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="chat-list chat-active">Anger</div>--}}
    {{--<div class="chat-list">Themes</div>--}}
    {{--<div class="chat-list">Themes</div>--}}
    {{--<div class="chat-list">Themes</div>--}}
    {{--<div class="chat-list">Themes</div>--}}
    {{--<div class="chat-list">Themes</div>--}}
    {{--<div class="chat-list">Themes</div>--}}
    {{--<div class="chat-list">Themes</div>--}}

    {{--<div class="chat-list">Themes</div>--}}
    {{--<div class="chat-list">Themes</div>--}}
    {{--<div class="chat-list chat-active">--}}
        {{--<a class="chat-pop-over" data-title="Olivia Zalianti Putri" href="#">Oliva</a>--}}
        {{--<div class="webui-popover-content">--}}
            {{--<div class="chat-conversation">--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--<p>popover contenbnbnbnbt</p>--}}
            {{--</div>--}}
            {{--<div class="textarea-nest">--}}
                {{--<div class="form-group">--}}
                    {{--<span class="fontello-attach"></span>--}}
                    {{--<span class="fontello-camera"></span>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<textarea class="form-control" rows="3"></textarea>--}}
                {{--</div>--}}
                  {{--<button type="submit" class="btn pull-right btn-default btn-ajaib">Submit</button>--}}
            {{--</div>--}}
            {{--<!-- /input-group -->--}}
        {{--</div>--}}
    {{--</div>--}}
</div>
<!-- Chat bottom -->

@section('script-lib')
    @parent
    <!-- Include the PubNub Library -->
    <script language="JavaScript" src="https://cdn.pubnub.com/pubnub-dev.js"></script>
    <!-- Include the Chat functions -->
    <script language="JavaScript" src="{{asset('js/chat/chat.js')}}"></script>

    <script language="JavaScript" src="{{asset('js/moment.min.js')}}"></script>

    <script type="text/javascript" src="http://l2.io/ip.js?var=myip"></script>
@endsection
@section('script-bottom')
    @parent
    <!-- embedded javascript goes here -->
@endsection