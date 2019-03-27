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
        <h5>Update User Profile</h5>
      </div>
      <div class="widget-content">
       <div class="container">
        <form method="post" action="/user/profile/update/{{ $userdetail->id }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">User First Name</label>
                <div class="col-sm-10">
                <input type="hidden" name="user_id" value="{{ $userdetail->user_id }}">
                    <input type="text" class="form-control pull-left" name="first_name" id="first_name" value="{{ $userdetail->first_name }}" required placeholder="User Fsirst Name..." >
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">User Last Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control pull-left" name="last_name" id="last_name" value="{{ $userdetail->last_name }}" required placeholder="User Last Name..." >
                </div>
            </div>
           <div class="form-group row">
                <label for="type" class="col-sm-2 col-form-label">Gender</label>
                <div class="col-sm-10">
                    <select name="gender" class="form-control pull-left">
                        <option value="1" @if($userdetail->gender =="1") selected @endif>Male </option>
                        <option value="2" @if($userdetail->gender == "2") selected @endif>Female</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="Phone" class="col-sm-2 col-form-label">Phone</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control pull-left"  value="{{ $userdetail->phone }}" required id="phone" name="phone" placeholder="Enter User Phone Number">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <input type="submit" class="btn btn-primary" value="Update User Profile" />
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
