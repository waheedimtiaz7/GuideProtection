@extends('layouts.app')
@section('content')

    <!-- Start Header -->
    <header class="header step-3">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <!-- Logo -->
                    <div class="logo_img">
                        <img src="{{ asset("assets") }}/img/logo.png" alt="logo image">
                    </div>
                </div>
                <div class="col-md-8 d-flex justify-content-center justify-content-md-end">
                    <!-- WOrk Process-->
                    <div id="our-process">
                        <div class="container">
                            <div class="row">
                                <ul class="process-wrapp">
                                    <li class="whitecolor wow fadeIn" data-wow-delay="300ms">
                                        <span class="active-step">01</span>
                                    </li>
                                    <li class="whitecolor wow fadeIn" data-wow-delay="400ms">
                                        <span class="active-step">02</span>
                                    </li>
                                    <li class="whitecolor wow fadeIn" data-wow-delay="400ms">
                                        <span class="pro-step">03</span>
                                    </li>
                                    <li class="whitecolor wow fadeIn">
                                        <span class="active-step">04</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--WOrk Process ends-->
                </div>
            </div>
        </div>
    </header>
    <!-- End Header -->

    <!-- Start Banner -->
    <section class="page-title">
        <div class="container">
            <h2>Claim Form</h2>
            <ul class="page-breadcrumb">
                <li><a href="{{ url("/") }}"><span class="icon fas fa-home"></span>Home</a></li>
                <li>Claim Form</li>
            </ul>
        </div>
    </section>
    <!-- End Banner -->

    <!-- Start Thanks Message -->
    <section class="t-message">
        <div class="container alert-success">
            <div class="row">
                <div class="col-12 p-5">
                    <div class="first-line">
                        <a href="javascript:void(0);"><i class="fas fa-check-circle tick-circle"></i></a>
                        <p>Thanks We've received your claim</p>
                    </div>
                    <p class="second-line">We'll process your claim within 24 hours Monday-Friday</p>
                </div>
            </div>
        </div>
    </section>
@endsection