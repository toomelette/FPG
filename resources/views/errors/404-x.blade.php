<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Swep | 404</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  @include('layouts.css-plugins')

</head>

<body class="hold-transition">
  <div class="wrapper" style="background-color: #ecf0f5; padding-top:50px ">
    <div class="container">
      <section class="content">
        <div style="width: 100%; overflow: auto">
          <div style="width: 30% ; float: left">
            <img style="width: 70%; float: right" src="{{asset('images/sra.png')}}">
          </div>
          <div style="width: 69% ; float: right">
            <h1 class="headline text-yellow" style="font-size: 72px; margin-top: 0px"> 404</h1>
            <div class="error-content">
              <h3>Oops! Page not found.</h3>
              <p>
                We could not find the page you were looking for.
                Meanwhile, you may return to Home Page.
                <br>
                {{ $exception->getMessage()}}
              </p>
              <a class="btn btn-sm btn-warning" href="{{ URL::previous() }}">Go Back!</a>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</body>
</html>
