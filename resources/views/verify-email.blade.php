<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
            .my-button{
              font-family: Roboto-Regular,Helvetica,Arial,sans-serif;
              display: inline-block;
              text-align: center;
              text-decoration: none;
              height: 36px;
              line-height: 36px;
              padding-left: 8px;
              padding-right: 8px;
              min-width: 88px;
              font-size: 14px;
              font-weight: 400;
              color: #ffffff;
              background-color: #4184f3;
              border-radius: 2px;
              border-width: 0px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <h2>Xác nhận đăng ký tài khoản</h2>
                <p>{{$name}} vừa đăng ký tài khoảng ở trang localhost,nếu email này là của bạn hãy bấm vào link dưới để xác thực</p>
                <p>Cảm ơn</p>
                <form class="" action="http://localhost:8000/verify-user" method="post">
                  <input type="hidden" name="code" value="{{$code}}">
                  <button class="my-button" type="submit" name="button">Bấm vào đây để xác thực</button>
                </form>
            </div>
        </div>
    </body>
</html>
