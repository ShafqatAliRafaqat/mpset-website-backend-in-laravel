@extends('layouts.layout_admin.admin_design')
@section('content')

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>

<!--End-breadcrumbs-->

    <div class="container">

    <div class="row">
        <div class="col-sm-12 mb-4 mt-4">
            <div class="card-group">
                <div class="card col-md-6 no-padding ">
                    <div class="card-body">
                        <div class="h1 text-muted text-right mb-4">
                            <i class="fas fa-user"></i>
                        </div>

                        <div class="h4 mb-0">
                            <span class="count">87500</span>
                        </div>

                        <h6 class="text-muted text-uppercase ">Total Users</h6>
                        <div class="progress progress-xs mt-3 mb-0 bg-flat-color-1" style="width: 40%; height: 5px;"></div>
                    </div>
                </div>
                <div class="card col-md-6 no-padding ">
                    <div class="card-body">
                        <div class="h1 text-muted text-right mb-4">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="h4 mb-0">
                            <span class="count">385</span>
                        </div>
                        <h6 class="text-muted text-uppercase ">Total Events</h6>
                        <div class="progress progress-xs mt-3 mb-0 bg-flat-color-2" style="width: 40%; height: 5px;"></div>
                    </div>
                </div>
                <div class="card col-md-6 no-padding ">
                    <div class="card-body">
                        <div class="h1 text-muted text-right mb-4">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="h4 mb-0">
                            <span class="count">18</span>
                        </div>
                        <h6 class="text-muted text-uppercase">Ongoing Events</h6>
                        <div class="progress progress-xs mt-3 mb-0 bg-flat-color-3" style="width: 40%; height: 5px;"></div>
                    </div>
                </div>

            </div>
            </div>



            <div class="col-sm-12 mb-4">
            <div class="card-group">
                <div class="card col-md-6 no-padding ">
                    <div class="card-body">
                        <div class="h1 text-muted text-right mb-4">
                            <i class="fas fa-user-plus"></i>
                        </div>

                        <div class="text-center">
                            <a href="#">
                                <button type="submit" class="btn btn-outline-secondary btn-lg">
                                    <span class="icon-plus-sign-alt" aria-hidden="true"></span> Add New User
                                </button>
                            </a>
                        </div>
                        <div class="progress progress-xs mt-3 mb-0 bg-flat-color-1" style="width: 100%; height: 5px;"></div>
                    </div>
                </div>
                <div class="card col-md-6 no-padding ">
                    <div class="card-body">
                        <div class="h1 text-muted text-right mb-4">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="text-center">
                            <a href="#">
                                <button type="submit" class="btn btn-outline-secondary btn-lg">
                                    <span class="icon-plus-sign-alt" aria-hidden="true"></span> Add New Event
                                </button>
                            </a>
                        </div>
                        <div class="text-center progress progress-xs mt-3 mb-0 bg-flat-color-2" style="width: 100%; height: 5px;"></div>
                    </div>
                </div>
            </div>
          </div>
        </div><!-- .row -->
          <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
                    <h5>Turning-series chart</h5>
                </div>
                <div class="widget-content">
                <div id="pop_div"></div>
                <?= $lava->render('AreaChart', 'Population', 'pop_div') ?>

                </div>
                </div>
            </div>
            </div>


    </div>
    <br>

</div>

@endsection
