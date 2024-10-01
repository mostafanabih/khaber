@extends('layouts.patient.layout')
@section('title')
<title>{{ $service->seo_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $service->seo_description }}">
@endsection
@section('patient-content')
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->service ? url($banner->service) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@if($setting->text_direction=='RTL'){{ $service->header}}@else
                            {{ $translator->setTarget('en')->translate($service->header) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $service->header}}@else
                            {{ $translator->setTarget('en')->translate($service->header) }}
                            @endif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Service Detail Start-->
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
                                @foreach ($service->images as $item)
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
                                @foreach ($service->images as $item)
                                <div class="swiper-slide"><img src="{{ url($item->small_image) }}" alt=""></div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                @if($setting->text_direction=='RTL'){!! clean($service->long_description)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($service->long_description)) !!}
                            @endif
                </div>
                @if ($service->faqs->count() != 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="faq-service feature-section-text mt_50">
                            <h2>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','faqs')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','faqs')->first()->custom_lang) }}
                            @endif</h2>
                            <div class="feature-accordion" id="accordion">
                                @foreach ($service->faqs as $faq)
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
                            @endif 
                                        </div>
                                    </div>
                                </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if ($service->videos->count()!=0)
                <div class="row mt_50">
                    <div class="col-12">
                        <div class="video-headline">
                            <h3>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','related_video')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','related_video')->first()->custom_lang) }}
                            @endif</h3>
                        </div>
                    </div>

                    @foreach ($service->videos as $video)
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
                            @foreach ($services as $item)
                            <li class="{{ $item->id==$service->id ? 'active':'' }}"><a href="{{ url('service-details/'.$item->slug) }}"><i class="fas fa-chevron-right"></i> @if($setting->text_direction=='RTL'){{ $item->header}}@else
                            {{ $translator->setTarget('en')->translate($item->header) }}
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
<!--Service Detail End-->


@endsection
