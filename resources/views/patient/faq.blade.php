@extends('layouts.patient.layout')
@section('title')
<title>{{ $title_meta->faq_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->faq_meta_description }}">
@endsection
@section('patient-content')
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->faq ? url($banner->faq) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@if($setting->text_direction=='RTL'){{ $navigation->faq}}@else
                            {{ $translator->setTarget('en')->translate($navigation->faq) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $navigation->faq}}@else
                            {{ $translator->setTarget('en')->translate($navigation->faq) }}
                            @endif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Faq Start-->
<div class="faq-area pt_20 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="faq-service feature-section-text mt_50">
                    <div class="feature-accordion" id="accordion">
                        @foreach ($faqCategories as $index => $category)
                            @if ($category->faqs->count()!=0)
                                <div class="faq-single-item"><h2>@if($setting->text_direction=='RTL'){{ $category->name}}@else
                            {{ $translator->setTarget('en')->translate($category->name) }}
                            @endif</h2>
                                @foreach ($category->faqs as $faq)
                                    <div class="faq-item card">
                                        <div class="faq-header" id="heading->{{ $faq->id }}">
                                            <button class="faq-button collapsed" data-toggle="collapse" data-target="#collapse-{{ $faq->id }}" aria-expanded="true" aria-controls="collapse-{{ $faq->id }}">@if($setting->text_direction=='RTL'){{ $faq->question}}@else
                            {{ $translator->setTarget('en')->translate($faq->question) }}
                            @endif</button>
                                        </div>

                                        <div id="collapse-{{ $faq->id }}" class="collapse" aria-labelledby="heading->{{ $faq->id }}" data-parent="#accordion">
                                            <div class="faq-body">
                                            @if($setting->text_direction=='RTL'){{ clean($faq->answer)}}@else
                            {{ $translator->setTarget('en')->translate(clean($faq->answer)) }}
                            @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            @endif

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Faq End-->



@endsection
