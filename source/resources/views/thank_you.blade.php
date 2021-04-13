@extends('layouts.app')
@section('style')

@endsection
@section('content')

    <div class="header-container">
        <div class="nav" style="padding:0px 100px; width:100%" >
            <div class="logo"> <a href="#"><img  src="{{ asset('assets/img/second_logo.png') }}" alt="logo" /></a> </div>
            <a class="btn" href="#">Get the App</a> </div>
    </div>
    <section style="">
        <div class="hero-content">
            <h1>That's all, Thank you!</h1>
            <p style="margin-top:20px; padding-bottom:30px;">Your <span><strong> Submission </strong></span> is received and we will contact you soon. </p>
            <p>Have a minute? Help us share the love follow us on   <br>
                <a href="#">Twitter</a> and like us on <a href="#">Facebook</a>   <br>
                to keep you up to date with all our news and announcements.</p>
        </div>
    </section>
    <div style="font-size:10px; color: #9f9d9d; text-align:center; padding:20px 0px; background-color:#FFF;">Contact Us  -  Privacy Policy - Term & Condition</div>
@endsection