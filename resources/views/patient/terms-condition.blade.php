@extends('layouts.patient.layout')
@section('patient-content')
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp



<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->terms_and_condition ? url($banner->terms_and_condition) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@if($setting->text_direction=='RTL'){{ $navigation->terms_and_condition}}@else
                            {{ $translator->setTarget('en')->translate($navigation->terms_and_condition) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $navigation->terms_and_condition}}@else
                            {{ $translator->setTarget('en')->translate($navigation->terms_and_condition) }}
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
                @if ($condition_count !=0 )
                @if($setting->text_direction=='RTL'){!! clean($condition->terms_condition)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($condition->terms_condition)) !!}
                            @endif
                @endif

            </div>
        </div>
    </div>
</div>


@endsection
