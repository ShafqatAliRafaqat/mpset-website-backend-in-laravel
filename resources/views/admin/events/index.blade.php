@extends('layouts.layout_admin.admin_design')
@section('content')

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('/events') }}" title="Events" class="tip-bottom "><i class="icon-calendar"></i> Events</a> <a href="{{ url('/events') }}" class="current">All Events</a>  </div>
  </div>
<!--End-breadcrumbs-->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if( Session :: has('flash_message_error') )
                <div class="text-center center-alert alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>  {!! session('flash_message_error') !!} </strong>
                </div>
            @endif

            @if( Session :: has('flash_message_success') )
                <div class="center-alert text-center alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>  {!! session('flash_message_success') !!} </strong>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="container-fluid">
<!-- Area Chart Example-->

    <div class="container-fluid">
    <div class="widget-box">
      <div class="widget-title"> <span class="icon"><i class="icon-bar-chart"></i></span>
      <h5>Displaying List of All Events</h5>
        <div class="pull-right">
            <span class="upload-file">
                <a href="/events/add/">
  				    <button type="submit" class="btn btn-outline-secondary btn-sm">
  				        <span class="icon-plus-sign-alt" aria-hidden="true"></span> Add Event
                    </button>
                </a>
            </span>
        </div>
      </div>
      <div class="widget-content nopadding">
      <table class="table table-bordered table-striped data-table dataTable" id="DataTables_Table_10">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Location</th>
                    <th>Duration</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @if(isset($events))
            @foreach($events as $event)
            <tr class="gradeX text-center">
                    <td>{{ $event->name}}</td>
                    <td>{{ $event->location_name }}</td>
                    <td>{{  (int)$event->game_end_time-(int)$event->game_start_time }}</td>
                    <td>{{ $event->game_date }}</td>
                    <td> @if($event->event_status =="1") Ongoing @endif
                     @if($event->event_status =="2") Completed @endif
                     @if($event->event_status =="3") Upcoming @endif
                     @if($event->event_status =="4") Canceled @endif
                     @if($event->event_status =="5") Paused @endif</td>
                    <td>$29321</td>
                    <td > <a title="View Event Detail" href="events/details/{{ $event->id }}"><span class="color-dark icon-list" aria-hidden="true"></span></a> </td>
                    <td>
                        <a title="Edit User" href="events/edit/{{ $event->id }}"><span class="color-dark-s icon-edit" aria-hidden="true"></span></a>
                        <a title="Delete User" href="events/delete/{{ $event->id }}"><span class="color-dark-s icon-trash" aria-hidden="true"></span></a>
                    </td>
                </tr>
            @endforeach
            @endif
                <tr class="gradeX text-center">
                    <td>Poker</td>
                    <td>Divine mega 2, Lahore, Pakistan,  asdasfd ,asdfwefwefad,wefea</td>
                    <td>01:30 (h:m)</td>
                    <td>01-01-19</td>
                    <td>Completed</td>
                    <td>$29321</td>
                    <td > <a title="View Event Detail" href="{{ url('/events/details') }}"><span class="color-dark icon-list" aria-hidden="true"></span></a> </td>
                    <td>
                        <a title="Edit User" href="#"><span class="color-dark-s icon-edit" aria-hidden="true"></span></a>
                        <a title="Delete User" href="#"><span class="color-dark-s icon-trash" aria-hidden="true"></span></a>
                    </td>
                </tr>

            </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>

</div>

@endsection
