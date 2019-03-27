@extends('layouts.layout_admin.admin_design')
@section('content')

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('features') }}" title="Events" class="tip-bottom"><i class="icon-cogs"></i> Features</a></div>
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
      <h5>Configrations</h5>
      </div>
      <div class="widget-content">
      <div class="container-fluid">
      <form method="post" action="/update-features">
      {{ csrf_field() }}
        <div class="form-group row">
            <label for="max-seats" class="col-sm-2 col-form-label">Maximum Seats</label>
            <div class="col-sm-10">
                <input type="number" class="form-control pull-left" name="max-seats" id="max-seats" placeholder="Please Enter Maximum Seats Per Table" >
            </div>
        </div>

        <div class="form-group row">
            <label for="min-seats" class="col-sm-2 col-form-label">Minimum Seats</label>
            <div class="col-sm-10">
                <input type="number" class="form-control pull-left" name="min-seats" id="min-seats" placeholder="Please Enter Minimum Seats Per Table" >
            </div>
        </div>

        <div class="form-group row">
            <label for="home-payment" class="col-sm-2 col-form-label">Home Payment</label>
            <div class="col-sm-10">
                <input type="number" class="form-control pull-left" name="home-payment" id="home-payment" placeholder="Please Enter Fee Amount For Home Payment" >
            </div>
        </div>

        <div class="form-group row">
            <label for="buy-in" class="col-sm-2 col-form-label">Buy-In/ Re-Buy</label>
            <div class="col-sm-10">
                <input type="number" class="form-control pull-left" name="buy-in" id="buy-in" placeholder="Please Enter Fee Amount For Buy-In / Re-Buy" >
            </div>
        </div>

        <div class="form-group row">
            <label for="default-image" class="col-sm-2 col-form-label">Default User Image</label>
            <div class="col-sm-10">
                <input type="file"  class="form-control pull-left" id="default-image" name="default-image" accept=".jpeg, .jpg, .png">
            </div>
        </div>


        <div class="form-group row">
        <label for="sms-text" class="col-sm-2 col-form-label">Notifications</label>
            <div class="col-sm-10">
            <input type="checkbox" name='notification'>
            </div>
        </div>


        <div class="form-group row">
            <label for="sms-text" class="col-sm-2 col-form-label">Invite Friend – Sms Text</label>
            <div class="col-sm-10">
                <textarea name="sms-text" id="sms-text" class="form-control pull-left" placeholder="Please Enter Invite Friend Sms Text" rows="4"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="email-text" class="col-sm-2 col-form-label">Invite Friend – Email Text</label>
            <div class="col-sm-10">
                <textarea name="email-text" id="email-text" class="form-control pull-left" placeholder="Please Enter Invite Friend Email Text" rows="4"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="invitation-day" class="col-sm-2 col-form-label">Invitations Per Day</label>
            <div class="col-sm-10">
                <input type="number" class="form-control pull-left" name="invitation-day" id="invitation-day" placeholder="Please Enter Amount Invitations Per Day" >
            </div>
        </div>

        <!-- <ul class="list-group">
            <li class="list-group-item">
                <div class="pull-left features-text">Morbi leo risus</div>
                <label class="switch pull-right">
                    <input  type="checkbox" name='features2'>
                    <span class="slider round"></span>
                </label>
            </li>
            <li class="list-group-item">
                <div class="pull-left features-text">Morbi leo risus</div>
                <label class="switch pull-right">
                    <input type="checkbox" name='features3'>
                    <span class="slider round"></span>
                </label>
            </li>
            <li class="list-group-item">
                <div class="pull-left features-text">Morbi leo risus</div>
                <label class="switch pull-right">
                    <input type="checkbox" name='features4'>
                    <span class="slider round"></span>
                </label>
            </li>
            <li class="list-group-item"><input type="submit" class="pull-right btn btn-outline-primary" value="Update" /></li>
        </ul> -->
        </form></div>
      </div>
    </div>
  </div>
  </div>

</div>

@endsection
