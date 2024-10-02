@extends('layouts.patient.layout')
@section('title')
<title>{{ $title_meta->home_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->home_meta_description }}">
@endsection
@section('patient-content')

@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp


<!--Slider Start-->
<div class="slider" id="main-slider">

    <div class="doc-search-item">
        @php
            $sliderContent=App\Setting::first();
        @endphp
        <div class="d-flex align-items-center h_100_p">
            <div class="v-mid-content">
                <div class="heading">
                    <h2>@if($setting->text_direction=='RTL'){{ $sliderContent->slider_heading}}@else
                            {{ $translator->setTarget('en')->translate($sliderContent->slider_heading) }}
                            @endif</h2>
                    <p>@if($setting->text_direction=='RTL'){{ $sliderContent->slider_description}}@else
                            {{ $translator->setTarget('en')->translate($sliderContent->slider_description) }}
                            @endif</p>
                </div>
                <div class="doc-search-section">
                    <form action="{{ url('search-doctor') }}">
                    <div class="box">
                        <select name="location" class="form-control select2">
                            <option value="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_loc')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_loc')->first()->custom_lang) }}
                            @endif</option>
                            @foreach ($locations as $location)
                            <option {{ @$location_id==$location->id?'selected':'' }} value="{{ $location->id }}">@if($setting->text_direction=='RTL'){{ ucwords($location->location)}}@else
                            {{ $translator->setTarget('en')->translate(ucwords($location->location)) }}
                            @endif</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="box">
                        <select name="department" class="form-control select2">
                            <option value="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_dep')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_dep')->first()->custom_lang) }}
                            @endif</option>
                            @foreach ($departmentsForSearch as $department)
                            <option {{ @$department_id==$department->id?'selected':'' }} value="{{ $department->id }}">@if($setting->text_direction=='RTL'){{ ucwords($department->name)}}@else
                            {{ $translator->setTarget('en')->translate(ucwords($department->name)) }}
                            @endif</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="box">
                        <select name="doctor" class="form-control select2">
                            <option value="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_doc')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_doc')->first()->custom_lang) }}
                            @endif</option>
                            @foreach ($doctorsForSearch as $doctor)
                            <option {{ @$doctor_id==$doctor->id?'selected':'' }} value="{{ $doctor->id }}">@if($setting->text_direction=='RTL'){{ ucwords($doctor->name)}}@else
                            {{ $translator->setTarget('en')->translate(ucwords($doctor->name)) }}
                            @endif</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="doc-search-button">
                        <button type="submit" class="btn btn-danger">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','search')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','search')->first()->custom_lang) }}
                            @endif</button>
                    </div>
                </form>
                </div>

            </div>
        </div>




    </div>





    



    <div class="slide-carousel owl-carousel">
    @foreach ($sliders as $item)
    <div class="slider-item flex">
        <img src="{{ url($item->image) }}" alt="Slider Image" class="slider-image">
        <div class="bg-slider"></div>
        <div class="container">
            <div class="row">
                <!-- Your content here -->
            </div>
        </div>
    </div>
    @endforeach
</div>


</div>
<!--Slider End-->





@php
    $feature_section=$homesections->where('section_type',1)->first();
