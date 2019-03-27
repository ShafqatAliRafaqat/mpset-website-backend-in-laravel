<!--Header-part-->
<div id="header">
  <h1><a href="{{ url('/dashboard') }}">MPSET</a></h1>
</div>
<!--close-Header-part-->


<!--top-Header-menu-->

<!--start-top-serch-->
<!-- <div iphp -->
<!--close-top-serch-->

<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
  <li class="dropdown" id="menu-time"><a href="#"><i class="icon-time"></i> <span class="text"><?php $mytime = now()->format('D - d-m-Y'); echo $mytime;   ?></span> </a></li>

  <!--
    <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
        <li class="divider"></li>
        <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
        <li class="divider"></li>
        <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
        <li class="divider"></li>
        <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
      </ul>
    </li>
    -->
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">{{ Auth::user()->name }}</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="{{ url('/settings') }}"><i class="icon-cog"></i> Seetings</a></li>
        <li class="divider"></li>
        <li><a href="{{ url('/logout')}}"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>
  </ul>
</div>
<!--close-top-Header-menu-->
