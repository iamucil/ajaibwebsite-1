<li>
    <a href="#!"><img class="akram-logo" src="img/ajaib-logo-web.png"></a>
</li>
<!-- User profile -->
<li>
    <a class='codrops-icon codrops-icon-prev dropdown-button' href='#' data-activates='dropdown1'>
        <img src="{{ $authUser->photo }}" alt="" class="acram-id circle responsive-img"> Hi, <strong>{{ Auth::user()->name }}</strong><i class="material-icons"></i></a>    
    <ul id='dropdown1' class='dropdown-content'>        
        <li>
            <a href="{{ route('user.profile', AUTH::user()->id) }}"><i class="icon-user"></i>
                Profile<span class="text-aqua fontello-record"></span>
            </a>
        </li>
        <li>
            <a href="#" ng-click="logout()">
                <i class="icon-upload"></i> Log Out <span class="text-aqua fontello-cd"></span>
            </a>
        </li>
    </ul>    
</li>



<!-- Chat -->
<li>
    <a href="#" data-activates="slide-out" class="button-collapse"> <i class="small material-icons">perm_contact_calendar</i></a>
</li>
<li><a class='codrops-icon codrops-icon-prev dropdown-button' href='#' data-activates='dropdown-call'><i class="small material-icons">chat</i><span class="akram-badge">4</span></a>
    <ul id='dropdown-call' class='dropdown-content chat-profile'>
        <li>
            <img src="img/thumb/27.jpg" alt="" class="circle responsive-img">
            <h3>Agus Riyadi<small>Jus a second</small></h3>
            <p>Hai ajaib aku lagi pengen sesuatu nih, kamu bisa bantu ga ? pastinya bisa dong yah namanya juga ajaib</p>
        </li>
        <li>
            <img src="img/thumb/28.jpg" alt="" class="circle responsive-img">
            <h3>Desi<small>1 minute ago</small></h3>
            <p>Hai ajaib aku lagi pengen sesuatu nih, kamu bisa bantu ga ? pastinya bisa dong yah namanya juga ajaib</p>
        </li>
        <li>
            <img src="img/thumb/29.jpg" alt="" class="circle responsive-img">
            <h3>Anton<small>1 hour ago</small></h3>
            <p>Hai ajaib aku lagi pengen sesuatu nih, kamu bisa bantu ga ? pastinya bisa dong yah namanya juga ajaib</p>
        </li>
    </ul>
</li>
<li><a class='codrops-icon codrops-icon-prev dropdown-button' href='#' data-activates='dropdown-call-02'><i class="small material-icons">announcement</i><span class="akram-badge">23</span></a>
    <ul id='dropdown-call-02' class='dropdown-content chat-profile'>
        <li>
            <img src="img/thumb/27.jpg" alt="" class="circle responsive-img">
            <h3>Agus Riyadi<small>Jus a second</small></h3>
            <p>Hai ajaib aku lagi pengen sesuatu nih, kamu bisa bantu ga ? pastinya bisa dong yah namanya juga ajaib</p>
        </li>
        <li>
            <img src="img/thumb/28.jpg" alt="" class="circle responsive-img">
            <h3>Desi<small>1 minute ago</small></h3>
            <p>Hai ajaib aku lagi pengen sesuatu nih, kamu bisa bantu ga ? pastinya bisa dong yah namanya juga ajaib</p>
        </li>
        <li>
            <img src="img/thumb/29.jpg" alt="" class="circle responsive-img">
            <h3>Anton<small>1 hour ago</small></h3>
            <p>Hai ajaib aku lagi pengen sesuatu nih, kamu bisa bantu ga ? pastinya bisa dong yah namanya juga ajaib</p>
        </li>
    </ul>
</li>