@extends('layouts.patient.layout')
@section('title')
<title>{{ $title_meta->department_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->department_meta_description }}">
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
                    <h1>@if($setting->text_direction=='RTL'){{ $navigation->department}}@else
                            {{ $translator->setTarget('en')->translate($navigation->department) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $navigation->department}}@else
                            {{ $translator->setTarget('en')->translate($navigation->department) }}
                            @endif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<div class="case-study-home-page case-study-area pt_50">
    <div class="container">
        <div class="row">
            @foreach ($departments as $department)
            <div class="col-lg-4 col-md-6 mt_15">
                <div class="case-item">
                    <div class="case-box">
                        <div class="case-image">
                            <img src="{{ $department->thumbnail_image }}" alt="">
                            <div class="overlay"><a href="{{ url('department-details/'.$department->slug) }}" class="btn-case">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','see_details')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','see_details')->first()->custom_lang) }}
                            @endif</a>
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
        <div class="mb-5">
            {{ $departments->links('patient.paginator') }}
        </div>

    </div>
</div>


@endsection
