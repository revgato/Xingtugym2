@extends('layout.app')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div id="gym-slider mt-4" class="col-lg-5">

                {{--                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">--}}
                {{--                    <div class="carousel-inner">--}}
                {{--                        @foreach($gym_imgs as $gym_img)--}}
                {{--                            <div class="carousel-item active">--}}
                {{--                                <img src="{{$gym_img->image_url}}" class="d-block w-100" alt="First img">--}}
                {{--                            </div>--}}
                {{--                        @endforeach--}}
                {{--                    </div>--}}
                {{--                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"--}}
                {{--                            data-bs-slide="prev">--}}
                {{--                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>--}}
                {{--                        <span class="visually-hidden">Previous</span>--}}
                {{--                    </button>--}}
                {{--                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"--}}
                {{--                            data-bs-slide="next">--}}
                {{--                        <span class="carousel-control-next-icon" aria-hidden="true"></span>--}}
                {{--                        <span class="visually-hidden">Next</span>--}}
                {{--                    </button>--}}
                {{--                </div>--}}

                {{--                <div class="image-box d-flex justify-content-between mt-4">--}}
                {{--                    @foreach($gym_imgs as $gym_img)--}}
                {{--                        <div class="image-box-item" style="width: 33%;">--}}
                {{--                            <img src="{{$gym_img->image_url}}" alt="Slide" style="border: 5px solid #fff3cd">--}}
                {{--                        </div>--}}
                {{--                    @endforeach--}}

                {{--                </div>--}}
                {{--            </div>--}}

                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        @foreach($gym_imgs as $index => $gym_img)
                            <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                                <img src="{{$gym_img->image_url}}" class="d-block w-100" alt="Image {{$index}}">
                            </div>
                        @endforeach

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
                    @foreach($gym_imgs as $index => $gym_img)
                        <div class="image-box-item" style="width: 33%;">
                            <img src="{{$gym_img->image_url}}" alt="Slide" style="border: 5px solid #fff3cd">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="gym-info col-lg-7 padding-left-modify">
                <h4>ジムルーム情報</h4>
                <div class="gym-rating-group d-flex justify-content-between">
                    <div class="gym-review d-flex justify-content-between" style="width: 250px">
                        <p class="custom-space-text">ジム評価</p>
                        <div class="gym-rating d-flex">
                            <p class="custom-space-text" style="font-size: 1.5rem">{{$gym->rating}}</p>
                            <i class="fa-solid fa-star"
                               style="line-height: 36px; color: #cccc04; font-size: 1.5rem"></i>
                        </div>
                    </div>

                    @if($gym->pool == 1)
                        <div class="pool-review d-flex justify-content-between" style="width: 250px">
                            <p class="custom-space-text mr-4">プール評価</p>
                            <div class="pool-rating d-flex">
                                <p class="custom-space-text" style="font-size: 1.5rem">{{$gym->pool_rating}}</p>
                                <i class="fa-solid fa-star"
                                   style="line-height: 36px; color: #cccc04; font-size: 1.5rem"></i>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="datetime-login d-flex justify-content-around" style="width: 300px; margin-left: 400px">
                    <i class="fa-solid fa-circle" style="color: #8aeda1; line-height: 40px; font-size: 1.5rem"></i>
                    <p style="line-height: 40px; font-size: 1.5rem">{{$owner->last_login_at}}</p>
                </div>
                <p class="custom-space-text">Tên：{{$gym->name}}</p>
                <p class="custom-space-text">Địa chỉ：{{$gym->address}}</p>
                <p class="custom-space-text">Chủ phòng gym：{{$owner->name}}</p>
                <p class="custom-space-text">Số điện thoại：{{$owner->phone}}</p>
                <p class="custom-space-text">Phí dịch vụ(1 tháng)：{{$gym->price}}</p>
                <p class="custom-space-text">Dịch vụ đi kèm：
                    @if($gym->pool==1)
                        プール、
                    @endif
                    @if($gym->sauna == 1)
                        サウナ、
                    @endif
                    @if($gym->parking == 1)
                        駐車場
                    @endif</p>

                <button type="button" class="btn btn-primary custom-button-review">Hiển thị bình luận</button>
            </div>
        </div>

        <div class="row d-flex justify-content-around custom-space-top-btn">
            <button type="button" class="btn btn-danger col-lg-2">Xóa</button>
            <button type="button" class="btn btn-primary col-lg-2 btn-green-color" onclick="redirectUpdatePage()">Chỉnh sửa</button>
            <button type="button" class="btn btn-primary col-lg-2 btn-green-color">Tạm ngừng hoạt động</button>
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
            padding-left: 55px;
        }

        .gym-info h4 {
            font-size: 3.5rem;
            font-weight: bold;
        }

        .gym-rating-group {
            margin-top: 20px;
        }

        .custom-space-text {
            margin-bottom: 2rem;
            font-size: 1.5rem;
        }

        .custom-button-review {
            margin-top: 20px;
            margin-left: 120px;
            width: 500px;
            padding: 20px 0;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .custom-space-top-btn {
            margin-top: 100px;
            margin-bottom: 50px;
        }

        .custom-space-top-btn button {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-green-color {
            background-color: #12c4c8;
        }

        .btn-green-color:hover {
            background-color: #99f0f1;
        }
    </style>

    <script>
        function redirectUpdatePage() {
            window.location.href = "{{route('gym.edit')}}"
        }
    </script>
@endsection

