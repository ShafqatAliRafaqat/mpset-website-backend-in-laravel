@extends('layouts.layout_admin.admin_design')
@section('content')

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('/users') }}" title="Users" class="tip-bottom"><i class="icon-group"></i> Users</a></div>
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
      <h5>Displaying Users List</h5>
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
            <tr><?php  $count = 1; ?>
                <th>S No</th>
                <th>Avatar</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Details</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($users))
            @foreach($users as $user)
            <tr class="gradeX text-center">
                    <td>{{ $count++ }}</td>
                    <td><img src="{{$user->avatar }}" style="width: auto; height: 50px;"/></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td > <a title="View User History" href="/users/details/{{ $user->id }}"><span class="color-dark icon-list" aria-hidden="true"></span></a> </td>
                    <td >
                        <a title="Edit User" href="users/edit/{{ $user->id }}"><span class="color-dark-s icon-edit" aria-hidden="true"></span></a>
                        <a title="Delete User" href="users/delete/{{ $user->id }}"><span class="color-dark-s icon-trash" aria-hidden="true"></span></a>
                    </td>
                </tr>
            @endforeach
            @endif
                <!-- <tr class="gradeX text-center">
                    <td><img src="{{ asset('storage/cod.png') }}" alt="user" width="40px" height="40px"></td>
                    <td>Danish</td>
                    <td>Mehmood</td>
                    <td>danishejaz80</td>
                    <td>danish@sr7.tech</td>
                    <td>+923246180444</td>
                    <td > <a title="View User History" href="{{ url('/users/details') }}"><span class="color-dark icon-list" aria-hidden="true"></span></a> </td>
                    <td >
                        <a title="Edit User" href="#"><span class="color-dark-s icon-edit" aria-hidden="true"></span></a>
                        <a title="Delete User" href="#"><span class="color-dark-s icon-trash" aria-hidden="true"></span></a>
                    </td>
                </tr> -->

            </tbody>
        </table>

      </div>
    </div>
  </div>
  </div>

</div>

@endsection
