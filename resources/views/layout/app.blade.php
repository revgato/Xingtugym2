<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Xingtu Gym</title>
  <link rel="stylesheet" href=" {{ asset('css/style.css') }}" />

  <!-- Toast Notification or use Toast in Laravel: https://viblo.asia/p/su-dung-sweetalert-trong-laravel-Qbq5QEk45D8-->
  <link rel="stylesheet" href=" {{ asset('css/notifications.css') }}" />
  <script src=" {{ asset('js/notifications.js') }}"></script>

  <!-- Sweet Alert or use SweetAlert in Laravel: https://viblo.asia/p/su-dung-sweetalert-trong-laravel-Qbq5QEk45D8 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

  <link href='https://fonts.googleapis.com/css?family=Architects Daughter' rel='stylesheet'>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script>
    var errorNotification = window.createNotification({
      closeOnClick: true,
      displayCloseButton: true,
      positionClass: "nfc-top-right",
      onclick: false,
      showDuration: 3500,
      theme: "error",
    });

    var warningNotification = window.createNotification({
      closeOnClick: true,
      displayCloseButton: true,
      positionClass: "nfc-top-right",
      onclick: false,
      showDuration: 3500,
      theme: "warning",
    });

    var successNotification = window.createNotification({
      closeOnClick: true,
      displayCloseButton: true,
      positionClass: "nfc-top-right",
      onclick: false,
      showDuration: 3500,
      theme: "success",
    });
  </script>
</head>

<body>
  @include('layout.header')
  @yield('content')
  @include('layout.footer')
</body>

</html>