@endphp
<!--Why Us Start-->
@if ($feature_section->show_homepage==1)
<div class="why-us-area pt_30">
    <div class="container">
        <div class="row">
            @foreach ($features->take($feature_section->content_quantity) as $feature)
            <div class="col-lg-4 choose-col image-anime">
                <div class="choose-item flex" style="background-image: url({{ url($feature->background_image) }})">
                    <div class="choose-icon">
                        <i class="{{ $feature->logo }}"></i>
                    </div>
                    <div class="choose-text">
                        <h4>@if($setting->text_direction=='RTL'){{ $feature->title}}@else
                            {{ $translator->setTarget('en')->translate($feature->title) }}
                            @endif</h4>
                        <p>
                        @if($setting->text_direction=='RTL'){{ $feature->description}}@else
                            {{ $translator->setTarget('en')->translate($feature->description) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>
</div>
<!--why Us End-->






@endif

@php
    $work_section=$homesections->where('section_type',2)->first();
@endphp
@if ($work_section->show_homepage==1)
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
            <use href="{{ $work->image ? url($work->image) : '' }}"></use>
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
<source class=" lazyloading" src="{{ $work->image ? url($work->image) : '' }}" data-srcset="{{ $work->image ? url($work->image) : '' }}" type="image/webp" srcset="{{ $work->image ? url($work->image) : '' }}"><img class=" lazyloaded" src="{{ $work->image ? url($work->image) : '' }}" data-src="{{ $work->image ? url($work->image) : '' }}" draggable="false" loading="lazy" alt="video name">
</picture>
</div>
<div class="video__btn-container">
<div class="video__btn">
    <a class="video-button mgVideo" href="{{ $work->video }}">
    <span></span>
    </a>
</div>
</div>
</div>
</div>

</div>
</div>
</section>





<!--<div class="about-area">-->
<!--    <div class="container">-->
<!--        <div class="row ov_hd">-->
<!--            <div class="col-md-12 wow fadeInDown">-->
<!--                <div class="main-headline">-->
<!--                    <h1><span>{{ ucfirst($work_section->first_header) }}</span> {{ ucfirst($work_section->second_header) }}</h1>-->
<!--                    <p>{{ $work_section->description }}</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="coustom-container">-->
<!--        <div class="row ov_hd">-->
<!--            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">-->
<!--                <div class="about-skey mt_50">-->
<!--                    <div class="about-img">-->
<!--                        <img src="{{ $work->image ? url($work->image) : '' }}" alt="">-->
<!--                        <div class="video-section video-section-home">-->
<!--                            <a class="video-button mgVideo" href="{{ $work->video }}"><span></span></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">-->
<!--                <div class="feature-section-text mt_50">-->
<!--                    <h2 style="text-align:right;">{{ $work->title }}</h2>-->
<!--                    <p style="text-align:right;">{{ $work->description }}</p>-->
<!--                    <div class="feature-accordion" id="accordion">-->
<!--                        @foreach ($workFaqs as $faqIndex => $faq)-->
<!--                        <div class="faq-item card">-->
<!--                            <div class="faq-header" id="heading1-{{ $faq->id }}">-->
<!--                                <button class="faq-button {{ $faqIndex != 0 ? 'collapsed':'' }}" data-toggle="collapse" data-target="#collapse1-{{ $faq->id }}" aria-expanded="true" aria-controls="collapse1-{{ $faq->id }}">{{ $faq->question }}</button>-->
<!--                            </div>-->

<!--                            <div id="collapse1-{{ $faq->id }}" class="collapse {{ $faqIndex == 0 ? 'show':'' }}" aria-labelledby="heading1-{{ $faq->id }}" data-parent="#accordion">-->
<!--                                <div class="faq-body">-->
<!--                                   {!! clean($faq->answer) !!}-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        @endforeach-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--Feature End-->
@endif

@php
$service_section=$homesections->where('section_type',3)->first();
@endphp
@if ($service_section->show_homepage==1)
<!--Service Start-->
<div class="service-area bg-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-headline">
                    <h1><span>@if($setting->text_direction=='RTL'){{ ucfirst($service_section->first_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($service_section->first_header)) }}
                            @endif</span> @if($setting->text_direction=='RTL'){{ ucfirst($service_section->second_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($service_section->second_header)) }}
                            @endif</h1>
                    <p>@if($setting->text_direction=='RTL'){{$service_section->description}}@else
                            {{ $translator->setTarget('en')->translate($service_section->description) }}
                            @endif</p>
                </div>
            </div>
        </div>
        <div class="row service-row">
            <div class="col-md-12">
                <div class="service-coloum-area">
                @php
                $translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
                @endphp

                    @foreach ($services->take($service_section->content_quantity) as $service)

                    <div class="service-coloum">
                        <div class="service-item">
                            <i class="{{ $service->icon }}"></i>
                            <h3>@if($setting->text_direction=='RTL'){{ $service->header}}@else
                            {{ $translator->setTarget('en')->translate($service->header) }}
                            @endif</h3>
                            <p>@if($setting->text_direction=='RTL'){{ $service->sort_description}}@else
                            {{ $translator->setTarget('en')->translate($service->sort_description) }}
                            @endif</p>
                            <a href="{{ url('service-details/'.$service->slug) }}">@if($setting->text_direction=='RTL')
                            {{ $websiteLang->where('lang_key','service_details')->first()->custom_lang }}
                            @else
                            {{ $websiteLang->where('lang_key','service_details')->first()->default_lang }}
                            @endif →</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="home-button ser-btn">
                    <a href="{{ url('service') }}">@if($setting->text_direction=='RTL')
        {{ $websiteLang->where('lang_key','all_service')->first()->custom_lang }}
    @else
        {{ $websiteLang->where('lang_key','all_service')->first()->default_lang }}
    @endif</a>
                </div>
            </div>
        </div>
        <!--Counter Start-->
        <div class="counter-row row" style="background-image: url({{ $banner->overview ? url($banner->overview) : '' }})">
            @foreach ($overviews as $overview)
            <div class="col-lg-3 col-6 mt_30 wow fadeInDown" data-wow-delay="0.2s">
                <div class="counter-item">
                    <div class="counter-icon">
                        <i class="{{ $overview->icon }}"></i>
                    </div>
                    <div style="display: flex;align-items: center;justify-content: center;gap: 5px;">
                    <span style="color: #fff;font-size: large;font-weight: 800;">+</span><h2 class="counter">{{ $overview->qty }}</h2></div>
                    <h4>@if($setting->text_direction=='RTL'){{ $overview->name}}@else
                            {{ $translator->setTarget('en')->translate($overview->name) }}
                            @endif</h4>
                </div>
            </div>
            @endforeach

        </div>
        <!--Counter End-->
    </div>
</div>
<!--Service End-->
@endif


@php
$department_section=$homesections->where('section_type',4)->first();
@endphp
@if ($department_section->show_homepage==1)
<!--Portfolio Start-->
<div class="case-study-home-page case-study-area ">
    <div class="container">
        <div class="row mb_25">
            <div class="col-md-12 wow fadeInDown" data-wow-delay="0.1s">
                <div class="main-headline">
                    <h1><span>@if($setting->text_direction=='RTL'){{ ucfirst($department_section->first_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($department_section->first_header)) }}
                            @endif</span> @if($setting->text_direction=='RTL'){{ ucfirst($department_section->second_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($department_section->second_header)) }}
                            @endif</h1>
                    <p>@if($setting->text_direction=='RTL'){{ $department_section->description}}@else
                            {{ $translator->setTarget('en')->translate($department_section->description) }}
                            @endif</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($departments->take($department_section->content_quantity) as $department)
                    <div class="col-lg-4 col-md-6 mt_15">
                        <div class="case-item">
                            <div class="case-box">
                                <div class="case-image">
                                    <img src="{{ url($department->thumbnail_image) }}" alt="">
                                    <div class="overlay"><a href="{{ url('department-details/'.$department->slug) }}" class="btn-case">{{ $websiteLang->where('lang_key','see_details')->first()->custom_lang }}</a>
                                    </div>
                                </div>
                                <div class="case-content">
                                    <h4><a href="{{ url('department-details/'.$department->slug) }}">@if($setting->text_direction=='RTL'){{ $department->name}}@else
                            {{ $translator->setTarget('en')->translate($department->name) }}
                            @endif</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>
        <div class="row mb_60">
            <div class="col-md-12">
                <div class="home-button">
                    <a href="{{ url('department') }}">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','all_dep')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','all_dep')->first()->custom_lang) }}
                            @endif</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endif


