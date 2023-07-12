@extends('layout.app')

@section('content')
<div class="container-fluid mt-5 padding-left-custom">
    <div class="row mt-5">
        <div class="form-box-space position-modify">
            <form method="POST" action="" enctype="multipart/form-data">
                @csrf
                <textarea class="col-lg-10 margin-custom-rating-textbox" name="comment" id="comment-rating" cols="30" rows="10" placeholder="コメントを入力してください">

                    </textarea>
                <div class="attachment-group">
                    <input id="attachment-input" type="file" name="image">
                    <label for="attachment-input" class="attachment-label"> <i id="attachment-link" class="fa-solid fa-paperclip"></i></label>
                </div>
                <input type="hidden" name="rating" id="rating-input">
                <div class="star-group-space">
                    <i class="input-rating fa-solid fa-star" onclick="selectStar(1)"></i>
                    <i class="input-rating fa-solid fa-star" onclick="selectStar(2)"></i>
                    <i class="input-rating fa-solid fa-star" onclick="selectStar(3)"></i>
                    <i class="input-rating fa-solid fa-star" onclick="selectStar(4)"></i>
                    <i class="input-rating fa-solid fa-star" onclick="selectStar(5)"></i>
                </div>
            </form>
        </div>
        <div class="row-pool-rating-btn d-flex justify-content-around mt-5">
            <div class="gym-rating-box col-lg-4 d-flex">
                @if($gym->pool == 1)

                <p class="font-size-custom-text">プール：</p>
                <div class="star-group-rating-space">
                    <i class="fa-solid fa-star" style="line-height: 48px;"></i>
                    <i class="fa-solid fa-star" style="line-height: 48px;"></i>
                    <i class="fa-solid fa-star" style="line-height: 48px;"></i>
                    <i class="fa-solid fa-star" style="line-height: 48px;"></i>
                    <i class="fa-solid fa-star" style="line-height: 48px;"></i>
                </div>
                @endif
            </div>
            <button type="button" class="btn btn-primary col-lg-2 btn-green-color" onclick="">レビュー</button>

        </div>
        <hr class="col-lg-11 mt-5">

        {{-- phần tử review kết quả--}}
        @foreach($reviews as $review)
        <div class="content-review-element">
            <div class="content-review-wrapper">
                <div class="gym-review-text d-flex justify-content-between">
                    <div class="avatar-group col-lg-4">
                        <div class="avatar-circle">
                            <img src="{{ $review->userAvatar }}" alt="Avatar">
                        </div>
                        <p class="font-size-custom-text mt-5">{{ $review->userName }}</p>
                        <div class="star-group-review-space">
                            <div class="star-group">
                                @for ($i = 1; $i <= 5; $i++) @if ($review->rating >= $i)
                                    <i class="fas fa-star"></i>
                                    @else
                                    <i class="far fa-star"></i>
                                    @endif
                                    @endfor
                            </div>
                        </div>

                    </div>
                    <div class="review-content-span ms-5">
                        <p class="font-size-custom-text mt-5">{{ $review->review}}</p>
                    </div>
                </div>

                @if($review->pool_rating != null)
                <div class="gym-review-box col-lg-4 d-flex">
                    <p class="font-size-custom-text">プール：</p>
                    @for ($i = 1; $i <= 5; $i++) @if ($review->pool_rating >= $i)
                        <i class="fas fa-star custom-star-rating-review"></i>
                        @else
                        <i class="far fa-star custom-star-rating-review"></i>
                        @endif
                        @endfor
                </div>
                @endif

                <div class="review-datetime-space d-flex">
                    <p class="font-size-custom-text">投稿日：</p>
                    <p class="font-size-custom-text">{{ $review->created_at }}</p>
                </div>
            </div>

            <div class="review-content-image d-flex flex-wrap justify-content-start mb-5 col-lg-9 margin-left-custom">
                @foreach($review->ImagesReview as $image)
                <div class="image-review-box mx-5" style="margin-bottom: 25px">
                    <img src="{{$image->image_url}}" alt="image" width="300px" height="300px">
                </div>
                @endforeach

                <div class="like-dislike-wrapper d-flex justify-content-around">
                    {{ $review->like}}
                    @if($review->liked == 1)
                    <i class="fa-solid fa-thumbs-up icon-like-dislike" style="color :blue"></i>
                    @else
                    <i class="fa-solid fa-thumbs-up icon-like-dislike"></i>
                    @endif

                    {{ $review->dislike}}
                    @if($review->dislikes == 1)
                    <i class="fa-solid fa-thumbs-down icon-like-dislike" style="color :blue"></i>
                    @else
                    <i class="fa-solid fa-thumbs-down icon-like-dislike"></i>
                    @endif
                </div>

            </div>

            <hr class="col-lg-11 margin-top-custom-hr">
        </div>
        @endforeach

    </div>




</div>
<style>
    .padding-left-custom {
        padding-left: 50px;
    }

    .fas {
        color: #cccc04;
    }

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
        line-height: 48px;
    }


    .font-size-custom-text {
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
        overflow: hidden;
        /* Đảm bảo hình ảnh không vượt ra khỏi khung */
    }

    .avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Đảm bảo hình ảnh được hiển thị đầy đủ trong khung */
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

    .custom-star-rating-review {
        font-size: 2rem;
    }

    i.fas.fa-star.custom-star-rating-review {
        line-height: 48px;
    }

</style>

<script>
    $(document).ready(function() {
        $('#attachment-link').onclick(function() {
            $('#attachment-input').click();
        });
    });

    function selectStar(rating) {
        // Cập nhật giá trị số sao vào input hidden
        document.getElementById('rating-input').value = rating;

        // Đổi màu ngôi sao dựa trên số sao được chọn
        const stars = document.getElementsByClassName('input-rating');
        for (let i = 0; i < stars.length; i++) {
            if (i < rating) {
                stars[i].style.color = '#cccc04'; // Màu sao được chọn
            } else {
                stars[i].style.color = 'gray'; // Màu sao không được chọn
            }
        }
    }
</script>
@endsection
