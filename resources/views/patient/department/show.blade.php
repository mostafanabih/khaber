@extends('layouts.patient.layout')
@section('title')
<title>{{ $department->seo_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $department->seo_description }}">
@endsection
@section('patient-content')
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->department ? url($banner->department) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@if($setting->text_direction=='RTL'){{ $department->name}}@else
                            {{ $translator->setTarget('en')->translate($department->name) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $department->name}}@else
                            {{ $translator->setTarget('en')->translate($department->name) }}
                            @endif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->



<div class="service-detail-area pt_40">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="service-detail-text pt_30">

                    <div class="row mb_30">
                        <div class="col-md-12">
                            <!-- Swiper -->
                            <div class="swiper-container pro-detail-top">
                                <div class="swiper-wrapper">
                                    @foreach ($department->images as $item)
                                    <div class="swiper-slide">
                                        <div class="catagory-item">
                                            <div class="catagory-img-holder">
                                                <img src="{{ url($item->large_image) }}" alt="">
                                                <div class="catagory-text">
                                                    <div class="catagory-text-table">
                                                        <div class="catagory-text-cell">
                                                            <ul class="catagory-hover">
                                                                <li><a href="{{ url($item->large_image) }}" class="magnific"><i class="fas fa-search"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach


                                </div>
                                <!-- Add Arrows -->
                                <div class="swiper-button-next swiper-button-white"></div>
                                <div class="swiper-button-prev swiper-button-white"></div>
                            </div>
                            <div class="swiper-container pro-detail-thumbs">
                                <div class="swiper-wrapper">
                                    @foreach ($department->images as $item)
                                    <div class="swiper-slide"><img src="{{ url($item->small_image) }}" alt=""></div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    @if($setting->text_direction=='RTL'){!! clean($department->description)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($department->description)) !!}
                            @endif{!! clean($department->description) !!}
                </div>
                @if ($department->faqs->count()!=0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="faq-service feature-section-text mt_50">
                            <h2>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','faqs')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','faqs')->first()->custom_lang) }}
                            @endif</h2>
                            <div class="feature-accordion" id="accordion">
                                @foreach ($department->faqs as $faq)
                                <div class="faq-item card">
                                    <div class="faq-header" id="heading-{{ $faq->id }}">
                                        <button class="faq-button collapsed" data-toggle="collapse" data-target="#collapse-{{ $faq->id }}" aria-expanded="true" aria-controls="collapse-{{ $faq->id }}">@if($setting->text_direction=='RTL'){{ $faq->question}}@else
                            {{ $translator->setTarget('en')->translate($faq->question) }}
                            @endif</button>
                                    </div>

                                    <div id="collapse-{{ $faq->id }}" class="collapse" aria-labelledby="heading-{{ $faq->id }}" data-parent="#accordion">
                                        <div class="faq-body">
                                        @if($setting->text_direction=='RTL'){!! clean($faq->answer)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($faq->answer)) !!}
                            @endif{!! clean($faq->answer) !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach


                            </div>
                        </div>

                    </div>
                </div>
                @endif

                @if ($department->videos->count()!=0)
                <div class="row mt_50">
                    <div class="col-12">
                        <div class="video-headline">
                            <h3>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','related_video')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','related_video')->first()->custom_lang) }}
                            @endif</h3>
                        </div>
                    </div>

                    @foreach ($department->videos as $video)


                        <div class="col-md-6">
                            <div class="video-item mt_30">
                                <div class="video-img">
                                    @php
                                        $video_id=explode("=",$video->link);

                                    @endphp
                                    <img src="https://img.youtube.com/vi/{{ $video_id[1] }}/0.jpg">
                                    <div class="video-section">
                                        <a class="video-button mgVideo" href="{{ $video->link }}"><span></span></a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="service-sidebar pt_30">
                    <div class="service-widget">
                        <ul>
                            @foreach ($departments as $item)
                            <li class="{{ $item->id==$department->id ? 'active':'' }}"><a href="{{ url('department-details/'.$item->slug) }}"><i class="fas fa-chevron-right"></i>@if($setting->text_direction=='RTL'){{ $item->name}}@else
                            {{ $translator->setTarget('en')->translate($item->name) }}
                            @endif</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="service-widget-contact mt_45">
                        <h2>@if($setting->text_direction=='RTL'){{ $contactInfo->header}}@else
                            {{ $translator->setTarget('en')->translate($contactInfo->header) }}
                            @endif</h2>
                        <p>@if($setting->text_direction=='RTL'){{ $contactInfo->description}}@else
                            {{ $translator->setTarget('en')->translate($contactInfo->description) }}
                            @endif</p>
                        <ul>
                            <li><i class="fas fa-phone"></i> {!! nl2br(e($contactInfo->phones)) !!}</li>
                            <li><i class="far fa-envelope"></i> {!! nl2br(e($contactInfo->emails)) !!}</li>
                            <li><i class="fas fa-map-marker-alt"></i>{!! nl2br(e($contactInfo->address)) !!}</li>
                        </ul>
                    </div>
                    <div class="service-qucikcontact event-form mt_30">
                        <h3>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','quick_contact')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','quick_contact')->first()->custom_lang) }}
                            @endif</h3>
                        <form action="{{ url('contact-message') }}" method="POST">
                            @csrf
                            <div class="form-row row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" id="name" placeholder="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','name')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','name')->first()->custom_lang) }}
                            @endif" name="name">
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" placeholder="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','phone')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','phone')->first()->custom_lang) }}
                            @endif" name="phone">
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="email" class="form-control" placeholder="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','email')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','email')->first()->custom_lang) }}
                            @endif" name="email">
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" placeholder="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','subject')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','subject')->first()->custom_lang) }}
                            @endif" name="subject">
                                </div>

                                <div class="form-group col-md-12">
                                    <textarea name="message" class="form-control" placeholder="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','msg')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','msg')->first()->custom_lang) }}
                            @endif"></textarea>
                                </div>
                                @if ($setting->allow_captcha==1)
                                <div class="form-group col-12">
                                    <div class="g-recaptcha" data-sitekey="{{ $setting->captcha_key }}"></div>
                                </div>
                                @endif

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','send_msg')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','send_msg')->first()->custom_lang) }}
                            @endif</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>


