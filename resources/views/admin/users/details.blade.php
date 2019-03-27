@extends('layouts.layout_admin.admin_design')
@section('content')

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('/users') }}" title="Users" class="tip-bottom"><i class="icon-group"></i> Users</a> <a href="{{ url('/users') }}" class="current">Details</a> </div>
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
      <h5>Displaying {{ $username->name }} Profile</h5>
        <div class="pull-right">
            <span class="upload-file">
                <a href="/users/add">
  				    <button type="submit" class="btn btn-outline-secondary btn-sm">
  				        <span class="icon-plus-sign-alt" aria-hidden="true"></span> Add User
                    </button>
                </a>
            </span>
        </div>
      </div>
      <div class="widget-content nopadding">
        <table class="table table-bordered table-striped data-table dataTable" id="DataTables_Table_10">
            <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Notification Status</th>
                <th >Action</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($users))
            @foreach($users as $user)
            <tr class="gradeX text-center">
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td> @if($user->gender=="1") Male @endif
                         @if($user->gender=="2") Female @endif
                    </td>
                    <td>{{ $user->phone }}</td>
                    <td> @if($user->notification_status=="1") On @endif
                         @if($user->notification_status=="2") Off @endif
                    </td>
                    <td style="padding-top:0">
                        <a title="Edit User Profile" href="/user/profile/edit/{{ $user->id }}"><span class="color-dark-s icon-edit" aria-hidden="true"></span></a>
                        <a title="Delete User Profile" href="/user/profile/delete/{{ $user->id }}"><span class="color-dark-s icon-trash" aria-hidden="true"></span></a>
                    </td>
                </tr>

            @endforeach
            @endif
                
            </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
  <div class="container-fluid">
<!-- Area Chart Example-->

    <div class="container-fluid">
    <div class="widget-box">
      <div class="widget-title"> <span class="icon"><i class="icon-bar-chart"></i></span>
      <h5>Displaying {{$username->name}} location</h5>
        <!-- <div class="pull-right">
            <span class="upload-file">
                <a href="/users/add">
  				    <button type="submit" class="btn btn-outline-secondary btn-sm">
  				        <span class="icon-plus-sign-alt" aria-hidden="true"></span> Add User
                    </button>
                </a>
            </span>
        </div> -->
      </div>
      <div class="widget-content nopadding">
        <table class="table table-bordered table-striped data-table dataTable" id="DataTables_Table_10">
            <thead>
            <tr>
                <th>Location Image</th>
                <th>Address</th>
                <th>Location Latitude</th>
                <th>Location Longitude</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($userlocations))
            @foreach($userlocations as $user)
            <tr class="gradeX text-center">
                    <td><img src="/storage/{{$user->location_image}}" style="width: auto; height: 50px;"/></td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->location_latitude }}</td>
                    <td>{{ $user->location_longitude }}</td>
                    <td style="padding-top:0">
                        <a title="Edit User Location" href="/user/location/edit/{{ $user->id }}"><span class="color-dark-s icon-edit" aria-hidden="true"></span></a>
                        <a title="Delete User Location" href="/user/location/delete/{{ $user->id }}"><span class="color-dark-s icon-trash" aria-hidden="true"></span></a>
                    </td>
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
</div>


@endsection
