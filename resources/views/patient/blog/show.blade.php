@extends('layouts.patient.layout')
@section('title')
<title>{{ @$blog->seo_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ @$blog->seo_description }}">
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
                    <h1>@if($setting->text_direction=='RTL'){{ $blog->title}}@else
                            {{ $translator->setTarget('en')->translate($blog->title) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><a href="{{ url('/blog') }}">@if($setting->text_direction=='RTL'){{ $navigation->blog}}@else
                            {{ $translator->setTarget('en')->translate($navigation->blog) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $blog->title}}@else
                            {{ $translator->setTarget('en')->translate($blog->title) }}
                            @endif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Blog Start-->
<div class="blog-page single-blog pt_40 pb_90">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-item">
                    <div class="single-blog-image">
                        <img src="{{ url($blog->feature_image) }}" alt="">
                        <div class="blog-author">
                            <span><i class="fas fa-user"></i> @if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','admin')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','admin')->first()->custom_lang) }}
                            @endif</span>
                            <span><i class="far fa-calendar-alt"></i> {{ $blog->created_at->format('m-d-Y') }}</span>
                            <span><i class="fas fa-tag" aria-hidden="true"></i> @if($setting->text_direction=='RTL'){{ $blog->category->name}}@else
                            {{ $translator->setTarget('en')->translate($blog->category->name) }}
                            @endif</span>
                        </div>
                    </div>
                    <div class="blog-text pt_40">
                        <p>
                        @if($setting->text_direction=='RTL'){!! clean($blog->sort_description) !!}@else
                            {!! $translator->setTarget('en')->translate(clean($blog->sort_description)) !!}
                            @endif 
                        </p>

                        @if($setting->text_direction=='RTL'){!! clean($blog->description) !!}@else
                            {!! $translator->setTarget('en')->translate(clean($blog->description)) !!}
                            @endif
                    </div>
                </div>
                @if ($setting->comment_type==0)
                <div class="comment-list mt_30">
                    <h4>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','comments')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','comments')->first()->custom_lang) }}
                            @endif</h4>
                </div>
                <div class="fb-comments" data-href="{{ Request::url() }}" data-width="" data-numposts="10"></div>
                @else
                <div class="comment-list mt_30">
                    @if ($blog->comments->where('status',1)->count() !=0)
                    <h4>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','comments')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','comments')->first()->custom_lang) }}
                            @endif<span class="c-number">({{ $blog->comments->where('status',1)->count() }})</span></h4>
                    @endif

                    <ul>
                        @foreach ($blog->comments->where('status',1) as $comment)
                        <li>
                            <div class="comment-item">
                                <div class="thumb">
                                    @php
                                    $gravatar_link = 'http://www.gravatar.com/avatar/' . md5($comment->email) . '?s=32';
                                    header("content-type: image/jpeg");
                                    @endphp
                                    <img src="{{ $gravatar_link }}" alt="">
                                </div>
                                <div class="com-text">
                                    <h5>{{ ucwords($comment->name) }}</h5>
                                    <span class="date"><i class="fas fa-calendar"></i>{{ date('d F, Y', strtotime($comment->created_at->format('Y-m-d'))) }}</span>
                                    <p>
                                        {{ $comment->comment }}
                                    </p>
                                </div>
                            </div>
                        </li>

                        @endforeach

                    </ul>
                </div>
                <div class="comment-form mt_30">
                    <h4>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','submit_a_comment')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','submit_a_comment')->first()->custom_lang) }}
                            @endif</h4>
                    <form method="POST" action="{{ url('comment-store') }}">
                        @csrf
                        <div class="form-row row">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="name" placeholder="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','name')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','name')->first()->custom_lang) }}
                            @endif">
                                <input type="hidden" class="form-control" name="blog_id" value="{{ $blog->id }}" value="{{ old('name') }}">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="email" placeholder="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','email')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','email')->first()->custom_lang) }}
                            @endif" value="{{ old('email') }}">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" value="{{ old('phone') }}" class="form-control" name="phone" placeholder="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','phone')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','phone')->first()->custom_lang) }}
                            @endif">
                            </div>
                            <div class="form-group col-12">
                                <textarea class="form-control" name="comment" placeholder="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','comment')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','comment')->first()->custom_lang) }}
                            @endif">{{ old('comment') }}</textarea>
                            </div>
                            @if($setting->allow_captcha==1)
                            <div class="form-group col-12">
                                <div class="g-recaptcha" data-sitekey="{{ $setting->captcha_key }}"></div>
                            </div>
                            @endif
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','submit')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','submit')->first()->custom_lang) }}
                            @endif</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif

            </div>
            <div class="col-lg-4">
                <div class="sidebar">
                    <div class="sidebar-item">
                        <h3>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','blog_cat')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','blog_cat')->first()->custom_lang) }}
                            @endif</h3>
                        <ul>
                            @foreach ($blogCategories as $category)
                                <li class="{{ $blog->blog_category_id==$category->id ? 'active' :'' }}"><a href="{{ url('blog-category/'.$category->slug) }}"><i class="fas fa-chevron-right"></i>@if($setting->text_direction=='RTL'){{ $category->name}}@else
                            {{ $translator->setTarget('en')->translate($category->name) }}
                            @endif</a></li>
                            @endforeach


                        </ul>
                    </div>
                    <div class="sidebar-item">
                        <h3>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','recent_post')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','recent_post')->first()->custom_lang) }}
                            @endif</h3>
                        @foreach ($latestBlog as $item)
                            <div class="blog-recent-item">
                                <div class="blog-recent-photo">
                                    <a href="{{ url('blog-details/'.$item->slug) }}"><img src="{{ url($item->thumbnail_image) }}" alt=""></a>
                                </div>
                                <div class="blog-recent-text">
                                    <a href="{{ url('blog-details/'.$item->slug) }}">@if($setting->text_direction=='RTL'){{ $item->title}}@else
                            {{ $translator->setTarget('en')->translate($item->title) }}
                            @endif</a>
                                    <div class="blog-post-date">{{ $item->created_at->format('m-d-Y') }}</div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
                <!--Sidebar End-->
            </div>
        </div>
    </div>
</div>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0&appId={{ $setting->facebook_comment_script }}&autoLogAppEvents=1" nonce="MoLwqHe5"></script>
@endsection
