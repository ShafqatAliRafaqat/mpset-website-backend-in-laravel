@extends('layouts.layout_admin.admin_design')
@section('content')


<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{ url('/settings') }}">Settings</a> </div>
    <h1>Settings</h1>
  </div>

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
    <div class="widget-box">
      <div class="widget-title"> <span class="icon"><i class="icon-cogs"></i></span>
        <h5>Update your Password</h5>
      </div>
      <div class="widget-content ">
      <div class="container">
        <form id="password_validate" name="password_validate" method="post" action="{{ url('/settings/update-password') }}">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="inputPassword1" class="col-sm-2 col-form-label">Old Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control pull-left" name="old_pass" id="old_pass" required placeholder="Old Password">
                    <span id="chk_pwd"></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword2" class="col-sm-2 col-form-label">New Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control pull-left" name="new_pass" id="new_pass" required placeholder="New Password">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control pull-left" name="cnew_pass" id="cnew_pass" required placeholder="Confirm Password">
                </div>
            </div>


            <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <input type="submit" class="btn btn-primary" value="Update Password" />
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
