<!-- Chat bottom -->
<div class="chat-bottom" ng-controller="ChatbarController">
</div>
<!-- Chat bottom -->

@section('script-lib')
    @parent
    <!-- Include the PubNub Library -->
    <script language="javascript" src="https://cdn.pubnub.com/pubnub-3.10.2.min.js"></script>
    <!-- Include the Chat functions -->
    <script language="javascript" src="{{secure_asset('/js/chat/chat.js')}}"></script>
    <script language="javascript" src="{{secure_asset('/js/jquery.playSound.js')}}"></script>
    <script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.0/moment.min.js"></script>

    {{-- <script type="text/javascript" src="https://l2.io/ip.js?var=myip"></script> --}}
@endsection
@section('script-bottom')
    @parent
    <!-- embedded javascript goes here -->
@endsection