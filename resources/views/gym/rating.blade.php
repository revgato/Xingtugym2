@extends('layout.app')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row mt-5">
            <div class="form-box-space position-modify">
                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <textarea class="col-lg-10 margin-custom-rating-textbox" name="comment" id="comment-rating" cols="30" rows="10" placeholder="コメントを入力してください">

                    </textarea>
                    <div class="attachment-group">
                        <input id="attachment-input" type="file" name="image">
                        <label for="attachment-input" class="attachment-label"> <i id="attachment-link"
                                                                                   class="fa-solid fa-paperclip"></i></label>
                    </div>

                    <div class="star-group-space">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </form>
            </div>

            <div class="row-pool-rating-btn d-flex justify-content-around mt-5">
                <div class="gym-rating-box col-lg-4 d-flex">
                    <p class="font-size-custorm-text">プール：</p>
                    <div class="star-group-rating-space">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>

                <button type="button" class="btn btn-primary col-lg-2 btn-green-color" onclick="">レビュー</button>

            </div>

            {{--            phần tử review kết quả--}}
            @foreach($gym_ratings as $gym_rating)
                <hr class="col-lg-11 mt-5">
                <div class="content-review-element">
                    <div class="content-review-wrapper">
                        <div class="gym-review-text d-flex justify-content-between">
                            <div class="avatar-group">
                                <div class="avatar-circle">
                                    <img src="https://antimatter.vn/wp-content/uploads/2022/11/hinh-anh-avatar-nam.jpg" alt="Avatar">
                                </div>
                                <p class="font-size-custorm-text mt-5">名前</p>
                                <div class="star-group-review-space">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>

                            </div>
                            <div class="review-content-span ms-5">
                                <p class="font-size-custorm-text mt-5">レビューの内容</p>
                            </div>
                        </div>

                        <div class="gym-review-box col-lg-4 d-flex">
                            <p class="font-size-custorm-text">プール：</p>
                            <div class="star-group-review-space">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </div>

                        <div class="review-datetime-space d-flex">
                            <p class="font-size-custorm-text">投稿日：</p>
                            <p class="font-size-custorm-text">2023年６月２０日</p>

                        </div>
                    </div>

                    <div class="review-content-image d-flex flex-wrap justify-content-around mb-5 col-lg-9 margin-left-custom">
                        @foreach($image_rating as $image)
                            <div class="image-review-box" style="margin-bottom: 25px">
                                <img src="{{$image}}" alt="image" width="300px" height="300px">
                            </div>

                        @endforeach
                        <div class="like-dislike-wrapper d-flex justify-content-around">
                            <i class="fa-solid fa-thumbs-up icon-like-dislike"></i>
                            <i class="fa-solid fa-thumbs-down icon-like-dislike"></i>
                        </div>

                    </div>

                    <hr class="col-lg-11 margin-top-custom-hr">
                </div>
            @endforeach

        </div>
        {{--Tạo đường link phân trang cho danh sách nhà hàng--}}
        <div class="pagination mt-4">

            @if ($gym_ratings->currentPage() > 1)
                <a href="{{ $gym_ratings->previousPageUrl() }}" class="page-link">前</a>
            @endif

            @for ($i = 1; $i <= $gym_ratings->lastPage(); $i++)
                <a href="{{$gym_ratings->url($i)  }} " class="page-link{{ ($gym_ratings->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
            @endfor

            @if ($gym_ratings->hasMorePages())
                <a href="{{ $gym_ratings->nextPageUrl() }}" class="page-link">次</a>
            @endif
        </div>


        {{--        <div>--}}
        {{--            <label for="attachment">Kí hiệu đính kèm:</label>--}}
        {{--            <i id="attachment-link" class="fa-solid fa-paperclip"></i>--}}
        {{--        </div>--}}


    </div>
    <style>

        .position-modify {
            position: relative;
        }

        .margin-custom-rating-textbox {
            margin-left: 105px;
            margin-top: 80px;
            border: 2px solid #a00d0d;
            border-radius: 8px;
        }

        .margin-custom-rating-textbox:focus {
            background-color: #f4e9bc;
        }

        #attachment-input {
            display: none;
        }

        .attachment-group {
            width: 50px;
            height: auto;
            position: absolute;
            bottom: 40px;
            right: 175px;
            font-size: 2rem;
        }

        .star-group-space {
            position: absolute;
            bottom: 40px;
            right: 280px;
            font-size: 2rem;
        }

        .star-group-rating-space {
            font-size: 2rem;
        }


        .font-size-custorm-text {
            font-size: 2rem;
        }

        .btn-green-color {
            background-color: #12c4c8;
        }

        .btn-green-color:hover {
            background-color: #99f0f1;
        }


        hr {
            margin: 50px 50px;
            border: 2px solid #a00d0d;
            width: 80%;
        }

        .content-review-wrapper {
            position: relative;

        }

        .gym-review-box {
            position: absolute;
            top: 5px;
            right: 5px;
        }

        .star-group-review-space {
            font-size: 2rem;
        }

        .gym-review-text {
            font-size: 1.5rem;
            width: 700px;
            height: auto;
            margin-top: 50px;
            margin-left: 50px;
            text-align: center;
        }

        .review-datetime-space {
            position: absolute;
            top: 80px;
            right: 129px;
        }

        .avatar-circle {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background-color: #000;
            overflow: hidden; /* Đảm bảo hình ảnh không vượt ra khỏi khung */
        }

        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Đảm bảo hình ảnh được hiển thị đầy đủ trong khung */
        }

        .margin-left-custom {
            margin-left: 300px;
            margin-top: -120px;
        }


        .icon-like-dislike {
            font-size: 3rem;
        }

        .review-content-image {
            position: relative;

        }

        .like-dislike-wrapper {
            width: 200px;
            position: absolute;
            bottom: -100px;
            right: 0;
        }

        .image-review-box {
            width: 300px;
            height: 300px;
            border: 2px solid #a00d0d;
            border-radius: 8px;
            overflow: hidden;
        }

        .margin-top-custom-hr {
            margin-top: 200px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 100px;
            margin-bottom: 100px;
        }
    </style>

    <script>
        $(document).ready(function () {
            $('#attachment-link').onclick(function () {
                $('#attachment-input').click();
            });
        });
@endsection

