<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>POS</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            /*background-image: url('bg/bg5.jpg');*/
            background-color: black;
            color: yellow;
            font-family: cursive;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
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
            font-size: 84px; /* Set font size */
            padding: 20px; /* Add padding for spacing */
            border: 5px solid orange; /* Yellow border */
            border-radius: 10px; /* Optional: Rounded corners */
            background-color: rgba(255, 165, 0, 0.2); /* Light yellow background */
            transition: all 0.3s ease; /* Smooth transition for hover effect */

        }
          .title:hover {
            border: 5px solid yellow; /* Change border color on hover */
            background-color: rgba(255, 255, 0, 0.2); /* Change background color on hover */
            cursor: pointer; /* Change cursor to pointer */
        }

          .links > a {
            color: floralwhite;
            padding: 0 30px;
            font-size: 27px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none; /* Change this to 'none' to remove the underline */
            text-transform: uppercase;
            border: 2px solid blue;
            border-radius: 5px;
            background-color: rgba(173, 216, 230, 0.2);
            display: inline-block;
            transition: background-color 0.3s, color 0.3s; /* Smooth transition */
        }

        .links > a:hover {
            background-color: blue; /* Change background on hover */
            color: white; /* Change text color on hover */
        }



        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
               <b>TasteSecure: Restaurant POS</b>
            </div>

            <div class="links">
                <h1>LOGIN AS</h1>
                <a href="pos/admin/">Admin</a>
                <a href="pos/cashier/">Cashier</a>
                <a href="pos/customer">Customer</a>
            </div>
        </div>
    </div>
</body>

</html>