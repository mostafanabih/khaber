@extends('layouts.patient.layout')
@section('title')
<title>{{ $title_meta->aboutus_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->aboutus_meta_description }}">
@endsection
@section('patient-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->about_us ? url($banner->about_us) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $navigation->about_us }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span style="color:#fff !important;">{{ $navigation->about_us }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->


<!--About Us Start-->
<div class="about-style1 pt_50 pb_110">
    <div class="container">
        @if ($about_count != 0)
        <div class="row">
            <div class="col-lg-7">
                <div class="about1-text sm_pr_0 pr_150 mt_30">
                   {!! clean($about->about_description) !!}
                </div>
            </div>
            <div class="col-lg-5">
                <div class="about1-bgimg mt_30" style="background-image:url({{url ($about->about_image) }});">
                    <!-- <div class="about1-inner">
                        <img src="{{url ($about->about_image) }}" alt="">
                    </div> -->
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!--About Us End-->


@if ($about_count != 0)
<!--Mission Start-->
<div class="mission-area bg-area pt_40 pb_90">
    <div class="container">
        <div class="row">
            <div class="col-md-6 pt_30">
                <div class="mission-img">
                    <img src="{{ url($about->mission_image) }}" alt="">
                </div>
            </div>
            <div class="col-md-6 pt_30">
                <div class="mission-text">
                    {!! clean($about->mission_description) !!}
                </div>
            </div>
        </div>
        <div class="row mt_40">
            <div class="col-md-6 pt_30">
                <div class="mission-text">
                    {!! clean($about->vision_description) !!}
                </div>
            </div>
            <div class="col-md-6 pt_30">
                <div class="mission-img vision-img">
                    <img src="{{ url($about->vision_image) }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!--Mission End-->
@endif
<!--Counter Start-->
<div class="counter-page pt_40 pb_70" style="background-image: url({{ $banner->overview ? url($banner->overview) : '' }})">
    <div class="container">
        <div class="row">
            @foreach ($overviews as $overview)
            <div class="col-lg-3 col-6 mt_30 wow fadeInDown" data-wow-delay="0.2s">
                <div class="counter-item">
                    <div class="counter-icon">
                        <i class="{{ $overview->icon }}"></i>
                    </div>
                   <div style="display: flex;align-items: center;justify-content: center;gap:5px;">
                       <span style="color:#fff;font-size: large;font-weight: 800;">+</span>
                       <h2 class="counter">{{ $overview->qty }}</h2>
                    </div>
                    <h4>{{ $overview->name }}</h4>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!--Counter End-->
@php
    $work_section=App\HomeSection::where('section_type',2)->first();
@endphp
<!--Feature Start-->
<section class="reviews d-pad about-area">
<div class="container">

 
<div class="row ov_hd">
    <div class="col-md-12 wow fadeInDown">
                <div class="main-headline">
                    <h1><span>{{ ucfirst($work_section->first_header) }}</span> {{ ucfirst($work_section->second_header) }}</h1>
                    <p>{{ $work_section->description }}</p>
                </div>
            </div>

<div class="col-lg-6 d-flex align-items-stretch">
  <div class="swiper reviewsSlider">
    <div class="swiper-wrapper">
      @foreach ($workFaqs as $faqIndex => $faq)   
      <div class="swiper-slide">
        <div class="testimonial d-flex align-items-center justify-content-center flex-column text-center">
          <svg class="icon">
            <use href="/web/assets/images/icons/icons.svg?v=272#quote"></use>
          </svg>
          <p>
              {!! clean($faq->answer) !!}.
          </p>
          <h6 class="color">
             {{ $faq->question }}  
          </h6>
          
        </div>
      </div>
      @endforeach
      <!-- Add more slides as needed -->
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
  </div>
</div>


<div class="col-lg-6 d-flex align-items-stretch">
<div class="video" data-toggle="modal" data-target="#reviewVideo">
<div class="video__thumb aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
<picture>
<source class=" lazyloading" src="https://khaber.ksa-api.com/uploads/website-images/video.webp" data-srcset="https://khaber.ksa-api.com/uploads/website-images/video.webp" type="image/webp" srcset="https://khaber.ksa-api.com/uploads/website-images/video.webp"><img class=" lazyloaded" src="https://khaber.ksa-api.com/uploads/website-images/video.webp" data-src="https://khaber.ksa-api.com/uploads/website-images/video.webp" draggable="false" loading="lazy" alt="video name">
</picture>
</div>
<div class="video__btn-container">
<div class="video__btn">
<a href="https://www.youtube.com/watch?v=G07V0aOmWTI">
<i class="fas fa-play" style="color: #6ca22a;"></i>
</a>
</div>
</div>
</div>
</div>

</div>
</div>
</section>
<!--Feature End-->

@endsection
