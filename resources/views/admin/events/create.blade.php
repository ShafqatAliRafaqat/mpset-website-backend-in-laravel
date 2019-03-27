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
    <div class="widget-box">
      <div class="widget-title"> <span class="icon"><i class="icon-bar-chart"></i></span>
        <h5>Add Event</h5>
      </div>
      <div class="widget-content">
       <div class="container">
        <form method="post" action="/events/save" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Event Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control pull-left" name="name" id="name" value="" required placeholder="Event Name..." >
                </div>
            </div>

           <div class="form-group row">
                <label for="type" class="col-sm-2 col-form-label">Play as</label>
                <div class="col-sm-10">
                    <select name="host_id" class="form-control pull-left">
                        <option value="1">Player</option>
                        <option value="2">Host</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Game Profile</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control pull-left" name="game_profile" id="game_profile" value="" required >
                </div>
            </div>

            <div class="form-group row">
                <label for="cnic" class="col-sm-2 col-form-label">Game Type</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left"  value="" required id="game_type" name="game_type">
                </div>
            </div>
            <div class="form-group row">
                <label for="type" class="col-sm-2 col-form-label">Event Status</label>
                <div class="col-sm-10">
                    <select name="event_status" class="form-control pull-left">
                        <option value="1">Ongoing</option>
                        <option value="2">Completed</option>
                        <option value="3">Upcoming</option>
                        <option value="4">Canceled</option>
                        <option value="5">Paused</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="joining_date" class="col-sm-2 col-form-label">Amount Purchase</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="" id="amount_purchase" name="amount_purchase">
                </div>
            </div>

            <div class="form-group row">
                <label for="no of rebuys" class="col-sm-2 col-form-label">Rebuy</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="" id="no_of_re_buy" name="no_of_re_buy">
                </div>
            </div>
            <div class="form-group row">
                <label for="max player per table" class="col-sm-2 col-form-label">max player per table</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="" id="max_player_per_table" name="max_player_per_table">
                </div>
            </div>
            <div class="form-group row">
                <label for="min player per table" class="col-sm-2 col-form-label">min player per table</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="" id="min_player_per_table" name="min_player_per_table">
                </div>
            </div>
            <div class="form-group row">
                <label for="available Seats" class="col-sm-2 col-form-label">Available Seats</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="" id="available_seats" name="available_seats">
                </div>
            </div>
            <div class="form-group row">
                <label for="table_rules" class="col-sm-2 col-form-label">Table Rules</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control pull-left" value="" id="table_rules" name="table_rules">
                </div>
            </div>
            <div class="form-group row">
                <label for="small_blind" class="col-sm-2 col-form-label">Small Blind</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="" id="small_blind" name="small_blind">
                </div>
            </div>
            <div class="form-group row">
                <label for="big_blind" class="col-sm-2 col-form-label">Big Blind</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="" id="big_blind" name="big_blind">
                </div>
            </div>
            <div class="form-group row">
                <label for="max buy in" class="col-sm-2 col-form-label">Max Buy In</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="" id="max_buy_in" name="max_buy_in">
                </div>
            </div>
            <div class="form-group row">
                <label for="min_buy_in " class="col-sm-2 col-form-label">Min Buy In </label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="" id="min_buy_in" name="min_buy_in">
                </div>
            </div>
            <div class="form-group row">
                <label for="game_date" class="col-sm-2 col-form-label">Game Date</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control pull-left" value="" id="game_date" name="game_date">
                </div>
            </div>
            <div class="form-group row">
                <label for="game_time" class="col-sm-2 col-form-label">Game Time</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control pull-left" value="" id="game_time" name="game_time">
                </div>
            </div>
            <div class="form-group row">
                <label for="game_start_time" class="col-sm-2 col-form-label">Game Start Time</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control pull-left" value="" id="game_start_time" name="game_start_time">
                </div>
            </div>
            <div class="form-group row">
                <label for="game_end_time" class="col-sm-2 col-form-label">Game End Time</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control pull-left" value="" id="game_end_time" name="game_end_time">
                </div>
            </div>
            <!-- <div class="form-group row">
                <label for="location_images" class="col-sm-2 col-form-label">Location Images</label>
                <div class="col-sm-10">
                    <input type="image" class="form-control pull-left" value="" id="location_images" name="location_images">
                </div>
            </div> -->
            <div class="form-group row">
             <label for="location_images" class="col-sm-2 col-form-label">Location Images</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control pull-left" id="location_images" name="location_images" accept=".doc,.png,.jpg,.docx,application/msword,.pdf,application/pdf">
                </div>
            </div>
            <div class="form-group row">
                <label for="location_latitude" class="col-sm-2 col-form-label">Location Latitude</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="" id="location_latitude" name="location_latitude">
                </div>
            </div>
            <div class="form-group row">
                <label for="location_longitude" class="col-sm-2 col-form-label">Location Longitude</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="" id="location_longitude" name="location_longitude">
                </div>
            </div>
            <div class="form-group row">
                <label for="location_name" class="col-sm-2 col-form-label">Location Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control pull-left" value="" id="location_name" name="location_name">
                </div>
            </div>
            
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <input type="submit" class="btn btn-primary" value="Save Event" />
                </div>
            </div>
         </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</div>


@endsection
