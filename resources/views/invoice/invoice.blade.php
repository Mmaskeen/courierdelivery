@include('layouts.css')
@yield('style')
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@if($order->dispatch_by != 'Tcs' && $order->dispatch_by != 'Stallion')
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>NAVIFORCE</title>
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap" rel="stylesheet">
        <!-- <link rel="stylesheet" href="style.css"> -->
        <style>
            *,
            div{
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            :root{
                --transition:  all 300ms ease-in-out;
            }
            * {
                margin: 0px;
                padding: 0px;
            }
            *:after,
            *:before{ transition: var(--transition); }
            @font-face {
                font-family: 'Myriad Pro Regular';
                font-style: normal;
                font-weight: normal;
                src: local('Myriad Pro Regular'), url('{{asset('assets/fonts/webfonts/MYRIADPRO-REGULAR.woff')}}') format('woff');
            }


            @font-face {
                font-family: 'Myriad Pro Condensed';
                font-style: normal;
                font-weight: normal;
                src: local('Myriad Pro Condensed'), url('{{asset('assets/fonts/webfonts/MYRIADPRO-CONDIT.woff')}}') format('woff');
            }


            @font-face {
                font-family: 'Myriad Pro Condensed Italic';
                font-style: normal;
                font-weight: normal;
                src: local('Myriad Pro Condensed Italic'), url('{{asset('assets/fonts/webfonts/MYRIADPRO-CONDIT.woff')}}') format('woff');
            }


            @font-face {
                font-family: 'Myriad Pro Light';
                font-style: normal;
                font-weight: normal;
                src: local('Myriad Pro Light'), url('{{asset('assets/fonts/webfonts/MyriadPro-Light.woff')}}') format('woff');
            }


            @font-face {
                font-family: 'Myriad Pro Semibold';
                font-style: normal;
                font-weight: normal;
                src: local('Myriad Pro Semibold'), url('{{asset('assets/fonts/webfonts/MYRIADPRO-SEMIBOLD.woff')}}') format('woff');
            }


            @font-face {
                font-family: 'Myriad Pro Semibold Italic';
                font-style: normal;
                font-weight: normal;
                src: local('Myriad Pro Semibold Italic'), url('{{asset('assets/fonts/webfonts/MYRIADPRO-SEMIBOLDIT.woff')}}') format('woff');
            }


            @font-face {
                font-family: 'Myriad Pro Bold Condensed';
                font-style: normal;
                font-weight: normal;
                src: local('Myriad Pro Bold Condensed'), url('{{asset('assets/fonts/webfonts/MYRIADPRO-BOLDCOND.woff')}}') format('woff');
            }


            @font-face {
                font-family: 'Myriad Pro Bold';
                font-style: normal;
                font-weight: normal;
                src: local('Myriad Pro Bold'), url('{{asset('assets/fonts/webfonts/MYRIADPRO-BOLD.woff')}}') format('woff');
            }


            @font-face {
                font-family: 'Myriad Pro Bold Italic';
                font-style: normal;
                font-weight: normal;
                src: local('Myriad Pro Bold Italic'), url('{{asset('assets/fonts/webfonts/MYRIADPRO-BOLDIT.woff')}}') format('woff');
            }


            @font-face {
                font-family: 'Myriad Pro Bold Condensed Italic';
                font-style: normal;
                font-weight: normal;
                src: local('Myriad Pro Bold Condensed Italic'), url('{{asset('assets/fonts/webfonts/MYRIADPRO-BOLDCONDIT.woff')}}') format('woff');
            }


            body {
                color: #262626;
                background-color: var(--white);
                font:400 14px/23px 'Myriad Pro', Arial, Helvetica, sans-serif;
            }
        </style>
    </head>

@endif
<body class="app sidebar-mini rtl">
@if($order->dispatch_by != 'Tcs' && $order->dispatch_by != 'Stallion')
    <div id="at-wrapper" class="at-wrapper" style="overflow: hidden; margin: 30px 0; padding-bottom: 30px; border-bottom: 2px dashed #000; " >
        <!--************************************
                Tcs invoice start
        *************************************-->
        <div style="width: 100%; float: left;">
            <div style="max-width: 655px; margin: 0 auto; overflow: hidden; border: 2px solid #191919;">
                <ul style="width: 100%; float: left; margin: 0; padding: 0; list-style: none;border-bottom: 2px solid #191919; ">
                    <li style="float: left; padding: 32px 10px;border-right: 2px solid #191919;list-style-type: none;">
                        <span style="display: block; font-size: 16px; line-height: 20px;color: #262626;font-family: 'Myriad Pro Bold';">COURIER</span>
                    </li>
                    <li style="float: left;border-right: 2px solid #191919;list-style-type: none; padding: 10px 15px 9px; ">
                        <figure style="float: left; margin: 5px 0;">
                            <img src="{{asset('assets/images/scan.png')}}" alt="scan image" style="width: 100%; height: auto; display: block;">
                        </figure>
                        <span style="display: block; font-size: 10px; line-height: 14px; padding: 0 10px; color: #262626;font-family: 'Myriad Pro Semibold';">ORDER ID #{{$order->order_id}}</span>
                    </li>
                    <li style="float: left; padding: 1px 0;border-right: 2px solid #191919;list-style-type: none;">
                        <span style="display: block;font-size: 14px; border-bottom: 2px solid #191919; line-height: 17px; padding: 5px 10px 4px; font-family: 'Myriad Pro Semibold';">Date</span>
                        <span style="display: block;font-size: 14px; border-bottom: 2px solid #191919; line-height: 17px; padding: 5px 10px 4px; font-family: 'Myriad Pro Semibold';">Service</span>
                        <span style="display: block;font-size: 14px; line-height: 17px; padding: 5px 10px 4px; font-family: 'Myriad Pro Semibold';">Origin</span>

                    </li>
                    <li  style="float: left; padding: 1px 0;border-right: 2px solid #191919;list-style-type: none;">
                        <span style="display: block;font-size: 14px; border-bottom: 2px solid #191919; line-height: 17px; padding: 5px 10px 4px; font-family: 'Myriad Pro Semibold';">{{$date}}</span>
                        <span style="display: block;font-size: 14px; border-bottom: 2px solid #191919; line-height: 17px; padding: 5px 10px 4px; font-family: 'Myriad Pro Semibold';">OVERNIGHT</span>
                        <span style="display: block;font-size: 14px; line-height: 17px; padding: 5px 10px 4px; font-family: 'Myriad Pro Semibold';">KARACHI</span>
                    </li>
                    <li  style="float: left; padding: 0 ;list-style-type: none;">
                        <span style="display: block;font-size: 14px; border-bottom: 2px solid #191919; line-height: 17px; padding: 5px 10px 5px; font-family: 'Myriad Pro Semibold'; width: 255px">Time {{$time}}</span>
                        <span style="display: block; padding: 14px 0;"></span>
                        <span style="display: block;">
							<span style="float: left;font-size: 14px; line-height: 17px; padding: 5px 93px 4px 10px; font-family: 'Myriad Pro Semibold';">Destination</span>
							<span style="float: right; font-size: 14px; line-height: 17px; padding: 5px 10px 4px; font-family: 'Myriad Pro Semibold';">{{ucwords($order->dispatch_to)}}</span>
						</span>
                    </li>
                </ul>
                <ul style="width: 100%; float: left; margin: 0; padding: 0; list-style: none;border-bottom: 2px solid #191919;">
                    <li style="float: left; padding: 20px 0; text-align: center; width: 296px; list-style-type: none;">
                        <span style="display: block; font-size: 24px; line-height: 27px; color :#262626">{{$order->shop_name}}</span>
                    </li>
                    <li  style="float: left; padding: 0;list-style-type: none; width: 355px;">
                        <span style="float: left;font-size: 14px; line-height: 17px; padding: 5px 20px; font-family: 'Myriad Pro Semibold'; border-right: 2px solid #191919; border-left: 2px solid #191919; border-bottom: 2px solid #191919;">Consignee</span>
                        <span style="float: left;font-size: 14px; line-height: 17px; padding: 5px 10px; font-family: 'Myriad Pro Semibold';">{{$order->name}}</span>
                    </li>
                    <li  style="float: left; padding: 10px 0 0;list-style-type: none; width: 355px; border-left: 2px solid #191919; ">
                        <span style="float: left;font-size: 14px; line-height: 17px; padding: 5px 0 4px 10px; font-family: 'Myriad Pro Semibold';">Address : Deliver at :  {{$order->address}} .</span>
                    </li>
                </ul>
                <ul style="width: 100%; float: left; margin: 0; padding: 0; list-style: none;border-bottom: 2px solid #191919; ">
                    <li  style="width: 35.4%; float: left; padding: 13px 5px;border-right: 2px solid #191919;list-style-type: none;">
						<span style="display: block;font-size: 14px; line-height: 17px; padding: 5px 0 4px 10px; font-family: 'Myriad Pro Semibold';">Office#1015, 5th floor Muhammadi Trade Tower
							new chali road near Technocity. KHI
							02132371000 0341 9300003
						</span>
                    </li>
                    <li  style="float: left; padding:  0;border-right: 2px solid #191919;list-style-type: none;">
                        <span style="display: block;font-size: 14px; line-height: 17px; padding: 5px 19px 5px 20px;border-bottom: 2px solid #191919; font-family: 'Myriad Pro Semibold';">QTY</span>
                        <span style="display: block;font-size: 28px; line-height: 31px; padding: 13px 24px; font-family: 'Myriad Pro Semibold';">{{$order->quantity}}</span>
                    </li>
                    <li  style="float: left; padding:  0;border-right: 2px solid #191919;list-style-type: none;">
                        <span style="display: block;font-size: 14px; line-height: 17px; padding: 5px 1px;border-bottom: 2px solid #191919; font-family: 'Myriad Pro Semibold';">Contact Number</span>
                        <span style="display: block;font-size: 14px; line-height: 17px; padding: 20px 7px; font-family: 'Myriad Pro Semibold';">COD AMOUNT</span>
                    </li>
                    <li  style="float: left; padding: 0; list-style-type: none;">
                        <span style="display: block;font-size: 14px; line-height: 17px; padding: 5px 20px; font-family: 'Myriad Pro Semibold';border-bottom: 2px solid #191919;width: 236px;">{{$number}}</span>
                        <em style="display: block; font-style: normal; text-align: center; font-size: 9px; line-height: 17px; padding: 5px 0 4px 10px; font-family: 'Myriad Pro Semibold';">
                            <span style="display: block;font-size: 28px; line-height: 31px; padding: 0; font-family: 'Myriad Pro Semibold';">{{$order->price}}</span>
{{--                                                    THREE THOUSAND THREE HUNDERND FIFTY RUPEES ONLY--}}
                        </em>
                    </li>
                </ul>
                <ul style="width: 100%; float: left; margin: 0; padding: 0; list-style: none;">
                    <li style="float: left; padding: 1px 0; list-style-type: none;border-right: 2px solid #191919;">
                        <span style="display: block;font-size: 21px; text-align: center; line-height: 24px; padding: 5px; font-family: 'Myriad Pro Semibold'; border-bottom: 2px solid #191919;">Product <span style="display: block;">Detail</span></span>
                        <span style="display: block;font-size: 14px; line-height: 17px; padding: 5px; font-family: 'Myriad Pro Semibold'; border-bottom: 2px solid #191919;">Remarks</span>
                        <span style="display: block;font-size: 14px; line-height: 17px; padding: 5px; font-family: 'Myriad Pro Semibold'; ">ORDER ID#</span>
                    </li>
                    <li style="float: left; padding: 1px 0; list-style-type: none;">
                        <span style="display: block; padding: 10px;min-height: 60px; width: 567px; border-bottom: 2px solid #191919;">{{$order->product}}</span>
                        <span style="display: block;font-size: 14px; line-height: 17px; padding: 5px 10px; font-family: 'Myriad Pro Semibold'; border-bottom: 2px solid #191919;">{{$order->dispatch_remark}}</span>
                        <span style="display: block;font-size: 14px; line-height: 17px; padding: 5px 10px; font-family: 'Myriad Pro Semibold';">{{$order->id}}</span>
                    </li>
                </ul>
            </div>
        </div>
        <!--************************************
                Tcs invoice main End
        *************************************-->
    </div>
@endif
<div class="content-area at-haslayout">
    <div class="container">
        <div class="row">
            <div class="col">
                {{--<div class="page-header">
          </div>--}}
                <div class="card invoicecard">
                    @if($order->dispatch_by == 'Tcs')
                        <div class="exportinvoice" style="overflow: hidden; margin: 30px 0; padding-bottom: 30px; border-bottom: 2px dashed #000; ">
                            <iframe src="https://envio.tcscourier.com/BookingReportPDF/GenerateLabels?consingmentNumber={{$order->cn}}&printType=2" height="352" width="700" title="Invoice"></iframe>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                    <!--************************************
                            naviforce Start
                    *************************************-->
                    <div class="at-haslayout">
                        <!--************************************
                                header start
                        *************************************-->
                        <header class="at-header">
                            <div class="at-topbar">
                                <strong class="at-logo">
                                    <a href="javascript: voidd(0);">
                                        <img src="{{asset('assets/images/logo.png')}}" alt="logo image">
                                    </a>
                                </strong>
                                <div class="at-headercontent">
                                    <span>021-32371000</span>
                                    <span>0341-9300003</span>
                                    <h2>ADDRESS: Office # 1015 5th
                                        <span>Floor Muhammad Trade Tower , </span>
                                        <span>Grant road Near Technocity karachi</span>
                                    </h2>
                                </div>
                                <strong class="at-benyarlogo">
                                    <a href="javascript:(0);">
                                        <img src="{{asset('assets/images/benyar.png')}}" alt="logo image">
                                    </a>
                                </strong>
                            </div>
                        </header>
                        <!--************************************
                                header end
                        *************************************-->
                        <!--************************************
                                main start
                        *************************************-->
                        <main class="at-main">
                            <div class="at-content">
                                <div class="at-bulidinvoiceholder">
                                    <ul>
                                        <li>
                                            <em>Billed To</em>
                                            <span>{{$order->name}}</span>
                                            <span>{{$order->address}}</span>
                                            <span>{{$order->city}}</span>
                                        </li>
                                        <li>
                                            <div class="at-invoice">
                                                <em>invoice number</em>
                                                <span>{{$order->order_id}}</span>
                                            </div>
                                            <div class="at-dateissues">
                                                <em>date of issue</em>
                                                <span>{{$date}}</span>
                                            </div>
                                        </li>
                                        <li class="at-invoicetotal">
                                            <em>invoice total</em>
                                            <span>{{$order->price}}.00 <em>PKR</em> </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="at-itemtable">
                                    <ul>
                                        <li>
                                            <span class="at-itemdescription">description</span>
                                            <span class="at-cost">cost</span>
                                            <span class="at-qauntity">qty</span>
                                            <span class="at-totalamount">amount</span>
                                        </li>
                                        @forelse($invoices as $invoice)
                                            <li>
							<span class="at-itemdescription">{{$invoice->name}}
							</span>
                                                <span class="at-cost at-padding">{{$invoice->price}}</span>
                                                <span class="at-qauntity at-padding">{{$invoice->quantity}}</span>
                                                <span class="at-totalamount at-padding">{{$invoice->price*$invoice->quantity}}</span>
                                            </li>
                                        @empty
                                        @endforelse

                                    </ul>
                                </div>
                                <div class="at-decription">
                                    <p>
                                        only one year machine warranty your watch carries a 1 warranty  against any defect of
                                        manufacturing battery ,glass,strap,stone  are not included the warranty is no valid in
                                        case of accident our undue opening.
                                    </p>
                                </div>
                            </div>
                        </main>
                        <!--************************************
                            main End
                        *************************************-->
                    </div>
                    <!--************************************
                            naviforce End
                    *************************************-->
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.js')
