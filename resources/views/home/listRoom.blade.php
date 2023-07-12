<h2 class="mx-5" style="font-weight: bold; color: #4066E0">Trending Gym Room</h2>
<div class="container-fluid row pt-4">

    <div class="col d-flex flex-column justify-content-center align-items-center">
        <div class="gym-list d-flex justify-content-start flex-wrap" style="width: 90%">
            @foreach($gymRooms as $room)

                <div class="gym-wrap mb-4 px-2" style="width: 20%" onclick="goToGymDetailPage({{ $room->id }})" data-id="{{$room->id}}">
                    <div class="card position-relative" style="height: 20rem">
                        @if($room->pool == 1)
                            <span class="mark">
                            <i class="fa-solid fa-crown fa-xs" style="color: #dbe826;"></i>
                            プール
                        </span>
                        @endif
                        <img class="card-img-top" src="{{ $room->firstImage}}" alt="Gym image" style="height: 50%; object-fit: cover;">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title" style="font-size: 1.5rem; font-weight: bold; color: #4066E0">{{ $room->name}}</h5>
                                <p class="card-text mt-2">{{ $room->address}}</p>
                            </div>
                            <div class="star-button d-flex justify-content-between mt-1">
                                @php
                                    $star = $room->rating;
                                    $maxRating = 5;
                                    $percent = ($star / $maxRating) * 100;
                                @endphp

                                <div class="star-group">
                                    @for ($i = 1; $i <= 5; $i++) @if ($percent>= $i * 20)
                                        <i class="fas fa-star"></i>
                                    @elseif ($percent >= ($i - 0.5) * 20)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                    @endfor
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{--Tạo đường link phân trang cho danh sách nhà hàng--}}
        <div class="pagination mt-4">

            @if ($gymRooms->currentPage() > 1)
                <a href="{{ $gymRooms->previousPageUrl() }}" class="page-link">前</a>
            @endif

            @for ($i = 1; $i <= $gymRooms->lastPage(); $i++)
                <a href="{{$gymRooms->url($i)  }} " class="page-link{{ ($gymRooms->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
            @endfor

            @if ($gymRooms->hasMorePages())
                <a href="{{ $gymRooms->nextPageUrl() }}" class="page-link">次</a>
            @endif
        </div>
    </div>
</div>
<style>
    .fas {
        color: #ffcc00;
    }

    .far {
        color: #ffcc00;
    }

    .card {
        border-radius: 10px;
        background-color: #fafbff;
        position: relative;
        overflow: hidden;
    }

    .card-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .mark {
        position: absolute;
        top: 10px;
        left: -20px;
        transform: rotate(-45deg);
        background-color: red;
        color: white;
        font-size: 10px;
        font-weight: bold;
        width: calc(20% + 20px);
        height: 20px;
        text-align: center;
        line-height: 20px;
    }
</style>

<script>
    function goToGymDetailPage(id) {
        window.location.href = "/gym/" + id;
    }
</script>
