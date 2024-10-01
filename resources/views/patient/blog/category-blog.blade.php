@extends('layouts.patient.layout')
@section('title')
<title>{{ $title_meta->blog_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->blog_meta_description }}">
@endsection
@section('patient-content')
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp



<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->blog ? url($banner->blog) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@if($setting->text_direction=='RTL'){{ $category->name}}@else
                            {{ $translator->setTarget('en')->translate($category->name) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $category->name}}@else
                            {{ $translator->setTarget('en')->translate($category->name) }}
                            @endif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<div class="blog-page pt_40 pb_90">
    @if ($blogs->count()!=0)
    <div class="container">
        <div class="row">
            @foreach ($blogs as $blog)
            <div class="col-lg-4 col-sm-6">
                <div class="blog-item">
                    <div class="blog-image">
                        <img src="{{ url($blog->thumbnail_image) }}" alt="">
                    </div>
                    <div class="blog-author">
                        <span><i class="fas fa-user"></i> @if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','admin')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','admin')->first()->custom_lang) }}
                            @endif</span>
                        <span><i class="far fa-calendar-alt"></i> {{ $blog->created_at->format('F-d-Y') }}</span>
                    </div>
                    <div class="blog-text">
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
            </div>
            @endforeach
        </div>
        <!--Pagination Start-->
        {{ $blogs->links('patient.paginator') }}
        <!--Pagination End-->
    </div>
    @else
        <div class="container">
            <h1 class="text-center text-danger display-4">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','blog_not_found')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','blog_not_found')->first()->custom_lang) }}
                            @endif</h1>
        </div>
    @endif

</div>

@endsection