@if ($doctors->count()!=0)
<div class="team-page pt_40 pb_70 bg_f2f2f2">
    <div class="container">
        <div class="row">
            <div class="col-md-12 wow fadeInDown" data-wow-delay="0.1s">
                <div class="main-headline">
                    <h1>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','department_doctor')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','department_doctor')->first()->custom_lang) }}
                            @endif</h1>
                    <p>@if($setting->text_direction=='RTL'){{ $description}}@else
                            {{ $translator->setTarget('en')->translate($description) }}
                            @endif</p>
                </div>
            </div>
        </div>


        <div class="row">

            @if ($doctors->count()!=0)
            @foreach ($doctors as $doctor)
            <div class="col-lg-3 col-md-4 col-6 mt_30">
                <div class="team-item">
                    <div class="team-photo">
                        <img src="{{ url($doctor->image) }}" alt="Team Photo">
                    </div>
                    <div class="team-text">
                        <a href="{{ url('doctor-details/'.$doctor->slug) }}">@if($setting->text_direction=='RTL'){{ ucfirst($doctor->name)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($doctor->name)) }}
                            @endif</a>
                        <p>@if($setting->text_direction=='RTL'){{ ucfirst($doctor->department->name)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($doctor->department->name)) }}
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
            </div>
            @endforeach
            @else
            <h3 class="text-danger text-center">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','doc_not_found')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','doc_not_found')->first()->custom_lang) }}
                            @endif</h3>
            @endif


        </div>
    </div>
</div>
@endif





@endsection
