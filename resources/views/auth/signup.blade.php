<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Xingtu Gym - ログイン</title>
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
    <style>
        .brand-name {
            font-family: 'Architects Daughter';
            font-size: 28px;
            display: inline-block;
        }

        .brand-name-light {
            font-weight: lighter;
        }

        .brand-name-bold {
            font-weight: bold;
        }

        .container-fluid {
            background-image: url('/images/pool_1.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
    </style>
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">

                </div>
                <div class=" card col-md-8 col-lg-6 col-xl-4 offset-xl-1 p-5">
                    <form method="POST" action="{{ route('signup') }}">
                        @csrf
                        <div class="d-flex flex-row align-items-center justify-content-center mb-5">
                            <a class="navbar-brand mx-4" href="/">
                                <span class="brand-name brand-name-light">Xingtu</span><span class="brand-name brand-name-bold">Gym</span>
                            </a>
                        </div>
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" style="font-weight: 600;">名前 (Họ tên)</label>
                            <input type="name" id="name" name="name" class="form-control form-control-lg" required />
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" style="font-weight: 600;">メール (E-Mail)</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label" style="font-weight: 600;">パスワード (Mật khẩu)</label>
                            <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label" style="font-weight: 600;">パスワードを確認する (Nhập lại mật khẩu)</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" required />
                        </div>
                        <div class="form-outline mb-3">
                            <label class="form-label" style="font-weight: 600;" for="role">{{ __('あなたは (Bạn là)') }}</label>
                            <select class="form-control form-control-lg" name="role" id="role">
                                <option value="user" selected>ユーザー (Người dùng)</option>
                                <option value="gym-owner">ジムのオーナー (Chủ phòng gym)</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="mb-0">

                            </div>
                            <a href="#" class="link">パスワードを忘れの方はこちら</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg w-100 " style="font-weight: 600; padding-left: 2.5rem; padding-right: 2.5rem;">サインアップ</button>

                            <p class="small fw-bold mt-2 pt-1 mb-0">アカウントを持っていますか？ <a href="/login" class="link-danger">ログイン</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>