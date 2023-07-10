@extends('layout.app')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div id="gym-slider mt-4" class="col-lg-5">
                {{--                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">--}}
                {{--                    <div class="carousel-inner">--}}
                {{--                        <div class="carousel-item active">--}}
                {{--                            <img class="d-block w-100" src="{{$gym_imgs[0]}}" alt="First slide">--}}
                {{--                        </div>--}}
                {{--                        <div class="carousel-item">--}}
                {{--                            <img class="d-block w-100" src="{{$gym_imgs[1]}}" alt="Second slide">--}}
                {{--                        </div>--}}
                {{--                        <div class="carousel-item">--}}
                {{--                            <img class="d-block w-100" src="{{$gym_imgs[2]}}" alt="Third slide">--}}
                {{--                        </div>--}}
                {{--                    </div>--}}

                {{--                </div>--}}


                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{$gym_imgs[0]}}" class="d-block w-100" alt="First img">
                        </div>
                        <div class="carousel-item">
                            <img src="{{$gym_imgs[1]}}" class="d-block w-100" alt="Second img">
                        </div>
                        <div class="carousel-item">
                            <img src="{{$gym_imgs[2]}}" class="d-block w-100" alt="Third img">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <div class="image-box d-flex justify-content-between mt-4">
                    <div class="image-box-item" style="width: 33%">
                        <img src="{{$gym_imgs[0]}}" alt="First slide">
                    </div>
                    <div class="image-box-item" style="width: 32%">
                        <img src="{{$gym_imgs[1]}}" alt="Second slide">
                    </div>
                    <div class="image-box-item" style="width: 32%">
                        <img src="{{$gym_imgs[2]}}" alt="Third slide">
                    </div>

                </div>
            </div>

            <div class="gym-info col-lg-7 padding-left-modify">
                <h4>ジムルーム情報</h4>
                <div class="gym-rating-group d-flex justify-content-between">
                    <div class="gym-review">
                        <p>ジム評価</p>
                        <div class="gym-rating">
                            <p>{{$gym->rating}}</p>

                        </div>

                    </div>

                    @if($gym->pool == 1)
                        <div class="pool-review">
                            <p>プール評価</p>
                            <div class="pool-rating">
                                {{$poolAverageRating}}
                            </div>
                        </div>
                    @endif
                </div>
                <p>ジム名：{{$gym->name}}</p>
                <p>住所：{{$gym->address}}</p>
                <p>ジムオーナー：{{$owner->name}}</p>
                <p>電話番号：{{$owner->phone}}</p>
                <p>登録価格：{{$gym->price}}</p>

                <button type="button" class="btn btn-primary">レビューを表示して書く</button>
            </div>
        </div>

    </div>

    <style>
        .carousel-inner {
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, .6);
        }


        .image-box {
            /*border: 2px solid #3e3b3b;*/
            padding: 10px 0;
            height: auto;
            position: relative;
        }

        .image-box-item {
            padding: 0 10px;
            height: 120px;
        }

        .image-box-item img {
            width: 100%;
            height: 120px;
            /*object-fit: cover;*/
        }

        .carousel-item img {
            width: 95%;
            height: 400px;
            object-fit: cover;
        }

        .carousel-control-prev-icon, .carousel-control-next-icon {
            width: 40px;
            height: 40px;
            background-color: #000;
            border-radius: 50%;
            border: 1px solid #fff;
        }

        .padding-left-modify {
            padding-left: 45px;
        }

        .gym-info h4 {
            font-size: 2.5rem;
            font-weight: bold;
        }
    </style>
@endsection
