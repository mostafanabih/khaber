@extends('layouts.patient.layout')
@section('title')
<title>{{ $page->seo_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $page->seo_description }}">
@endsection
@section('patient-content')
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->custom_page ? url($banner->custom_page) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@if($setting->text_direction=='RTL'){{ $page->page_name}}@else
                            {{ $translator->setTarget('en')->translate($page->page_name) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $page->page_name}}@else
                            {{ $translator->setTarget('en')->translate($page->page_name) }}
                            @endif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->


<div class="about-style1 pt_50 pb_50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            @if($setting->text_direction=='RTL'){!! clean($page->description) !!}@else
                            {!! $translator->setTarget('en')->translate(clean($page->description)) !!}
                            @endif
            </div>
        </div>
    </div>
</div>



@endsection
