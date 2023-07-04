<h2 class="mx-5" style="font-weight: bold; color: #4066E0">Trending Gym Room</h2>
<div class="container-fluid">
    <div class="row d-flex justify-content-around flex-row pl-4 pt-4">
        <div class="col d-flex flex-column align-items-center">
            <div class="restaurant-list d-flex justify-content-around flex-wrap" style="width: 90%">
                @for($a = 0; $a < 10; $a++) <div class="restaurant-wrap mb-4" style="width: 18%" onclick="" data-id="">
                    <div class="card position-relative" style="height: 15rem">
                        <img class="card-img-top" src="https://previews.123rf.com/images/jalephoto/jalephoto2002/jalephoto200200955/140822100-modern-gym-room-fitness-center-with-equipment-and-machines.jpg" alt="Gym image" style="height: 50%; object-fit: cover;">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title" style="font-size: 2rem; font-weight: bold; color: #4066E0">Blue Gym</h5>
                                <p class="card-text mt-2">Võ Thị Sáu, Hai Bà Trưng</p>
                            </div>
                            <div class="star-button d-flex justify-content-between mt-1">
                                <div class="star-group">
                                    @for ($i = 1; $i <= 5; $i++) <i class="fas fa-star"></i>
                                        @endfor
                                </div>
                                <img src="/images/pool.jpg" alt="Pool" style="width: 40px;">
                            </div>
                        </div>
                    </div>
            </div>
            @endfor
        </div>
        {{--Tạo đường link phân trang cho danh sách nhà hàng--}}
    </div>
</div>
<style>
    .fas {
        color: #ffcc00;
    }

    .card {
        border-radius: 10px;
        background-color: #fafbff;
    }
</style>