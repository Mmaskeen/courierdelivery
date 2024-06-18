<html xmlns="http://www.w3.org/1999/xhtml">
@include('layouts.css')
@yield('style')
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        .tab {
            border-color: gray;
            border-width: 1px 1px 0px 0px;
            border-style: solid;
            width: 700px;
        }

        .tdl {
            border-color: gray;
            border-width: 0px 0px 1px 1px;
            border-style: solid;
            margin: 0;
            padding: 4px;
        }

        .tdl1 {
            border-color: gray;
            border-width: 0px 0px 0px 1px;
            border-style: solid;
            margin: 0;
            padding: 4px;
        }

        /* (A) IMAGE WATERMARK */
        .watermark tbody {
            width: 100%;
        }

        .watermark {
            position: relative;
        }

        .watermark::after {
            content: "BLUE TRUNK";
            position: absolute;
            bottom: 20%;
            top: 15%;
            right: 20%;
            left: 20%;
            text-align: center;
            opacity: 0.3;
            transform: rotate(-20deg);
            font-size: 5em;
            color: gray;

        }

        /* (A) IMAGE WATERMARK 2*/
        .watermark2 tbody {
            width: 100%;
        }

        .watermark2 {
            position: relative;
        }

        .watermark2::after {
            content: "PRIORITY DELIVERY";
            position: absolute;
            bottom: 20%;
            top: 30%;
            right: 20%;
            left: 20%;
            text-align: center;
            opacity: 0.3;
            transform: rotate(-20deg);
            font-size: 5em;
            color: gray;

        }
        table {
            color: black;
        }
    </style>
    <script type="text/javascript" src="{{ asset("js/jquery/jquery.1.4.2.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("js/jquery-barcode.js") }}"></script>
    <script type="text/javascript" src="{{ asset("js/qrcode.js") }}"></script>
    <title>blueEX Consignment Notes</title>
</head>

