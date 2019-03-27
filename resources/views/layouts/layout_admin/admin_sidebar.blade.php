<!--sidebar-menu-->
<div id="sidebar"><a href="{{ url('dashboard') }}" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li><a href="{{ url('dashboard') }}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>

    <li><a href="/users"><i class="icon icon-group"></i> <span>Users</span></a> </li>

    <li class="submenu"> <a href="#"><i class="icon-calendar"></i> <span>Events</span><span class="label label-important"> <i class="down"></i> </span> </a>
      <ul>
        <li><a href="/events">All Events</a></li>
        <li><a href="/events/ongoing">Ongoing Events</a></li>
        <li><a href="/events/upcoming">Upcoming Events</a></li>
        <li><a href="/events/completed">Completed Events</a></li>
        <li><a href="/events/cancaled">Canceled Events</a></li>
      </ul>
    </li>

    <li> <a href="/features"><i class="icon-cogs"></i> <span>Features</span><span class="label label-important"> <i class="down"></i> </span> </a> </li>
  </ul>
</div>
<!--sidebar-menu-->
