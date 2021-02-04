<!DOCTYPE html>
<html lang="en">
@include('layouts.header')
<style>
    .hidden{
        display: none;
    }
</style>
<body style="background-color: #ffffff">
<div class="wrapper">
    @yield('content')
</div>
@include('layouts.footer')
</body>
@yield('script')
</html>