@php
$patient_section=$homesections->where('section_type',5)->first();
@endphp
@if ($patient_section->show_homepage==1)
<!--Testimonial Start-->
<div class="testimonial-area {{ $department_section->show_homepage==0 ? 'mt_200':'' }}">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-headline">
                    <h1><span>@if($setting->text_direction=='RTL'){{ ucfirst($patient_section->first_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($patient_section->first_header)) }}
                            @endif</span>@if($setting->text_direction=='RTL'){{ ucfirst($patient_section->second_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($patient_section->second_header)) }}
                            @endif </h1>
                    <p>@if($setting->text_direction=='RTL'){{ $patient_section->description}}@else
                            {{ $translator->setTarget('en')->translate($patient_section->description) }}
                            @endif</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="testimonial-texarea mt_30">
                    <div class="owl-testimonial owl-carousel">
                        @foreach ($testimonials->take($patient_section->content_quantity) as $patient)
                        <div class="testimonial-item wow fadeIn" data-wow-delay="0.2s">
                            <p class="wow fadeInDown" data-wow-delay="0.2s">
                            @if($setting->text_direction=='RTL'){{ $patient->description}}@else
                            {{ $translator->setTarget('en')->translate($patient->description) }}
                            @endif
                            </p>
                            <div class="testi-info wow fadeInUp" data-wow-delay="0.2s">
                                <img src="{{ url($patient->image) }}" alt="">
                                <h4>@if($setting->text_direction=='RTL'){{ $patient->name}}@else
                            {{ $translator->setTarget('en')->translate($patient->name) }}
                            @endif</h4>
                                <span>@if($setting->text_direction=='RTL'){{ $patient->designation}}@else
                            {{ $translator->setTarget('en')->translate($patient->designation) }}
                            @endif</span>
                            </div>
                        </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Testimonial End-->
