<div class="chat-bottom" ng-controller="ChatbarController">
    <div class="chat-list">
        <div class="close-box"></div>
        <a class="chat-pop-over chat-active chat-blink" data-title="Olivia Zalianti Putri" href="#">Yudha</a>
        <div class="webui-popover-content">
            <div class="chat-conversation slim-scroll-chat">
                <p class="ajaib-devider-chat"><span>Friday, 2 Feb 2016</span></p>
                <p class="ajaib-client"><small>Sat 7:19 PM</small>halo, ajaib</p>
                <p class="ajaib-operator"><small>Sat 7:21 PM</small>Selamat pagi, ada yang bisa saya bantu? kami menyediakan jasa untuk pemesanan tiket bioskop, tiket pesawat dan reservasi hotel.</p>
                <p class="ajaib-client"><small>Sat 7:19 PM</small>Saya mau pesan tiket bioskop bisa?</p>
                <p class="ajaib-operator"><small>Sat 7:19 PM</small>Untuk film apa ?</p>
            </div>
            <div class="textarea-nest">
                <div class="form-group">
                    <span class="fontello-attach"></span>
                    <span class="fontello-camera"></span>
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn pull-right btn-default btn-ajaib">Submit</button>
            </div>
            <!-- /input-group -->
        </div>
    </div>
    <div class="chat-list">
        <div class="close-box"></div>
        <a class="chat-pop-over chat-active" data-title="Olivia Zalianti Putri" href="#"><img class="chat-pic-bottom" src="img/thumb/27.jpg">Angger Binuko</a>
        <div class="webui-popover-content">
            <div class="chat-conversation slim-scroll-chat">
                <p class="ajaib-devider-chat"><span>Friday, 2 Feb 2016</span></p>
                <p class="ajaib-client"><small>Sat 7:19 PM</small>ha</p>
                <p class="ajaib-operator"><small>Sat 7:21 PM</small>Selamat .</p>
                <p class="ajaib-client"><small>Sat 7:19 PM</small>Saya </p>
                <p class="ajaib-operator"><small>Sat 7:19 PM</small>Unt</p>
                <p class="ajaib-operator"><small>Sat 7:19 PM</small>Unt</p>
                <p class="ajaib-operator"><small>Sat 7:19 PM</small>Unt</p>
            </div>
            <div class="textarea-nest">
                <div class="form-group">
                    <span class="fontello-attach"></span>
                    <span class="fontello-camera"></span>
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn pull-right btn-default btn-ajaib">Submit</button>
            </div>
        </div>
    </div>
    <div class="chat-list chat-idle">
        <div class="close-box"></div>
        <a class="chat-pop-over" data-title="Olivia Zalianti Putri" href="#"><img class="chat-pic-bottom" src="img/thumb/30.jpg">Agus Riyadi</a>
        <div class="webui-popover-content">
            <div class="chat-conversation slim-scroll-chat">
                <p class="ajaib-devider-chat"><span>Friday, 2 Feb 2016</span></p>
                <p class="ajaib-client"><small>Sat 7:19 PM</small>halo, ajaib</p>
                <p class="ajaib-operator"><small>Sat 7:21 PM</small>Selamat pagi, ada yang bisa saya bantu? kami menyediakan jasa untuk pemesanan tiket bioskop, tiket pesawat dan reservasi hotel.</p>
                <p class="ajaib-devider-chat"><span>Friday, 2 Feb 2016</span></p>
                <p class="ajaib-client"><small>Sat 7:19 PM</small>Saya mau pesan tiket bioskop bisa?</p>
                <p class="ajaib-operator"><small>Sat 7:19 PM</small>Untuk film apa ?</p>
            </div>
            <div class="textarea-nest">
                <div class="form-group">
                    <span class="fontello-attach"></span>
                    <span class="fontello-camera"></span>
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn pull-right btn-default btn-ajaib">Submit</button>
            </div>
        </div>
    </div>
</div>


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
