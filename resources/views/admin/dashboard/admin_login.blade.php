<!DOCTYPE html>
<html lang="en">

<head>
        <title> MPSET</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="{{ asset('css/css_backend/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/css_backend/bootstrap-responsive.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/css_backend/matrix-login.css') }}" />
        <link href="{{ asset('fonts/fonts_backend/css/font-awesome.css') }}" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
            <div class="container">
                <div class="row">
                    @if( Session :: has('flash_message_error') )
                        <div class="center-alert alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>  {!! session('flash_message_error') !!} </strong>
                        </div>
                    @endif

                    @if( Session :: has('flash_message_success') )
                        <div class="center-alert alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>  {!! session('flash_message_success') !!} </strong>
                        </div>
                    @endif
                </div>
            </div>
            <div id="loginbox">

            <div class="outerbox">
                <form id="loginform" class="form-vertical" method="post" action="{{ url('dashboard') }}"> {{ csrf_field() }}
                    <div class="control-group normal_text"><div class="height30"></div> <h3> <img src="{{ asset('images/images_backend/logo1.png') }}" alt="Logo" /></h3></div>
                    <div class="control-group">
                        <div class="controls">
                            <div class="main_input_box">
                                <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="email" name="email" placeholder="Email" />
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <div class="main_input_box">
                                <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" name="password" placeholder="Password" />
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
                        <span class="pull-right"><input type="submit" value="Login" class="btn btn-success" /></span>
                    </div>
                </form>
                <form id="recoverform" action="#" class="form-vertical">
                    <p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>

                        <div class="controls">
                            <div class="main_input_box">
                                <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />
                            </div>
                        </div>

                    <div class="form-actions">
                        <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                        <span class="pull-right"><a class="btn btn-info"/>Reecover</a></span>
                    </div>
                </form>
            </div>
        </div>
        <script src="{{ asset('js/js_backend/jquery.min.js') }}"></script>
        <script src="{{ asset('js/js_backend/matrix.login.js') }}"></script>
        <script src="{{ asset('js/js_backend/bootstrap.min.js')}}"></script>
    </body>

</html>
