@extends('layout.app')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div id="lens"></div>
        <div id="gym-slider mt-4" class="col-lg-5">
        <div class="room-display-img">
                @if (count($gym_imgs) == 0)
                    <img src="https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg" class="w-100 carousel-img" alt="Image 1" style="width: 95%;height: 400px;object-fit: cover;">
                @else
                    <img src="{{ $gym_imgs[0]['image_url'] }}" class="w-100 carousel-img" alt="Image 1" style="width: 95%;height: 400px;object-fit: cover;">
                @endif
            </div>   

            <div class="image-box d-flex justify-content-between mt-4">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @php $count = 0; @endphp
                        @foreach($gym_imgs as $index => $gym_img)
                            @if($count % 5 == 0)
                                <div class="carousel-item{{ $count === 0 ? ' active' : '' }}">
                                    <div class="d-flex">
                            @endif
                            <div class="image-box-item" style="width: 20%;">
                                <img src="{{$gym_img->image_url}}" alt="Slide" style="border: 5px solid #fff3cd; object-fit: cover; width: 100%; height: 100%;">
                            </div>
                            @php $count++; @endphp
                            @if($count % 5 == 0 || $index === count($gym_imgs) - 1)
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @if (count($gym_imgs) > 5)
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif
            </div>
        </div>
        <div id="result"></div>
        <div class="gym-info col-lg-7 padding-left-modify">
            <h4>ジムルーム情報</h4>
            <div class="gym-rating-group d-flex justify-content-between">
                <div class="gym-review d-flex justify-content-between" style="width: 250px">
                    <p class="custom-space-text text-bold">ジム評価</p>
                    <div class="gym-rating d-flex">
                        <p class="custom-space-text" style="font-size: 1.5rem">{{$gym->rating}}</p>
                        <i class="fa-solid fa-star" style="line-height: 36px; color: #cccc04; font-size: 1.5rem"></i>
                    </div>
                </div>

                @if($gym->pool == 1)
                <div class="pool-review d-flex justify-content-between" style="width: 250px">
                    <p class="custom-space-text mr-4 text-bold">プール評価</p>
                    <div class="pool-rating d-flex">
                        <p class="custom-space-text" style="font-size: 1.5rem">{{$gym->pool_rating}}</p>
                        <i class="fa-solid fa-star" style="line-height: 36px; color: #cccc04; font-size: 1.5rem"></i>
                    </div>
                </div>
                @endif
            </div>
            <div class="datetime-login d-flex justify-content-end">
                <i class="fa-solid fa-circle mx-3" style="color: #8aeda1; line-height: 40px; font-size: 1.5rem"></i>
                <p style="line-height: 40px; font-size: 1.5rem">{{$owner->last_login_at}}</p>
            </div>
            <div class="row">
                <p class="col-4 custom-space-text text-bold">ジム名:</p>
                <p class="col-8 custom-space-text">{{$gym->name}}</p>
            </div>
            <div class="row">
                <p class="col-4 custom-space-text text-bold">住所:</p>
                <p class="col-8 custom-space-text">{{$gym->address}}</p>
            </div>
            <div class="row">
                <p class="col-4 custom-space-text text-bold">ジムオーナー:</p>
                <p class="col-8 custom-space-text">{{$gym->nameOwner}}</p>
            </div>
            <div class="row">
                <p class="col-4 custom-space-text text-bold">電話番号:</p>
                <p class="col-8 custom-space-text">{{$gym->phone}}</p>
            </div>
            <div class="row">
                <p class="col-4 custom-space-text text-bold">1っか月登録価格:</p>
                <p class="col-8 custom-space-text">{{$gym->price}} VND</p>
            </div>
            <div class="row">
                <p class="col-4 custom-space-text text-bold">サビース:</p>
                <p class="col-8 custom-space-text">
                    @if($gym->pool==1)
                    プール、
                    @endif
                    @if($gym->sauna == 1)
                    サウナ、
                    @endif
                    @if($gym->parking == 1)
                    駐車場
                    @endif
                </p>
            </div>
            <button type="button" class="btn btn-primary custom-button-review" onclick="window.location='{{ route('gym.review', ['gym' => $gym->id]) }}'">Hiển thị bình luận</button>
        </div>
    </div>

    <div class="row d-flex justify-content-around custom-space-top-btn">
        <button type="button" class="btn btn-danger col-lg-2" onclick="window.location='{{ route('gym.destroy') }}'">Xóa</button>
        <button type="button" class="btn btn-primary col-lg-2 btn-green-color" onclick="redirectUpdatePage()">Chỉnh sửa</button>
        @if($gym->active == 1)
        <button type="button" class="btn btn-primary col-lg-2 btn-green-color" onclick="window.location='{{ route('gym.update-status') }}'">Tạm ngừng hoạt động</button>
        @else
        <button type="button" class="btn btn-primary col-lg-2 btn-green-color" onclick="window.location='{{ route('gym.update-status') }}'">Mở lại</button>
        @endif
    </div>

</div>

<style>
    .text-bold {
        font-weight: bold;
    }

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

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
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

    #lens { background-color: rgba( 233, 233, 233, 0.4 ) }
    #lens, #result { position: absolute; display: none; z-index: 1; }
    #lens, .carousel-item, .image-box-item, #result { border: solid var(--light-grey-2) 1px; }
</style>

<script type="text/javascript" src="{{ secure_asset('js/script.js')}}"></script>

<script>
    function redirectUpdatePage() {
        window.location.href = "{{route('gym.edit')}}"
    }
</script>
@endsection