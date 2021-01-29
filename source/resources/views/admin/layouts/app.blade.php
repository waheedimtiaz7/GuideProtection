<!DOCTYPE html>
<html lang="en">
    @include('admin.layouts.header')
    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable" style="background-color: #b7b7b7">
        @include('admin.layouts.mobile_header')
        <div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="d-flex flex-row flex-column-fluid page">
                @include('admin.layouts.sidebar')
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    @include('admin.layouts.topbar')
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <div class="d-flex flex-column-fluid">
                            <div class="container-fluid">
                                @if(session()->has('success'))
                                <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
                                </div>
                                @endif
                                @yield("content")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.footer')
        @yield("script")
    </body>
</html>
