@extends('layouts.layout_admin.admin_design')
@section('content')

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('/users') }}" title="Users" class="tip-bottom "><i class="icon-calendar"></i> Users</a> <a href="{{ url('/users') }}" class="current">All Users</a>  </div>
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
        <h5>Update User Location</h5>
      </div>
      <div class="widget-content">
       <div class="container">
        <form method="post" action="/user/location/update/{{ $location->id }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group row">
             <label for="location_images" class="col-sm-2 col-form-label">Location Images</label>
                <div class="col-sm-10">
                <label for="file" title="Old File" class="form-control pull-left">{{$location->location_image}}</label>
                <input type="hidden" name="user_id" value="{{ $location->user_id }}">
                <input type="hidden" class="form-control pull-left" id="file_o" name="file_o" value="{{ $location->location_image }}">
                    <input type="file" class="form-control pull-left" id="location_image" name="location_image" accept=".doc,.png,.jpg,.docx,application/msword,.pdf,application/pdf">
                </div>
            </div>
            <div class="form-group row">
                <label for="location_latitude" class="col-sm-2 col-form-label">Add Location Image</label>
                <div class="col-sm-10">
                    <select  id="js-example-basic-multiple" name="states[]" multiple="multiple">
                        <option value="AL">gerAlabama</option>
                        <option value="WY">ggfWyoming</option>
                        <option value="WY">asaWyoming</option>
                        <option value="WY">Wysdfoasming</option>
                        <option value="WY">sdfsfWyoming</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="location_latitude" class="col-sm-2 col-form-label">Location Latitude</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="{{ $location->location_latitude }}" id="location_latitude" name="location_latitude">
                </div>
            </div>
            <div class="form-group row">
                <label for="location_longitude" class="col-sm-2 col-form-label">Location Longitude</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left" value="{{ $location->location_longitude }}" id="location_longitude" name="location_longitude">
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="address" class="form-control pull-left" value="{{ $location->address }}" id="address" name="address">
                </div>
            </div>
            
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <input type="submit" class="btn btn-primary" value="Update User Location" />
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
