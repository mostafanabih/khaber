@extends('layouts.patient.layout')
@section('title')
<title>{{ $title_meta->aboutus_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->aboutus_meta_description }}">
@endsection
@section('patient-content')
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->about_us ? url($banner->about_us) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@if($setting->text_direction=='RTL'){{ $navigation->about_us}}@else
                            {{ $translator->setTarget('en')->translate($navigation->about_us) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $navigation->about_us}}@else
                            {{ $translator->setTarget('en')->translate($navigation->about_us) }}
                            @endif</span></li>
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
                @if($setting->text_direction=='RTL'){!! clean($about->about_description)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($about->about_description)) !!}
                            @endif
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
                @if($setting->text_direction=='RTL'){!! clean($about->mission_description)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($about->mission_description)) !!}
                            @endif
                </div>
            </div>
        </div>
        <div class="row mt_40">
            <div class="col-md-6 pt_30">
                <div class="mission-text">
                @if($setting->text_direction=='RTL'){!! clean($about->vision_description)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($about->vision_description)) !!}
                            @endif 
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
                    <h4>@if($setting->text_direction=='RTL'){!! $overview->name!!}@else
                            {!! $translator->setTarget('en')->translate($overview->name) !!}
                            @endif</h4>
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
                    <h1><span>@if($setting->text_direction=='RTL'){{ ucfirst($work_section->first_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($work_section->first_header)) }}
                            @endif</span> @if($setting->text_direction=='RTL'){{ ucfirst($work_section->second_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($work_section->second_header)) }}
                            @endif</h1>
                    <p>@if($setting->text_direction=='RTL'){{ $work_section->description}}@else
                            {{ $translator->setTarget('en')->translate($work_section->description) }}
                            @endif</p>
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
          @if($setting->text_direction=='RTL'){!! clean($faq->answer)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($faq->answer)) !!}
                            @endif.
          </p>
          <h6 class="color">
          @if($setting->text_direction=='RTL'){{ $faq->question}}@else
                            {{ $translator->setTarget('en')->translate($faq->question) }}
                            @endif  
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
