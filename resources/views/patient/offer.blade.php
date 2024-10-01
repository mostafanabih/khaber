@extends('layouts.patient.layout')
@section('title')
<title>{{ $title_meta->aboutus_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->aboutus_meta_description }}">
@endsection
@section('patient-content')
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->about_us ? url($banner->about_us) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@if($setting->text_direction=='RTL'){{ $navigation->offers}}@else
                            {{ $translator->setTarget('en')->translate($navigation->offers) }}
                            @endif</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                        <li><span style="color:#fff !important;">@if($setting->text_direction=='RTL'){{ $navigation->offers}}@else
                            {{ $translator->setTarget('en')->translate($navigation->offers) }}
                            @endif</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!-- recent project section Start -->
<div class="recent-project">
    <div class="container">
        <div class="row">
            <!-- Section Title Start -->
            <div class="col-md-12 wow fadeInDown">
                <div class="main-headline">
                    <h1><span>@if($setting->text_direction=='RTL'){{ ucfirst($offersection->first_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($offersection->first_header)) }}
                            @endif</span> @if($setting->text_direction=='RTL'){{ ucfirst($offersection->second_header)}}@else
                            {{ $translator->setTarget('en')->translate(ucfirst($offersection->second_header)) }}
                            @endif</h1>
                    <p>@if($setting->text_direction=='RTL'){{ $offersection->description}}@else
                            {{ $translator->setTarget('en')->translate($offersection->description) }}
                            @endif</p>
                </div>
            </div>
            <!-- Section Title End -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs" id="departmentTabs" role="tablist">
                    @foreach($departments as $department)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link @if($loop->first) active @endif" id="department-{{ $department->id }}-tab" data-toggle="tab" href="#department-{{ $department->id }}" role="tab" aria-controls="department-{{ $department->id }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">@if($setting->text_direction=='RTL'){{ $department->name}}@else
                            {{ $translator->setTarget('en')->translate($department->name) }}
                            @endif</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="tab-content" id="departmentTabsContent">
            @foreach($departments as $department)
            <div class="tab-pane fade @if($loop->first) show active @endif" id="department-{{ $department->id }}" role="tabpanel" aria-labelledby="department-{{ $department->id }}-tab">
                <div class="row">
                    @foreach($department->offers as $offer)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="project-item">
                            <div class="project-image">
                                <figure class="image-anime">
                                    <img src="{{ url($offer->image) }}" alt="" style="object-fit:fill;">
                                </figure>
                            </div>
                            <div class="project-content">
                                <div class="project-content-title" data-toggle="modal" data-target="#offer_modal" data-offer-id="{{ $offer->id }}" data-offer-name="{{ $offer->name }}" data-offer-img="{{$offer->image}}">
                                    <h3><a href="#" data-toggle="modal" data-target="#offer_modal" data-offer-id="{{ $offer->id }}" data-offer-name="{{ $offer->name }}" data-offer-img="{{$offer->image}}">@if($setting->text_direction=='RTL')"احجز الحين"@else
                            {{ $translator->setTarget('en')->translate("احجز الحين") }}
                            @endif</a></h3>
                                    <span><a href="#" data-toggle="modal" data-target="#offer_modal" data-offer-id="{{ $offer->id }}" data-offer-name="{{ $offer->name }}" data-offer-img="{{$offer->image}}"><i class="fas fa-arrow-right"></i></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
    <!-- recent project section End -->

    <!-- Modal Template -->
<div class="modal fade" id="offer_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body book-appointment">
                <div class="text-center">
                <img style="width:80%;height:100%;">
                </div>
            <form action="{{route('createAppointmentWithOffer')}}" method="post">
    @csrf
    <div class="form-group">
        <label for="">@if($setting->text_direction=='RTL')"الاسم"@else
                            {{ $translator->setTarget('en')->translate("الاسم") }}
                            @endif</label>
        <input type="text" id="nameField" name="patient_name" class="form-control">
    </div>

    <div class="form-group">
        <label for="">@if($setting->text_direction=='RTL')"رقم الهاتف"@else
                            {{ $translator->setTarget('en')->translate("رقم الهاتف") }}
                            @endif</label>
        <input type="number" id="phn_id" name="phone" class="form-control">
    </div>
    <div class="form-group" hidden>
        <input name="offer_id" id="servicerb"  type="text" class="form-control">
    </div>
    <div class="form-group text-center">
        <input type="submit" value="@if($setting->text_direction=='RTL')'سجل الأن'@else
                            {{ $translator->setTarget('en')->translate('سجل الأن') }}
                            @endif" style="width:100%;padding:7px;background-color: #002945 !important;color: #fff;">
    </div>
</form>
            </div>
        </div>
    </div>
</div>


@endsection




