@extends('layouts.patient.layout')
@section('title')
<title>{{ $title_meta->aboutus_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->aboutus_meta_description }}">
@endsection
@section('patient-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->about_us ? url($banner->about_us) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $navigation->about_us }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span>{{ $navigation->about_us }}</span></li>
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
                    <h1><span>{{ ucfirst($offersection->first_header) }}</span> {{ ucfirst($offersection->second_header) }}</h1>
                    <p>{{ $offersection->description }}</p>
                </div>
            </div>
                <!-- Section Title End -->
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="project-slider">
                        <div class="swiper offers">
                            <div class="swiper-wrapper">
                            <!-- Recent Projects Slider -->
                            @foreach($offers as $offer)
                                <!-- recent projects slide Start -->
                                <div class="swiper-slide">
                                    <div class="project-item">
                                        <div class="project-image">
                                            <figure class="image-anime">
                                                <img src="{{ url($offer->image) }}" alt="">
                                            </figure>
                                        </div>
                                        <div class="project-content">
                                            <div class="project-content-title">
                                                <h3><a href="#"  data-toggle="modal" data-target="#offer_modal" data-offer-id="{{ $offer->id }}" data-offer-name="{{ $offer->name }}" data-offer-img="{{$offer->image}}">احجز الحين</a></h3>
                                                <span><a href="#" data-toggle="modal" data-target="#offer_modal" data-offer-id="{{ $offer->id }}" data-offer-name="{{ $offer->name }}" data-offer-img="{{$offer->image}}"><i class="fas fa-arrow-right"></i></a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- recent projects slide End -->
                            @endforeach

                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <div class="client-button-prev"><i class="fas fa-arrow-alt-circle-left"></i></div>
                        <div class="client-button-next"><i class="fas fa-arrow-alt-circle-right"></i></div>
                    </div>
                </div>
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
                <img style="width:80%;height:200px;">
                </div>
            <form action="{{route('createAppointmentWithOffer')}}" method="post">
    @csrf
    <div class="form-group">
        <label for="">الاسم</label>
        <input type="text" id="nameField" name="patient_name" class="form-control">
    </div>

    <div class="form-group">
        <label for="">رقم الهاتف</label>
        <input type="number" id="phn_id" name="phone" class="form-control">
    </div>
    <div class="form-group" hidden>
        <input name="offer_id" id="servicerb"  type="text" class="form-control">
    </div>
    <div class="form-group text-center">
        <input type="submit" value="سجل الأن" style="width:100%;padding:7px;background-color: #002945 !important;color: #fff;">
    </div>
</form>
            </div>
        </div>
    </div>
</div>


@endsection




