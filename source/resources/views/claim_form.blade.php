<!DOCTORTYPE html>
<html lang ="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css") }}/Survey.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <title>Multi Step Form</title>
    <script>
        var check_order="{{ route('check_order') }}"
    </script>
    <style>
        .hidden{
            display: none;
        }
        .alert-danger{
            color: red;
        }
    </style>
</head>

<body>
<div class="header-container">
    <div style="" class="container nav">
        <div class="logo"> <img style="width:47px; height:55px;" src="{{ asset("assets/img/second_logo.png") }}" /> </div>
        <div class= "progress-bar" style="justify-content: space-between;
	align-items: center; gap:50px;">
            <!--Step-->
            <div class="step active" autofocus>
                <div class="bullet active"> <span style="color: #fff;display: block">1</span> </div>
                <div class="check fas fa-check"></div>
            </div>
            <!--Step-->
            <div class="step">
                <div class="bullet"> <span>2</span> </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <div class="bullet"> <span>3</span> </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <div class="bullet"> <span>4</span> </div>
                <div class="check fas fa-check"></div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <!--Content-->
    <div class="form-outer">
        <div class="alert-danger py-3 hidden mb-5">Please provide the missing fields</div>
        <form action="#" id="contact-form-data">
            <div class="page slidepage">
                <div class="title">Claim Form</div>
                <p style="text-align:left; margin-bottom:10px; color:#ccc;">First Lets Find your Order</p>
                {{ csrf_field() }}
                <div class="field">
                    <div class="label">Order Email</div>
                    <input name="email" id="email" type="email" placeholder="Order Email" required="">
                </div>
                <div class="field">
                    <div class="label">Last Name</div>
                    <input name="order_number" id="order_number" type="text" placeholder="Order Number" required="">
                </div>
                <div class="field nextBtn">
                    <button type="submit">Next</button>
                </div>
            </div>


        </form>
    </div>
</div>
<div style="font-size:12px; color: #9f9d9d; text-align:center; margin:20px 0px;">Contact Us  -  Privacy Policy - Term & Condition</div>
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script src="{{ asset("/") }}assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="{{ asset("/") }}assets/js/scripts.bundle.js"></script>
<script src="{{ asset("/") }}assets/js/bundle.min.js"></script>
<script>

    $("#contact-form-data").on('submit',function (e) {
        e.preventDefault();
        $.ajax({
            url:"{{ route('check_order') }}",
            data:$(this).serialize(),
            type:"post",
            success:function (data) {
                if(data.success){
                    window.location.href="{{ url("file-claim") }}"+"/"+data.order.id
                }else{
                    $(".alert-danger").removeClass("hidden");
                    $(".alert-danger").html(data.message);
                }
            }
        })
    });
</script>
</body>
</html>
