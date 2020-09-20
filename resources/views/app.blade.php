<!DOCTYPE html>
<html>

@include('sections.head')

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

        <App basepath="{{route('web.basepath')}}"></App>

        <!-- /.control-sidebar -->
        <div id="sidebar-overlay"></div>
    </div>
    <!-- ./wrapper -->

    @include('sections.script')

</body>

</html>
