<!DOCTYPE html>
<html lang="en">
@include('layouts.header')
<body style="background-color: #ffffff">
<div class="wrapper">
    @yield('content')
</div>
@include('layouts.footer')
</body>
@yield('script')
</html>