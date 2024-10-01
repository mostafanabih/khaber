@extends('layouts.patient.layout')
@section('patient-content')
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->privacy_and_policy ? url($banner->privacy_and_policy) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@if($setting->text_direction=='RTL'){{ $navigation->privacy_policy}}@else
                            {{ $translator->setTarget('en')->translate($navigation->privacy_policy) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif{{ $navigation->home }}</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $navigation->privacy_policy}}@else
                            {{ $translator->setTarget('en')->translate($navigation->privacy_policy) }}
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
                @if ($privacy_count != 0)
                @if($setting->text_direction=='RTL'){!! clean($condition->privacy_policy)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($condition->privacy_policy)) !!}
                            @endif
                @endif

            </div>
        </div>
    </div>
</div>

@endsection
