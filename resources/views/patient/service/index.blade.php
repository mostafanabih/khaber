@extends('layouts.patient.layout')
@section('title')
<title>{{ $title_meta->service_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->service_meta_description }}">
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
                    <h1>@if($setting->text_direction=='RTL'){{ $navigation->service}}@else
                            {{ $translator->setTarget('en')->translate($navigation->service) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $navigation->service}}@else
                            {{ $translator->setTarget('en')->translate($navigation->service) }}
                            @endif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->


<div class="service-area bg-area">
    <div class="container">

        <div class="row service-row">
            <div class="col-md-12">
                <div class="service-coloum-area">
                    @foreach ($services as $service)
                    <div class="service-coloum">
                        <div class="service-item">
                            <i class="{{ $service->icon }}"></i>
                            <h3>@if($setting->text_direction=='RTL'){{ $service->header}}@else
                            {{ $translator->setTarget('en')->translate($service->header) }}
                            @endif</h3>
                            <p>@if($setting->text_direction=='RTL'){{ $service->sort_description}}@else
                            {{ $translator->setTarget('en')->translate($service->sort_description) }}
                            @endif</p>
                            <a href="{{ url('service-details/'.$service->slug) }}">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','service_details')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','service_details')->first()->custom_lang) }}
                            @endif →</a>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        {{ $services->links('patient.paginator') }}
    </div>
</div>



@endsection
