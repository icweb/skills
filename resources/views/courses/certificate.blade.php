<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Course Certificate</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <style>
        .certificate{
            border: 5px solid black;
            width: 10.45in;
            height: 7.65in;
            text-align: center;
            font-family:Nunito,sans-serif;
        }

        .certificate-title{
            font-size: 54px;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid black;
            padding: 50px 0;
            margin-bottom: 50px;
        }

        .certificate-author{
            text-align: center;
            font-size: 34px;
            padding: 20px 0;
            text-decoration: underline;
        }

        .certificate-subject{
            text-align: center;
            font-size: 34px;
            padding: 20px 0;
            text-decoration: underline;
        }

        .certificate-date{
            text-align: center;
            padding: 20px 0;
        }

        .certificate-small{
            font-size: 18px;
            padding: 20px 0 0 0;
        }

        .certificate-seal{
            text-align: left;
            padding-left: 50px;
        }

        .certificate-seal img{
            width: 100px;
        }

        .certificate-signature{
            float: right;
            margin-right: 20px;
            margin-top: 60px;
            text-align: right;
            width: 350px;
        }

        .certificate-signature div {

        }

        .certificate-signature img{
            width: 100px;
            margin-left: 10px;
            float: right;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="certificate-title">
            Certificate of Completion
            <br>
            <div class="certificate-small">
                {{ env('APP_NAME') }} Online Tracker<br>
                {{ env('APP_URL') }}
            </div>
        </div>
        <div class="certificate-author">
            {{ $name }}
        </div>
        <div class="certificate-small">
            completed the course
        </div>
        <div class="certificate-subject">
            {{ $subject }}
        </div>
        <div class="certificate-date small">
            on {{ $date }}
        </div>
        <div class="certificate-signature">
            <img src="{{ secure_asset('ssl.jpg') }}" alt="">
            <div>
                <small>Securely signed by</small><br>
                {{ env('APP_URL') }}<br>
                at {{ date('m/d/Y h:ia', time()) }}
            </div>
        </div>
        <div class="certificate-seal">
            <img src="{{ secure_asset('seal.png') }}" alt="">
        </div>
    </div>
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>