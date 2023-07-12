@extends('layout.app')

@section('content')
<div class="container-fluid mt-5 padding-left-custom">
    <div class="row mt-5">
        <h1 onclick="window.history.back()">{{ $gym->name }}</h1>
        @if(Auth::check() && Auth::user()->role == 'user')
        <div class="form-box-space position-modify">
            <form method="POST" action="{{ route('gym.review.stored',['gym' => $gym->id])}}" enctype="multipart/form-data">

                @csrf
                <textarea required class="col-lg-10 margin-custom-rating-textbox" name="review" id="comment-rating" cols="30" rows="10" placeholder="コメントを入力してください"></textarea>
                <div class="attachment-group">
                    <input id="attachment-input" name="file[]" type="file" class="file" multiple accept="image/*" />
                    <label for="attachment-input" class="attachment-label"> <i id="attachment-link" class="fa-solid fa-paperclip"></i></label>
                </div>
                <!-- IMAGE PREVIEW CONTAINER -->
                <div class="container-image d-flex justify-content-between"></div>
                <input type="hidden" name="rating" id="rating-input">
                <div class="star-group-space">
                    <i class="input-rating fa-solid fa-star" onclick="selectStar(1)"></i>
                    <i class="input-rating fa-solid fa-star" onclick="selectStar(2)"></i>
                    <i class="input-rating fa-solid fa-star" onclick="selectStar(3)"></i>
                    <i class="input-rating fa-solid fa-star" onclick="selectStar(4)"></i>
                    <i class="input-rating fa-solid fa-star" onclick="selectStar(5)"></i>
                </div>
        </div>
        <div class="row-pool-rating-btn d-flex justify-content-around mt-5">
            <div class="gym-rating-box col-lg-4 d-flex">
                @if($gym->pool == 1)
                <input type="hidden" name="pool_rating" id="pool-rating-input">
                <p class="font-size-custom-text">プール：</p>
                <div class="star-group-rating-space">
                    <i class="fa-solid fa-star custom-star-rating-review input-pool-rating" onclick="selectPoolStar(1)"></i>
                    <i class="fa-solid fa-star custom-star-rating-review input-pool-rating" onclick="selectPoolStar(2)"></i>
                    <i class="fa-solid fa-star custom-star-rating-review input-pool-rating" onclick="selectPoolStar(3)"></i>
                    <i class="fa-solid fa-star custom-star-rating-review input-pool-rating" onclick="selectPoolStar(4)"></i>
                    <i class="fa-solid fa-star custom-star-rating-review input-pool-rating" onclick="selectPoolStar(5)"></i>
                </div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary col-lg-2 btn-green-color">レビュー</button>
        </div>
        </form>
        @endif
        <hr class="col-lg-11 mt-5">

        {{-- phần tử review kết quả--}}
        @foreach($reviews as $review)
        <div class="content-review-element">
            <div class="content-review-wrapper">
                <div class="gym-review-text d-flex">
                    <div class="avatar-group d-flex flex-column justify-content-center align-items-center">
                        <div class="avatar-circle">
                            <img src="{{ $review->userAvatar }}" alt="Avatar">
                        </div>
                        <p class="font-size-custom-text mt-5">{{ $review->userName }}</p>
                        <div class="star-group-review-space">
                            <div class="star-group">
                                @for ($i = 1; $i <= 5; $i++) @if ($review->rating >= $i)
                                    <i class="fas fa-star star-yellow"></i>
                                    @else
                                    <i class="far fa-star star-yellow"></i>
                                    @endif
                                    @endfor
                            </div>
                        </div>

                    </div>
                    <div class="review-content-span ms-5">
                        <p class="font-size-custom-text mt-5 custom-margin-left-text-review">{{ $review->review}}</p>
                    </div>
                </div>

                @if($review->pool_rating != null)
                <div class="gym-review-box col-lg-4 d-flex">
                    <p class="font-size-custom-text">プール：</p>
                    @for ($i = 1; $i <= 5; $i++) @if ($review->pool_rating >= $i)
                        <i class="star-yellow fas fa-star custom-star-rating-review"></i>
                        @else
                        <i class="star-yellow far fa-star custom-star-rating-review"></i>
                        @endif
                        @endfor
                </div>
                @endif

                <div class="review-datetime-space d-flex">
                    <p class="font-size-custom-text">投稿日：</p>
                    <p class="font-size-custom-text">{{ $review->created_at }}</p>
                </div>
            </div>

            <div class="review-content-image d-flex flex-wrap justify-content-start mb-5 margin-left-custom">
                @foreach($review->ImagesReview as $image)
                <div class="image-review-box mx-2" style="margin-bottom: 25px">
                    <img src="{{$image->image_url}}" alt="image" width="100px" height="100px">
                </div>
                @endforeach

                <div class="like-dislike-wrapper d-flex justify-content-around">


                    @if(!Auth::check())
                    <i class="fa-solid fa-thumbs-up icon-like-dislike"></i>
                    <h1 style="margin-right : 15px">{{ $review->like}}</h1>
                    @else
                    @if($review->liked == 1)
                    <i class="fa-solid fa-thumbs-up icon-like-dislike" style="color :blue" onclick="like({{ $review->id }})"></i>
                    @else
                    <i class="fa-solid fa-thumbs-up icon-like-dislike" onclick="like({{ $review->id }})"></i>
                    @endif
                    <h1 style="margin-right : 15px">{{ $review->like}}</h1>
                    @endif


                    @if(!Auth::check())
                    <i class="fa-solid fa-thumbs-down icon-like-dislike"></i>
                    <h1>{{ $review->dislike}}</h1>
                    @else
                    @if($review->dislikes == 1)
                    <i class="fa-solid fa-thumbs-down icon-like-dislike" style="color :blue" onclick="dislike({{ $review->id }})"></i>
                    @else
                    <i class="fa-solid fa-thumbs-down icon-like-dislike" onclick="dislike({{ $review->id }})"></i>
                    @endif
                    <h1>{{ $review->dislike}}</h1>
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

    .star-yellow {
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
        font-size: 1.5rem;
        line-height: 48px;
    }

    .btn-green-color {
        background-color: #12c4c8;
        padding: 16px 5px;

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
        top: -72px;
        right: -46px;
    }

    .star-group-review-space {
        font-size: 2rem;
    }

    .gym-review-text {
        font-size: 1.5rem;
        width: 1200px;
        height: auto;
        margin-top: 50px;
        margin-left: 25px;
    }

    .review-datetime-space {
        position: absolute;
        top: -25px;
        right: 129px
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
        width: 100px;
        height: 100px;
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

    .fa-star:before {
        line-height: 48px;
    }

    .custom-margin-left-text-review {
        margin-left: 72px;
    }

    /*    phần CSS review box*/
    .container-image {
        margin-top: 10px;
        position: absolute;
        top: 180px;
        left: 160px;
    }

    .preview-image {
        width: 100px;
        height: 100px;
        margin-right: 10px;
        object-fit: cover;
        border: 1px solid #951e1e;
    }

    button.delete-button {
        position: absolute;
        right: 10px;
        color: #f4f0f0;
        background: #e61f1f;
        font-weight: bold;
    }

    .image-container {
        position: relative;
    }
</style>

<script>
    var imageIndex = 0;

    function deleteImage(button) {
        // Xóa ảnh khỏi preview
        var imageContainer = button.parentNode;
        imageContainer.remove();

        // Xóa ảnh khỏi files dựa vào chỉ số
        var imageIndex = imageContainer.querySelector('img').dataset.index;
        var fileInput = document.getElementById('attachment-input');
        if (fileInput.files.length > imageIndex) {
            var newFiles = [];
            for (var i = 0; i < fileInput.files.length; i++) {
                if (i != imageIndex) {
                    newFiles.push(fileInput.files[i]);
                }
            }
            // Tạo một đối tượng 'FileList' giả lập
            var dataTransfer = new DataTransfer();
            newFiles.forEach(function(file) {
                dataTransfer.items.add(file);
            });
            // Gán 'FileList' giả lập vào thuộc tính 'files' của phần tử input
            fileInput.files = dataTransfer.files;
        }

        // Cập nhật lại chỉ số của các ảnh còn lại
        var images = document.querySelectorAll('.container-image img');
        for (var i = 0; i < images.length; i++) {
            images[i].dataset.index = i;
        }
    }

    function createImagePreview(fileInput) {
        var containerImage = document.querySelector('.container-image');

        containerImage.innerHTML = '';
        for (var i = 0; i < fileInput.files.length; i++) {
            var file = fileInput.files[i];
            var reader = new FileReader();

            reader.onload = function(e) {
                var imageContainer = document.createElement('div');
                imageContainer.classList.add('image-container');

                var img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Image Preview';
                img.classList.add('preview-image');
                var deleteButton = document.createElement('button');
                deleteButton.classList.add('delete-button');
                deleteButton.textContent = 'X';
                deleteButton.addEventListener('click', function() {
                    deleteImage(this);
                });

                // Thêm chỉ số vào ảnh
                img.dataset.index = imageIndex;
                imageIndex++;

                imageContainer.appendChild(img);
                imageContainer.appendChild(deleteButton);

                containerImage.appendChild(imageContainer);
            };

            reader.readAsDataURL(file);
        }
    }

    var attachmentInput = document.getElementById('attachment-input');
    attachmentInput.addEventListener('change', function() {
        createImagePreview(this);
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

    function selectPoolStar(rating) {
        document.getElementById('pool-rating-input').value = rating;
        const stars = document.getElementsByClassName('input-pool-rating');
        for (let i = 0; i < stars.length; i++) {
            if (i < rating) {
                stars[i].style.color = '#cccc04'; // Màu sao được chọn
            } else {
                stars[i].style.color = 'gray'; // Màu sao không được chọn
            }
        }
    }

    function like(id) {
        //using ajax
        $.ajax({
            url: "/gym/review/" + id + "/like",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                // reload page
                window.location.reload();
            },
        });
    }

    function dislike(id) {
        //using ajax
        $.ajax({
            url: "/gym/review/" + id + "/dislike",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                // reload page
                window.location.reload();
            },
        });
    }
</script>
@endsection