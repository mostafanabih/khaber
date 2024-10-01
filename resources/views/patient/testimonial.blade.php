@extends('layouts.patient.layout')
@section('title')
<title>{{ $title_meta->testimonial_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->testimonial_meta_description }}">
@endsection
@section('patient-content')
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->testimonial ? url($banner->testimonial) : url('patient/img/banner.png') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@if($setting->text_direction=='RTL'){{ $navigation->testimonial}}@else
                            {{ $translator->setTarget('en')->translate($navigation->testimonial) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $navigation->testimonial}}@else
                            {{ $translator->setTarget('en')->translate($navigation->testimonial) }}
                            @endif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Testimonial Start-->
<div class="testimonial-page pt_40 pb_70">
    <div class="container">
        <div class="row">
            @foreach ($testimonials as $testimonial)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="testimonial-item mt_30">
                    <p>
                    @if($setting->text_direction=='RTL'){{ $testimonial->description}}@else
                            {{ $translator->setTarget('en')->translate($testimonial->description) }}
                            @endif
                    </p>
                    <div class="testi-info">
                        <img src="{{ url($testimonial->image) }}" alt="">
                        <h4>@if($setting->text_direction=='RTL'){{ $testimonial->name}}@else
                            {{ $translator->setTarget('en')->translate($testimonial->name) }}
                            @endif</h4>
                        <span>@if($setting->text_direction=='RTL'){{ $testimonial->designation}}@else
                            {{ $translator->setTarget('en')->translate($testimonial->designation) }}
                            @endif</span>
                    </div>
                    <div class="testi-link">
                        <a href="javascript:void;"></a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        {{ $testimonials->links('patient.paginator') }}
    </div>
</div>
<!--Testimonial End-->




@endsection
