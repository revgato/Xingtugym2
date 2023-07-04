@extends('layout.app')

@section('content')
<div class="container">

</div>
<div class="swiper-container">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <img class="card-img" src="https://previews.123rf.com/images/jalephoto/jalephoto2002/jalephoto200200955/140822100-modern-gym-room-fitness-center-with-equipment-and-machines.jpg" alt="nature">
      <div class="team-content">
        <h5 style="font-size: 2rem; font-weight: bold; color: blue">Blue Gym</h5>
        <p class=" mt-2">Võ Thị Sáu, Hai Bà Trưng</p>
      </div>
    </div>
    <div class="swiper-slide">
      <img class="card-img" src="https://previews.123rf.com/images/jalephoto/jalephoto2002/jalephoto200200955/140822100-modern-gym-room-fitness-center-with-equipment-and-machines.jpg" alt="mountain">
      <div class="team-content">
        <h5 style="font-size: 2rem; font-weight: bold; color: blue">Blue Gym</h5>
        <p class=" mt-2">Võ Thị Sáu, Hai Bà Trưng</p>
      </div>
    </div>
    <div class="swiper-slide">
      <img class="card-img" src="https://previews.123rf.com/images/jalephoto/jalephoto2002/jalephoto200200955/140822100-modern-gym-room-fitness-center-with-equipment-and-machines.jpg" alt="water">
      <div class="team-content">
        <h5 style="font-size: 2rem; font-weight: bold; color: blue">Blue Gym</h5>
        <p class=" mt-2">Võ Thị Sáu, Hai Bà Trưng</p>
      </div>
    </div>
    <div class="swiper-slide">
      <img class="card-img" src="https://previews.123rf.com/images/jalephoto/jalephoto2002/jalephoto200200955/140822100-modern-gym-room-fitness-center-with-equipment-and-machines.jpg" alt="animal">
      <div class="team-content">
        <h5 style="font-size: 2rem; font-weight: bold; color: blue">Blue Gym</h5>
        <p class=" mt-2">Võ Thị Sáu, Hai Bà Trưng</p>
      </div>
    </div>
  </div>
  <div class="swiper-pagination"></div>
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>
</div>

@include('home.listRoom')
<style>
  .swiper-container {
    width: 100%;
    padding-top: 50px;
    padding-bottom: 50px;
    overflow: hidden;
  }

  .swiper-slide {
    width: 300px;
    height: 240px;
    position: relative;
    overflow: hidden;
  }

  .swiper-slide::before {
    content: "";
    width: 0;
    height: 0;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    transition: .5s;
    margin: auto;
    margin-top: 40px;
    border-radius: 10px;
    z-index: -1;
  }

  .swiper-slide:hover::before {
    width: 60%;
    height: 60%;
  }

  .swiper-slide:hover {
    backdrop-filter: blur(10px);
  }

  .swiper-slide .team-content {
    position: absolute;
    bottom: 20px;
    left: 0;
    right: 0;
    opacity: 0;
    transition: .3s ease-in-out;
    text-align: center;
  }

  .swiper-slide:hover .team-content {
    opacity: 1;
    color: #fff;
  }
</style>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script>
  const swiper = new Swiper('.swiper-container', {
    effect: 'coverflow',
    centeredSlides: true,
    slidesPerView: 1,
    loop: true,
    speed: 600,

    autoplay: {
      delay: 3000,
    },

    coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows: true,
    },

    breakpoints: {
      320: {
        slidesPerView: 2,
      },
      560: {
        slidesPerView: 3,
      },
      990: {
        slidesPerView: 4,
      }
    },

    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },

    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
</script>
@endsection