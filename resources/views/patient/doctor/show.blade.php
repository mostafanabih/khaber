@extends('layouts.patient.layout')
@section('title')
<title>{{ $doctor->seo_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $doctor->seo_description }}">
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
                    <h1>@if($setting->text_direction=='RTL'){{ ucfirst($doctor->name)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($doctor->name)) }}
                            @endif (@if($setting->text_direction=='RTL'){{ $doctor->designations}}@else
                            {{ $translator->setTarget('en')->translate($doctor->designations) }}
                            @endif)</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ ucfirst($doctor->name)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($doctor->name)) }}
                            @endif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Team Detail Start-->
<div class="team-detail-page pt_40 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="team-detail-photo">
                    <img src="{{ url($doctor->image) }}" alt="Team Photo">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="team-detail-text">
                    <h4>@if($setting->text_direction=='RTL'){{ $doctor->name}}@else
                            {{ $translator->setTarget('en')->translate($doctor->name) }}
                            @endif </h4>
                    <span><b>@if($setting->text_direction=='RTL'){{ $doctor->department->name}}@else
                            {{ $translator->setTarget('en')->translate($doctor->department->name) }}
                            @endif (@if($setting->text_direction=='RTL'){{ $doctor->designations}}@else
                            {{ $translator->setTarget('en')->translate($doctor->designations) }}
                            @endif)</b></span>
                    <h5 class="appointment-cost">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','fee')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','fee')->first()->custom_lang) }}
                            @endif: {{ $currency->currency_icon }}{{ $doctor->fee }}</h5>
                            @if($setting->text_direction=='RTL'){!! clean($doctor->about)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($doctor->about)) !!}
                            @endif
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
    </div>
</div>
<div class="team-exp-area bg-area pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="team-headline">
                    <h2>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','doctor_info')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','doctor_info')->first()->custom_lang) }}
                            @endif</h2>
                </div>
            </div>
            <div class="col-md-12">
                <!--Tab Start-->
                <div class="event-detail-tab mt_20">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a class="active" href="#working_hour" data-toggle="tab">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','working_hour')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','working_hour')->first()->custom_lang) }}
                            @endif</a>
                        </li>
                        <li>
                            <a href="#address" data-toggle="tab">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','address')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','address')->first()->custom_lang) }}
                            @endif</a>
                        </li>
                        <li>
                            <a href="#education" data-toggle="tab">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','education')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','education')->first()->custom_lang) }}
                            @endif</a>
                        </li>
                        <li>
                            <a href="#experience" data-toggle="tab">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','experience')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','experience')->first()->custom_lang) }}
                            @endif</a>
                        </li>
                        <li>
                            <a href="#qualification" data-toggle="tab">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','qualification')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','qualification')->first()->custom_lang) }}
                            @endif</a>
                        </li>
                        <li>
                            <a href="#book_appointment" data-toggle="tab">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','app')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','app')->first()->custom_lang) }}
                            @endif</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content event-detail-content">
                    <div id="working_hour" class="tab-pane fade show active">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="wh-table table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','week_day')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','week_day')->first()->custom_lang) }}
                            @endif</th>
                                                <th>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','schedule')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','schedule')->first()->custom_lang) }}
                            @endif</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $old_day_id=0;
                                            @endphp
                                            @foreach ($doctor->schedules as $schedule)
                                            @if ($old_day_id != $schedule->day_id)
                                            <tr>
                                                <td>{{ $schedule->day->custom_day }}</td>
                                                <td>
                                                    @php
                                                        $times=$doctor->schedules->where('day_id',$schedule->day_id);
                                                    @endphp
                                                    @foreach ($times as $time)
                                                    <div class="sch">{{ strtoupper($time->start_time) }} - {{ strtoupper($time->end_time) }}</div>
                                                    @endforeach

                                                </td>
                                            </tr>
                                            @endif
                                            @php
                                                $old_day_id=$schedule->day_id;
                                            @endphp


                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="address" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12">
                            @if($setting->text_direction=='RTL'){!! clean($doctor->address)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($doctor->address)) !!}
                            @endif

                            </div>
                        </div>
                    </div>
                    <div id="education" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12">
                            @if($setting->text_direction=='RTL'){!! clean($doctor->educations)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($doctor->educations)) !!}
                            @endif 
                            </div>
                        </div>
                    </div>
                    <div id="experience" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12">
                            @if($setting->text_direction=='RTL'){!! clean($doctor->experience)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($doctor->experience)) !!}
                            @endif 
                            </div>
                        </div>
                    </div>
                    <div id="qualification" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12">
                            @if($setting->text_direction=='RTL'){!! clean($doctor->qualifications)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($doctor->qualifications)) !!}
                            @endif 
                            </div>
                        </div>
                    </div>
                    <div id="book_appointment" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','create_app')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','create_app')->first()->custom_lang) }}
                            @endif</h3>

                                <div class="book-appointment">

                                    <form action="{{ url('create-appointment') }}" method="POST" >
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="" class="form-label">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_date')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_date')->first()->custom_lang) }}
                            @endif</label>
                                                    <input type="text" name="date" class="form-control datepicker" id="datepicker-value">
                                                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}" id="doctor_id">
                                                    <input type="hidden" value="{{ $doctor->department_id }}" name="department_id">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-none" id="schedule-box-outer">
                                            <div class="col-md-6">
                                                <div class="mb-3" >
                                                    <label for="" class="form-label">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_schedule')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_schedule')->first()->custom_lang) }}
                            @endif</label>
                                                    <select name="schedule_id" class="form-control" id="doctor-available-schedule">

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 d-none" id="doctor-schedule-error">

                                            </div>
                                        </div>



                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary mb-3" id="sub" disabled>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','submit')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','submit')->first()->custom_lang) }}
                            @endif</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!--Tab End-->
            </div>

        </div>
    </div>
</div>
<!--Team Detail End-->


@endsection
