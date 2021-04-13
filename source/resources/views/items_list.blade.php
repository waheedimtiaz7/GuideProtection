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
</head>
<body>
<div class="header-container">
    <div style="" class="container nav">
        <div class="logo"> <img style="width:47px; height:55px;" src="{{ asset("assets/img/second_logo.png") }}" /> </div>
        <div class= "progress-bar" style="justify-content: space-between;
	align-items: center; gap:50px;">
            <!--Step-->
            <div class="step" autofocus="">
                <p class="active">Order</p>
                <div class="bullet active"> <span>1</span> </div>
                <div class="check fas fa-check active" aria-hidden="true"></div>
            </div>
            <!--Step-->
            <div class="step active">
                <p>Contact</p>
                <div class="bullet active"> <span>2</span> </div>
                <div class="check fas fa-check active"></div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <!--Content-->

        <form action="#">
            <div class="page">
                <div class="title">Claim Form</div>
                <h3 style="color:#039; padding-top:10px; text-align:left;">Viable NYC</h3>
                <p style="color:#333; padding-bottom:10px;text-align:left;">Order Date 01/01/2021</p>
                <p style="color:#333; text-align:left;">Select claimed items from order:</p>
                <table class="styled-table">
                    <thead>
                    <tr>
                        <th>Orders Items</th>
                        <th>Qty</th>
                        <th>Description</th>
                        <th>SKU</th>
                    </tr>
                    </thead>
                    <tbody id="items_list">

                    </tbody>
                    @foreach($order->order_detail as $k=>$detail)
                        @if(strtolower($detail->title)!='guide shipping protection' && strtolower($detail->title)!='guide protection')
                            <tr style="border-bottom:1px solid #ccc;">
                                <td><input name="item[]" type="checkbox" class="box item" value="{{ $detail->id }}"></td>
                                <td><input name="qty[]" id="qty_{{ $detail->id }}" disabled="disabled"  value="{{ $detail->qty }}"></td>
                                <td>{{ $detail->title }}</td>
                                <td>{{ $detail->sku }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
                <div class="field btns">
                    <button class="prev-1 prev">Previous</button>
                    <button class="submit">Submit</button>
                </div>
            </div>

        </form>
</div>
<div style="font-size:12px; color: #9f9d9d; text-align:center; margin:20px 0px;">Contact Us  -  Privacy Policy - Term & Condition</div>
<script src="{{ asset("assets/js/script.js") }}"></script>
</body>
</html>
