@extends('layout.app')

@section('content')
<div id="search-wrapper" class="search-wrapper m-5 pl-5 pr-5">
    <p style="font-size: 2rem; font-weight: bold">検索</p>

    <form action="{{ route('gym.search') }}" method="GET">
        @csrf
        <div class="form-row">
            <div class="form-group col-lg-12">
                <input type="text" class="form-control" id="inputName" name="inputName" placeholder="名前">
            </div>
        </div>

        <div class="form-row d-flex mt-4 justify-content-between">
            <div class="form-group col-lg-3">
                <input type="text" class="form-control" id="inputAddress" name="inputAddress" placeholder="住所">
            </div>
            {{-- phần dropdown--}}
            <div class="custom-select col-lg-3">
                <select name="inputPrice" id="inputPrice" class="col-lg-3">
                    <option value="" disabled selected hidden>価格</option>
                    <option value="1">10万-30万</option>
                    <option value="2">30万-50万</option>
                    <option value="3">50万以上</option>
                </select>
            </div>

            <div class="custom-select col-lg-3">
                <select name="inputService" id="inputService" class="col-lg-3">
                    <option value="" disabled selected hidden class="placeholder-option">サービス</option>
                    <option value="1">プール</option>
                    <option value="2">サウナ室</option>
                    <option value="3">駐車場</option>
                </select>

            </div>

            <button type="submit" class="btn btn-primary">検索</button>

        </div>

    </form>
</div>


@include('gym.listRoom')

<style>
    #search-wrapper.search-wrapper input {
        line-height: 53.6px;
    }

    #search-wrapper.search-wrapper select {
        height: 67.2px;
        padding: 0.375rem 0.75rem;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;

        /* Ẩn mũi tên dropdown mặc định */

        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;

    }


    #search-wrapper.search-wrapper button {
        padding: 0 65px;
        height: 67.2px;
    }


    /* CSS cho giao diện dropdown tùy chỉnh */
    .custom-select {
        position: relative;
    }

    .custom-select select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
    }

    .custom-select::after {
        content: '\25BC';
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        pointer-events: none;
    }
</style>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var url = window.location.href;

        if (url.split('inputName=')[1] == undefined) {
            var inputName = "";
        } else {
            // Decode URI
            var inputName = url.split('inputName=')[1].split('&')[0];

            // var inputName = url.split('inputName=')[1].split('&')[0];
        }

        if (url.split('inputAddress=')[1] == undefined) {
            var inputAddress = "";
        } else {
            var inputAddress = url.split('inputAddress=')[1].split('&')[0];
        }

        if (url.split('inputPrice=')[1] == undefined) {
            var inputPrice = "";
        } else {
            var inputPrice = url.split('inputPrice=')[1].split('&')[0];
        }

        if (url.split('inputService=')[1] == undefined) {
            var inputService = "";
        } else {
            var inputService = url.split('inputService=')[1].split('&')[0];
        }

        $('#inputName').val(decodeURI(inputName).replace(/\+/g, ' '));
        $('#inputAddress').val(decodeURI(inputAddress).replace(/\+/g, ' '));

        // Set selected value for dropdown
        $('#inputPrice').val(inputPrice);
        $('#inputService').val(inputService);
    });
</script>