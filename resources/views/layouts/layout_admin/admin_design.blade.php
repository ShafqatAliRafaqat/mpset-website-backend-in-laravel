<!DOCTYPE html>
<html lang="en">
<head>
<title>MPSET</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="{{asset('css/css_backend/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{asset('css/css_backend/bootstrap-responsive.min.css') }}" />
<link rel="stylesheet" href="{{asset('css/css_backend/fullcalendar.css') }}" />
<link rel="stylesheet" href="{{asset('css/css_backend/matrix-style.css') }}" />
<link rel="stylesheet" href="{{asset('css/css_backend/matrix-media.css') }}" />
<link rel="stylesheet" href="{{asset('css/css_backend/select2.css') }}" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css" />
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.css" /> -->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<!-- <link rel="stylesheet" href="{{asset('css/css_backend/dataTables.bootstrap4.css') }}" /> -->

<link href="{{asset('fonts/fonts_backend/css/font-awesome.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('css/css_backend/jquery.gritter.css')}}" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

</head>
<body>

@include('layouts.layout_admin.admin_header')
@include('layouts.layout_admin.admin_sidebar')


@yield('content')

@include('layouts.layout_admin.admin_footer')



<script src="{{ asset('js/js_backend/excanvas.min.js')}}"></script>
<script src="{{ asset('js/js_backend/jquery.min.js')}}"></script>
<script src="{{ asset('js/js_backend/jquery.ui.custom.js')}}"></script>
<script src="{{ asset('js/js_backend/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/js_backend/jquery.flot.min.js')}}"></script>
<script src="{{ asset('js/js_backend/jquery.flot.resize.min.js')}}"></script>
<script src="{{ asset('js/js_backend/jquery.peity.min.js')}}"></script>
<script src="{{ asset('js/js_backend/fullcalendar.min.js')}}"></script>
<script src="{{ asset('js/js_backend/matrix.js')}}"></script>
<script src="{{ asset('js/js_backend/matrix.dashboard.js')}}"></script>
<script src="{{ asset('js/js_backend/matrix.interface.js')}}"></script>
<script src="{{ asset('js/js_backend/matrix.chat.js')}}"></script>
<script src="{{ asset('js/js_backend/jquery.validate.js')}}"></script>
<script src="{{ asset('js/js_backend/matrix.form_validation.js')}}"></script>
<script src="{{ asset('js/js_backend/jquery.wizard.js')}}"></script>
<script src="{{ asset('js/js_backend/jquery.uniform.js')}}"></script>
<script src="{{ asset('js/js_backend/select2.min.js')}}"></script>
<script src="{{ asset('js/js_backend/matrix.popover.js')}}"></script>
<script src="{{ asset('js/js_backend/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('js/js_backend/matrix.tables.js')}}"></script>
<!-- <script src="{{ asset('js/js_backend/jquery.validation.min.js')}}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js"></script>



<!-- <script src="{{ asset('js/js_backend/jquery.gritter.min.js')}}"></script> -->

<script type="text/javascript">

  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {

          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();
          }
          // else, send page to designated URL
          else {
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
$(document).ready(function() {
    $('#js-example-basic-multiple').select2();});
</script>
</body>
</html>