@endif



@php
$doctor_section=$homesections->where('section_type',6)->first();
@endphp
@if ($doctor_section->show_homepage==1)
<!--Team Area Start-->
<div class="team-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-headline">
                <h1><span>@if($setting->text_direction=='RTL'){{ ucfirst($doctor_section->first_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($doctor_section->first_header)) }}
                            @endif</span> @if($setting->text_direction=='RTL'){{ ucfirst($doctor_section->second_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($doctor_section->second_header)) }}
                            @endif</h1>
                    
                    <p>@if($setting->text_direction=='RTL'){{ $doctor_section->description}}@else
                            {{ $translator->setTarget('en')->translate($doctor_section->description) }}
                            @endif</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="team-carousel owl-carousel">
                    @foreach ($doctors->take($doctor_section->content_quantity) as $doctor)
                    <div class="team-item">
                        <div class="team-photo">
                            <img src="{{ url($doctor->image) }}" alt="Team Photo" style="border-radius:0px;">
                        </div>
                        <div class="team-text">
                            <a href="{{ url('doctor-details/'.$doctor->slug) }}">@if($setting->text_direction=='RTL'){{ $doctor->name}}@else
                            {{ $translator->setTarget('en')->translate($doctor->name) }}
                            @endif</a>
                            <p>@if($setting->text_direction=='RTL'){{ $doctor->department->name}}@else
                            {{ $translator->setTarget('en')->translate($doctor->department->name) }}
                            @endif</p>
                            <p><span><i class="fas fa-graduation-cap"></i> @if($setting->text_direction=='RTL'){{ $doctor->designations}}@else
                            {{ $translator->setTarget('en')->translate($doctor->designations) }}
                            @endif</span></p>
                            <p><span><b><i class="fas fa-street-view"></i> @if($setting->text_direction=='RTL'){{ ucfirst($doctor->location->location)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($doctor->location->location)) }}
                            @endif</b></span></p>
                        </div>
                        <div class="team-social">
                            <ul>
                                @if ($doctor->facebook)
                                <li><a href="{{ $doctor->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                @endif
                                @if ($doctor->twitter)
                                <li><a href="{{ $doctor->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                @endif
                                @if ($doctor->linkedin)
                                <li><a href="{{ $doctor->linkedin }}"><i class="fab fa-linkedin"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
<!--Team Area End-->
@endif


