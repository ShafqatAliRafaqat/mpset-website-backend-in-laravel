@extends('layouts.layout_admin.admin_design')
@section('content')

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('/events') }}" title="Users" class="tip-bottom"><i class="icon-calendar"></i> Events</a> <a href="{{ url('/events/details') }}" class="current">Details</a> </div>
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
      <h5>Event Details</h5>
      </div>
      <div class="widget-content">

      </div>
      <div class="widget-content nopadding">
        <table class="table table-bordered table-striped data-table dataTable" id="DataTables_Table_10">
            <thead>
            <tr>
                <th>Player Name</th>
                <th>Play As</th>
                <th>Buyin's</th>
                <th>Check out</th>
                <th>Game Profile</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($events))
            @foreach($events as $event)
            <tr class="gradeX text-center">
                    <td>{{ $event->name }}</td>
                    <td>@if($event->host_id =="1") Player @endif
                        @if($event->host_id =="2") Host @endif
                    </td>
                    <td>{{ $event->amount_purchase }}</td>
                    <td>${{ $event->max_buy_in }}</td>
                    <td>{{ $event->game_profile}}</td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>

</div>

@endsection
