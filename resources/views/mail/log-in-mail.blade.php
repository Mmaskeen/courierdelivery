<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TOP</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        html,
        body {
            color: #808080;
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            text-align: center;
            font: 400 15px/24px Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
        }
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        .ExternalClass {width: 100%;}
        div[style*="margin: 16px 0"] {margin: 0 !important;}
        table, td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {table-layout: auto;}
        img {
            -ms-interpolation-mode: bicubic;
            display: block;
        }
        .yshortcuts a {border-bottom: none !important;}
        a[x-apple-data-detectors] {color: inherit !important;}
    </style>
</head>
<body width="100%" bgcolor="#eee" style="margin: 0;">
<div style="width: 600px; margin: 0 auto; background: #fff; overflow: hidden;">
    <div style="width: 100%; float: left; padding: 50px 20px 20px; background: #fff !important; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;">
        <figure style="width:100%; float: left; text-align: center; margin: 0 0 40px;">
            <img src="{{asset('admin/assets/images/app-logo.png')}}" style="margin: 0 auto;" alt="image description">
        </figure>
        <h1 style="margin: 0 0 30px; font-size: 28px; line-height: 28px; font-weight: 400; color: #e3222a !important; text-align: center;">HI, {{$user->name}}</h1>
        <p style="margin: 0; font-size: 18px; line-height: 30px; text-align: center; color: #808080 ;">Welcome to the Digital Dealership System Sales Appointment System</p>
        <div style="width: 100%; float: left; text-align: center;">
            <ul style="padding: 0; float: left; width: 100%; list-style: none; margin: 30px 0; text-align: center;">
                <li style="color: #808080; padding: 5px 0; display: block; font-size: 18px; line-height: 21px; list-style-type: none;"><span style="color: #e3222a;">Email:</span>{{$user->email}}</li>
                <li style="color: #808080; padding: 5px 0; display: block; font-size: 18px; line-height: 21px; list-style-type: none;"><span style="color: #e3222a;">Password:</span><b></b></li>
            </ul>
            <a href="http://appointments.akkastechdemo.com/login" style="text-align:center; float:left; width: 100%; text-decoration:none; color:#e3222a; margin-bottom:35px; display:block;">Click Here to Login</a>
            <p style="margin: 0; font-size: 18px; line-height: 30px; text-align: center; color: #808080 ;">Email support@ddsmail.co for support. Do not reply this email for support.</p>

        </div>
    </div>
    <footer style="width:100%; float: left; padding: 0 20px 30px;">
        <p style="margin: 0; font-size: 12px; line-height: 13px; color: #003959; font-weight: 600;"><span style="margin: 0 6px; display: inline-block; vertical-align: top;">&copy; 2020 Digital Dealership System</span>-<a style="margin: 0 6px; display: inline-block; vertical-align: top; color: #e3222a; text-decoration: none;" href="javascript:void(0);">Privacy Policy</a>-<a style="margin: 0 6px; display: inline-block; vertical-align: top; color: #e3222a; text-decoration: none;" href="javascript:void(0);">Terms of Use</a></p>
    </footer>
</div>
</body>
</html>
