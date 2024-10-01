@extends('layouts.patient.layout')
@section('title')
<title>{{ $title_meta->doctor_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->doctor_meta_description }}">
@endsection
@section('patient-content')
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->doctor ? url($banner->doctor) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@if($setting->text_direction=='RTL'){{ $navigation->doctor}}@else
                            {{ $translator->setTarget('en')->translate($navigation->doctor) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $navigation->doctor}}@else
                            {{ $translator->setTarget('en')->translate($navigation->doctor) }}
                            @endif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->


<div class="doctor-search">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="s-container">
                <form action="{{ url('search-doctor') }}">

                    <div class="s-box">
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
                    <div class="s-box">
                        <select name="department" class="form-control select2">
                            <option value="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_dep')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_dep')->first()->custom_lang) }}
                            @endif</option>
                            @foreach ($departments as $department)
                            <option {{ @$department_id==$department->id?'selected':'' }} value="{{ $department->id }}">@if($setting->text_direction=='RTL'){{ ucwords($department->name)}}@else
                            {{ $translator->setTarget('en')->translate(ucwords($department->name)) }}
                            @endif</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="s-box">
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
                    <div class="s-button">
                        <button type="submit">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','search')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','search')->first()->custom_lang) }}
                            @endif</button>
                    </div>
                </form>
                </div>

            </div>
        </div>
    </div>
</div>




<!--Service Start-->
<div class="team-page pt_40 pb_70">
    <div class="container">
        <div class="row">

            @if ($doctors->count()!=0)
            @foreach ($doctors as $doctor)
            <div class="col-lg-3 col-md-4 col-6 mt_30">
                <div class="team-item">
                    <div class="team-photo">
                        <img src="{{ url($doctor->image) }}" alt="Team Photo" style="border-radius:0px;">
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
        {{ @$doctors->links('patient.paginator') }}
    </div>
</div>
<!--Service End-->






@endsection