@php
$blog_section=$homesections->where('section_type',7)->first();
@endphp
@if ($blog_count !=0)
@if ($blog_section->show_homepage==1)
<!--Blog-Area Start-->
<div class="blog-area bg_ecf1f8">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-headline">
                    <h1><span>@if($setting->text_direction=='RTL'){{ ucfirst($blog_section->first_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($blog_section->first_header)) }}
                            @endif</span> @if($setting->text_direction=='RTL'){{ ucfirst($blog_section->second_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($blog_section->second_header)) }}
                            @endif</h1>
                    <p>@if($setting->text_direction=='RTL'){{ $blog_section->description}}@else
                            {{ $translator->setTarget('en')->translate($blog_section->description) }}
                            @endif</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="blog-item first-blog">
                    <a href="{{ url($feature_blog->feature_image) }}" class="image-effect">
                        <div class="blog-image image-anime">
                            <img src="{{ url($feature_blog->feature_image) }}" alt="">
                        </div>
                    </a>
                    <div class="blog-text">
                        <div class="blog-author">
                            <span><i class="fas fa-user"></i> @if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','admin')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','admin')->first()->custom_lang) }}
                            @endif</span>
                            <span><i class="far fa-calendar-alt"></i> {{ $feature_blog->created_at->format('m-d-Y') }}</span>
                        </div>
                        <h3><a href="{{ url('blog-details/'.$feature_blog->slug) }}">@if($setting->text_direction=='RTL'){{ $feature_blog->title}}@else
                            {{ $translator->setTarget('en')->translate($feature_blog->title) }}
                            @endif</a></h3>
                        <p>
                        @if($setting->text_direction=='RTL'){{ $feature_blog->sort_description}}@else
                            {{ $translator->setTarget('en')->translate($feature_blog->sort_description) }}
                            @endif
                        </p>
                        <a class="sm_btn" href="{{ url('blog-details/'.$feature_blog->slug) }}">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','details')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','details')->first()->custom_lang) }}
                            @endif →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="blog-carousel owl-carousel">
                    @php $i=0; @endphp
                    @foreach ($blogs->take($blog_section->content_quantity) as $blog)
                        @php $i++; @endphp
                        @if($i == 1)
                            @continue
                        @endif
                        <div class="blog-item effect-item">
                            <a href="#" class="image-effect">
                                <div class="blog-image image-anime">
                                    <img src="{{ $blog->thumbnail_image }}" alt="Blog Thumbnail Image">
                                </div>
                            </a>
                            <div class="blog-text">
                                <div class="blog-author">
                                    <span><i class="fas fa-user"></i> @if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','admin')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','admin')->first()->custom_lang) }}
                            @endif</span>
                                    <span><i class="far fa-calendar-alt"></i> {{ $blog->created_at->format('m-d-Y') }}</span>
                                </div>
                                <h3><a href="{{ url('blog-details/'.$blog->slug) }}">@if($setting->text_direction=='RTL'){{ $blog->title}}@else
                            {{ $translator->setTarget('en')->translate($blog->title) }}
                            @endif</a></h3>
                                <p>
                                @if($setting->text_direction=='RTL'){{ $blog->sort_description}}@else
                            {{ $translator->setTarget('en')->translate($blog->sort_description) }}
                            @endif
                                </p>
                                <a class="sm_btn" href="{{ url('blog-details/'.$blog->slug) }}">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','details')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','details')->first()->custom_lang) }}
                            @endif →</a>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
<!--Blog-Area End-->
@endif
@endif

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog offer-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body offer-body">
                <img src="{{url($offer->image)}}" class="img-fluid offer-image" alt="Offer Image">
            </div>
            <div class="modal-footer">
                <a href="{{route('offers')}}" type="button" class="btn" style="background-color: #002945; width: 50%; margin: auto; padding: 10px; color: #fff; font-size: medium;">@if($setting->text_direction=='RTL')كل العروض@else
                            {{ $translator->setTarget('en')->translate("كل العروض") }}
                            @endif </a>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin-left: 1px;"></button>
            </div>
        </div>
    </div>
</div>


@endsection
