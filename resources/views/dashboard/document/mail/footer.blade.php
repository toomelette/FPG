<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            font-family: Arial;
        }
        .button {
            border: none;
            color: white;
            padding: 8px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius : 5px;
        }
        a.button{
            color: white !important;
        }
        .button1 {background-color: #04AA6D;} /* Green */
        .button2 {background-color: #008CBA;} /* Blue */
    </style>
</head>
<body>
<br><br>
<hr>
<p>Kindly acknowledge receipt of this email by clicking the button below:</p>

<a href="{{route('dashboard.document.received',$slug)}}" target="_blank" class="button button1">Acknowledge receipt of email</a>
<br><br>
<a href="{{route('dashboard.document.received',$slug)}}" target="_blank">Click here if the button does not work.</a>

</body>
</html>