<body>
    <div class="content-area at-haslayout">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card invoicecard">
                        <div>
                            <script type="text/javascript">
                                $(document).ready(
                                    function() {
                                        $("#barcodea" + "{{$order->cn}}").html("").show().barcode("{{$order->cn}}", "code128", {
                                            showHRI: true,
                                            barHeight: 25
                                        });
                                        $("#barcodeb" + "{{$order->cn}}").html("").show().barcode("{{$order->cn}}", "code128", {
                                            showHRI: true,
                                            barHeight: 25
                                        });
                                        $("#barcodec" + "{{$order->cn}}").html("").show().barcode("{{$order->cn}}", "code128", {
                                            showHRI: true,
                                            barHeight: 25
                                        });
                                        $("#barcoded" + "{{$order->cn}}").html("").show().barcode("{{$order->cn}}", "code128", {
                                            showHRI: true,
                                            barHeight: 25
                                        });
                                        var create_qrcode = function(text, typeNumber, errorCorrectLevel, table) {
                                            var qr = qrcode(typeNumber || 4, errorCorrectLevel || 'M');
                                            qr.addData(text);
                                            qr.make();
                                            return qr.createImgTag();
                                        };
                                        var clnk = "http://benefit.blue-ex.com/qtrack.php?type=C&cnno=" + "{{$order->cn}}";
                                        var slnk = "http://benefit.blue-ex.com/qtrack.php?type=S&cnno=" + "{{$order->cn}}";
                                        $("#qrcode").html(create_qrcode(clnk));
                                        $("#qrcodea").html(create_qrcode(slnk));
                                    });
                            </script>

                            <table style="display:flex;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="tab" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="3" class="tdl" width="120px">&nbsp;<img
                                                                src="{{ asset('assets/images/BlueExlogo.png') }}" height="33"
                                                                width="90"><br><span
                                                                style="font-size:10px; ">&nbsp;&nbsp; UNS
                                                                Ltd Co.</span></td>
                                                        <td rowspan="3" valign="bottom" width="85" class="tdl"
                                                            align="center">
                                                            <div id="barcodea{{ $order->cn }}"
                                                                style="padding: 0px; overflow: auto; width: 110px;">

                                                            </div>
                                                            <span style="font-size:9px;">Consignee Copy</span>
                                                        </td>
                                                        <td class="tdl" width="60">Date</td>
                                                        <td class="tdl">{{ date('d/m/Y', strtotime($order->created_at)) }}</td>
                                                        <td class="tdl">Serving City</td>
                                                        <td class="tdl">{{ $order->dispatch_to }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl">Pieces</td>
                                                        <td class="tdl">{{ $order->quantity }}</td>
                                                        <td class="tdl">Weight</td>
                                                        <td class="tdl"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl">Cash</td>
                                                        <td class="tdl">Rs.{{ $order->price + 150 }}/-</td>
                                                        <td class="tdl">Destination</td>
                                                        <td class="tdl">AKR</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl">&nbsp;Shipper</td>
                                                        <td colspan="2" class="tdl1"><b>&nbsp;Naviforce/benyar</b>
                                                        </td>
                                                        <td class="tdl">&nbsp;Consignee</td>
                                                        <td colspan="2" class="tdl1">&nbsp;Test2</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="tdl" valign="top" width="290">
                                                            Office no. 1015, 10th floor, muhammadi trade tower nearby
                                                            technosity main new challi karachi.
                                                            <br>
                                                            03419300003
                                                            <br>
                                                            watchzone.pk@gmail.com
                                                        </td>
                                                        <td colspan="3" class="tdl" width="340">
                                                            Nam blanditiis aut s
                                                            <br>
                                                            03008777778
                                                            <br>
                                                            pupov@mailinator.com
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl">&nbsp;Product Detail</td>
                                                        <td class="tdl" colspan="5">
                                                            https naviforcewatches co product nf-7104-4 - (10) (PKR
                                                            10)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl">&nbsp;Remarks</td>
                                                        <td class="tdl" colspan="5">
                                                            No Ref:Ws38661do
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl">&nbsp;Service</td>
                                                        <td class="tdl" colspan="5">BLUE EDGE</td>
                                                    </tr>
                                                    <tr>

                                                        <td class="tdl">&nbsp;Disclaimer</td>
                                                        <td class="tdl" colspan="6"
                                                            style="font-size:13px; font-weight: bold;" align="right">
                                                            <span style="line-height:20px; align:right"></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <tbody>
                                    <tr>
                                        <td colspan="6">
                                            --------------------------------------------------------------------------------------------------------------------------
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <div class="at-haslayout">
                            <header class="at-header">
                                <div class="at-topbar">
                                    <strong class="at-logo">
                                        <a href="javascript: voidd(0);">
                                            <img src="{{ asset('assets/images/logo.png') }}" alt="logo image">
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
                                            <img src="{{ asset('assets/images/benyar.png') }}" alt="logo image">
                                        </a>
                                    </strong>
                                </div>
                            </header>
                            <main class="at-main">
                                <div class="at-content">
                                    <div class="at-bulidinvoiceholder">
                                        <ul>
                                            <li>
                                                <em>Billed To</em>
                                                <span>{{ $order->name }}</span>
                                                <span>{{ $order->address }}</span>
                                                <span>{{ $order->city }}</span>
                                            </li>
                                            <li>
                                                <div class="at-invoice">
                                                    <em>invoice number</em>
                                                    <span>{{ $order->order_id }}</span>
                                                </div>
                                                <div class="at-dateissues">
                                                    <em>date of issue</em>
                                                    <span>{{ $date }}</span>
                                                </div>
                                            </li>
                                            <li class="at-invoicetotal">
                                                <em>invoice total</em>
                                                <span>{{ $order->price }}.00 <em>PKR</em> </span>
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
                                                    <span class="at-itemdescription">{{ $invoice->name }}
                                                    </span>
                                                    <span class="at-cost at-padding">{{ $invoice->price }}</span>
                                                    <span
                                                        class="at-qauntity at-padding">{{ $invoice->quantity }}</span>
                                                    <span
                                                        class="at-totalamount at-padding">{{ $invoice->price * $invoice->quantity }}</span>
                                                </li>
                                            @empty
                                            @endforelse

                                        </ul>
                                    </div>
                                    <div class="at-decription">
                                        <p>
                                            only one year machine warranty your watch carries a 1 warranty against any
                                            defect of
                                            manufacturing battery ,glass,strap,stone are not included the warranty is no
                                            valid in
                                            case of accident our undue opening.
                                        </p>
                                    </div>
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
