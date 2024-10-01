@php
$navbar=App\ManageNavigation::first();
$navigation=App\Navigation::first();
$logo=App\Setting::first();
$websiteLang=App\ManageText::all();
$setting=App\Setting::first();
@endphp
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp

<!DOCTYPE html>
@if ($setting->text_direction=='RTL')
<html class="no-js" lang="ar" dir="rtl">
@else
<html class="no-js" lang="en">
@endif
<head>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <!-- Title -->
    @yield('title')
    @yield('meta')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ url($logo->favicon) }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Stylesheets -->
     <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{ asset('patient/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/datatable.min.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/cookie-consent.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/prescription.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/dev.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />



    <link rel="stylesheet" href="{{ asset('patient/css/style.css') }}">
    
    @if ($setting->text_direction=='RTL')
        <link rel="stylesheet" href="{{ asset('patient/css/rtl.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('patient/css/responsive.css') }}">


    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('patient/css/jquery-ui.css') }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        /* for blue color */
        .header-area,
        .faq-header button.faq-button.collapsed,
        .faq-header button.faq-button:before,
        .home-button a,
        .video-section-home .video-button:before,
        .doctor-search .s-button button,
        .team-detail-text ul li a,
        .event-detail-tab ul,
        .event-detail-tab ul li a,
        .service-widget-contact,
        .event-form .btn,
        .blog-page .blog-author,
        .sidebar-item ul li.active a,
        .sidebar-item ul li a:hover,
        .comment-form .btn,
        .contact-info-item.bg2
        .contact-form .btn,
        .bank.contact-info-item.bg2,
        .dash-item.db-blue,
        .dashboard-account-info,
        .dashboard-widget li a,
        .add-form .btn,
        ul.page-numbers li a
         {
            background: {{ $logo->theme_one }} !important;
        }

        .home-button a{
            border: 1px solid {{ $logo->theme_one }}
        }


        .case-item .case-content h4:before,
        .service-widget ul li.active a, .service-widget ul li a:hover{
            background-color: {{ $logo->theme_one }} !important;
        }

        .event-detail-tab ul li a.active{
            background: #fff !important;
        }

        .choose-item:before{
            background: rgba(0,82,138,.8) !important;
        }
        .header-area:before,
        .header-area:after{
            border-top: 18px solid {{ $logo->theme_one }}  !important;
        }

        .header-area:before{
            border-right: 18px solid {{ $logo->theme_one }} !important;
        }

        .header-area:after{
            border-left: 18px solid {{ $logo->theme_one }} !important;
        }

        .main-headline h1 span,
        .testi-info h4,
        .blog-item.sm_btn{
            color: {{ $logo->theme_one }} !important;
        }
        .owl-testimonial .owl-dots .owl-dot,
        .owl-carousel.team-carousel .owl-dots .owl-dot,
        .owl-carousel.blog-carousel .owl-dots .owl-dot
        {
            border: 5px solid {{ $logo->theme_one }} !important
        }
        .about-skey:before,
        .mission-img:before,
        .video-item:before
        {
            border-top:170px solid {{ $logo->theme_one }} !important;

        }
        .about-skey:after,
        .mission-img:after,
        .video-item:after{
            border-bottom: 170px solid {{ $logo->theme_one }} !important;
        }

        .brand-item:before,
        .dashboard-widget li.active a,
        .dashboard-widget li a:hover
        {
            border-right: 3px solid {{ $logo->theme_one }} !important;
            border-left: 3px solid {{ $logo->theme_one }} !important;

        }

        .brand-item:after{
            border-bottom: 3px solid {{ $logo->theme_one }} !important;
            border-top: 3px solid {{ $logo->theme_one }} !important;
        }
        .brand-colume:after {
            border-bottom: 25px solid {{ $logo->theme_one }} !important;
        }

        .about1-inner img{
            border: 10px solid {{ $logo->theme_one }};
        }

        /* end blue color */




        /* start red color */
        .special-button a ,
        .doc-search-section .doc-search-button button,
        .faq-header button.faq-button.collapsed:before,
        .faq-header button.faq-button,
        .subscribe-form .btn-sub,
        .scroll-top,
        .video-section-home .video-button:after,
        .footer-item h3:after,
        .doctor-search,
        .team-social li a:hover,
        .event-detail-tab ul li a.active:before,
        .wh-table .sch,
        .event-form .btn:hover,
        .comment-form .btn:hover,
        .contact-info-item.bg1,
        .contact-info-item.bg3,
        .contact-form .btn:hover,
        .payment-order-button button,
        .payment-order-button a,
        .dash-item.db-red,
        .dashboard-widget li a:hover,
        .dashboard-widget li.active a,
        ul.page-numbers li span,
        .razorpay-payment-button {
            background: {{ $logo->theme_two }} !important;
        }

        .comment-form .btn:hover,
        .event-form .btn:hover,
        .contact-form .btn:hover{
            border: 1px solid {{ $logo->theme_two }} !important;
        }

        .testimonial-page .testi-link{
            border-color:{{ $logo->theme_two }} transparent !important;
        }


        .blog-page .blog-author,
        .dashboard-widget li a{
            border-left: 5px solid {{ $logo->theme_two }} !important;
            border-right: 5px solid {{ $logo->theme_two }} !important;
        }

        .case-item .case-content h4:after,
        .catagory-hover li a{
            background-color: {{ $logo->theme_two }} !important;
        }

        .owl-testimonial .owl-dots .owl-dot.active,
        .owl-carousel.team-carousel .owl-dots .owl-dot.active,
        .owl-carousel.blog-carousel .owl-dots .owl-dot.active{
            border: 5px solid {{ $logo->theme_two }} !important
        }
        .choose-col:nth-of-type(2n) .choose-item:before {
            background: {{ $logo->theme_two }} !important;
        }

        .service-item i, .service-item2 i,
        .service-item a,
        .testimonial-item:before,
        .team-text span,
        .team-text a:hover,
        .footer-address ul li i,
        .counter-item .counter-icon,
        .banner-text ul li span,
        h5.appointment-cost,
        .event-detail-tab ul li a.active,
        .comment-list .c-number,
        .comment-list .com-text span.date i,

        .footer-item a:hover, .footer-item li a:hover,
        .footer-social a:hover{
            color: {{ $logo->theme_two }} !important
        }
        /* end red color  */



        @if ($logo->live_chat==0)
            .scroll-top {
                bottom: 20px;
                right: 20px
            }
        @endif
        
        .whats-app {
    position: fixed;
    width: 50px;
    height: 50px;
    bottom: 20px;
    background-color: #25d366;
    color: #FFF;
    border-radius: 5px;
    text-align: center;
    font-size: 30px;
    box-shadow: 3px 4px 3px #999;
    right: 25px;
    z-index: 100;
}

.my-float {
    margin-top: 10px;
}

.whats-app:hover{
    border-radius:50px;
    color:#28a745;
    background-color:#fff;
}


.main-nav-link:hover{
    border-radius:10px;
    color:#fff;
    background-color:#00528a;
}





    </style>

@if ($logo->google_analytic==1)
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $logo->google_analytic_code }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{ $logo->google_analytic_code }}');
</script>
@endif

</head>

<body>

    <!--Preloader Start-->
    @if ($logo->preloader==1)
    <div id="preloader" >
        <div id="status" style="background-image: url({{ url($logo->preloader_image) }})"></div>
     </div>
    @endif

    <!--Preloader End-->

    @php
        $contact=App\ContactUs::first();
    @endphp
    <!--Header-Area Start-->
    <div class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-12">
                    <div class="header-social">
                        <ul>
                            <li>
                                <div class="social-bar">
                                    <ul>
                                        @if ($contact->facebook)
                                        <li><a href="{{ $contact->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                        @endif
                                        @if ($contact->twitter)
                                        <li><a href="{{ $contact->twitter }}"><i class="fab fa-snapchat"></i></a></li>
                                        @endif
                                        @if ($contact->linkedin)
                                        <li><a href="{{ $contact->linkedin }}"><i class="fab fa-tiktok"></i></a></li>
                                        @endif
                                        @if ($contact->pinterest)
                                        <li><a href="{{ $contact->pinterest }}"><i class="fab fa-instagram"></i></a></li>
                                        @endif
                                        @if ($contact->youtube)
                                        <li><a href="{{ $contact->youtube }}"><i class="fab fa-youtube"></i></a></li>
                                        @endif




                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-12">
                    <div class="header-info">
                        <ul>
                            @if ($contact->email)
                                <li>
                                    <i class="far fa-envelope"></i>
                                    <span>{{ $contact->email }}</span>
                                </li>
                            @endif
                            @if ($contact->phone)
                            <li>
                                <i class="fas fa-phone"></i>
                                <span>+{{ $contact->phone }}</span>
                            </li>
                            @endif

                            @if ($logo->patient_can_register ==1)
                            @guest
                            <li>
                                <i class="fas fa-lock"></i>
                                <a href="{{ url('login') }}">{{ $navigation->login }}</a> / <a href="{{ url('register') }}">{{ $navigation->register }}</a>
                            </li>
                            @else
                                <li>
                                    <i class="fas fa-user"></i>
                                    <a href="{{ route('patient.dashboard') }}">{{ $navigation->dashboard }}</a>
                                </li>
                            @endguest
                            <li>
                                <a href="{{ route('patient.payment') }}">{{ $navigation->payment }} <span class="badge badge-danger">{{ Cart::count() >0 ? Cart::count():'' }}</span></a>
                            </li>
                            @endif



                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Header-Area End-->

    {{-- load custom page --}}
    @php
        $customPage=App\CustomePage::where('status',1)->get();
    @endphp
    <!--Menu Start-->
<div id="strickymenu" class="menu-area">
    <div class="container">
        <div class="row" style="display: flex;align-items: center;">
            <div class="col-md-2 col-6">
                <div class="logo flex">
                    <a href="{{ url('/') }}"><img src="{{ asset($logo->logo) }}" alt="Logo"></a>
                </div>
            </div>
            <div class="col-md-10 col-6">
                <div class="main-menu">
                    <ul class="nav-menu">
                        @if ($navbar->show_homepage)
                        <li class="main-nav-link"><a class="main-nav-a" href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else{{ $translator->setTarget('en')->translate($navigation->home) }}@endif</a></li>
                        @endif
                        @if ($navbar->show_aboutus)
                        <li class="main-nav-link"><a href="{{ url('about-us') }}">@if($setting->text_direction=='RTL'){{ $navigation->about_us}}@else{{ $translator->setTarget('en')->translate($navigation->about_us) }}@endif</a></li>
                        @endif
                        <li class="main-nav-link"><a href="{{ url('offers') }}">@if($setting->text_direction=='RTL'){{ $navigation->offers}}@else{{ $translator->setTarget('en')->translate($navigation->offers) }}@endif</a></li>
                        @if ($navbar->show_doctor)
                        <li class="main-nav-link"><a href="{{ url('doctor') }}">@if($setting->text_direction=='RTL'){{ $navigation->doctor}}@else{{ $translator->setTarget('en')->translate($navigation->doctor) }}@endif</a></li>
                        @endif
                        @if ($navbar->show_department)
                        <li class="main-nav-link"><a href="{{ url('department') }}">@if($setting->text_direction=='RTL'){{ $navigation->department}}@else{{ $translator->setTarget('en')->translate($navigation->department) }}@endif</a></li>
                        @endif
                        <li class="main-nav-link"><a href="" data-toggle="modal" data-target="#employment_application_modal">@if($setting->text_direction=='RTL'){{$navigation->employment_application}}@else{{ $translator->setTarget('en')->translate($navigation->employment_application) }}@endif</a></li>
                        @if ($navbar->show_contactus)
                        <li class="main-nav-link"><a href="{{ url('contact-us') }}">@if($setting->text_direction=='RTL'){{ $navigation->contact_us}}@else{{ $translator->setTarget('en')->translate($navigation->contact_us) }}@endif</a></li>
                        @endif
                        <li class="special-button pulsate">
                            <a href="" data-toggle="modal" data-target="#appointment_modal">
                                @if($setting->text_direction=='RTL')
                                    {{ $navigation->appointment }}
                                @else
                                    {{ $translator->setTarget('en')->translate($navigation->appointment) }}
                                @endif
                            </a>
                        </li>
                        <li class="language-switcher">
                            <a href="#" onclick="toggleLanguage()">
                                @if($setting->text_direction == 'RTL')
                                    En
                                @else
                                    العربيه
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>

                <!--Mobile Menu Icon Start-->
                <div class="mobile-menuicon">
                    <span class="menu-bar" onclick="openNav()"><i class="fas fa-bars" aria-hidden="true"></i></span>
                </div>
                <!--Mobile Menu Icon End-->
            </div>
        </div>
    </div>
</div>
<!--Menu End-->
    @php
    $modalDepartments=App\Department::where('status',1)->get();
@endphp
    <!--Mobile Menu Start-->
    <div class="mobile-menu">
        <div id="mySidenav" class="sidenav">
            <a href="{{ url('/') }}"><img src="{{ url($logo->logo) }}" alt=""></a>
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

            <ul>
                @if ($navbar->show_homepage)
                <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                @endif
                @if ($navbar->show_aboutus)
                <li><a href="{{ url('about-us') }}">@if($setting->text_direction=='RTL'){{$navigation->about_us}}@else
                            {{ $translator->setTarget('en')->translate($navigation->about_us) }}
                            @endif</a></li>
                @endif
                <li><a href="{{ url('offers') }}">@if($setting->text_direction=='RTL'){{ $navigation->offers}}@else
                            {{ $translator->setTarget('en')->translate($navigation->offers) }}
                            @endif</a></li>
                @if ($navbar->show_doctor)
                    <li><a href="{{ url('doctor') }}">@if($setting->text_direction=='RTL'){{ $navigation->doctor}}@else
                {{ $translator->setTarget('en')->translate($navigation->doctor) }}
                @endif</a></li>
                @endif
                @if ($navbar->show_department)
                <li><a href="{{ url('department') }}">@if($setting->text_direction=='RTL'){{ $navigation->department}}@else
                {{ $translator->setTarget('en')->translate($navigation->department) }}
                @endif</a></li>
                @endif
                <li><a href="" data-toggle="modal" data-target="#employment_application_modal1">@if($setting->text_direction=='RTL'){{$navigation->employment_application}}@else
                            {{ $translator->setTarget('en')->translate($navigation->employment_application) }}
                            @endif</a></li>
                
                        @if ($navbar->show_contactus)
                        <li><a href="{{ url('contact-us') }}">@if($setting->text_direction=='RTL'){{ $navigation->contact_us}}@else
                            {{ $translator->setTarget('en')->translate($navigation->contact_us) }}
                            @endif</a></li>
                        @endif
                <li class="special-button"><a href="" data-toggle="modal" data-target="#appointment_modal1">@if($setting->text_direction=='RTL'){{ $navigation->appointment}}@else
                            {{ $translator->setTarget('en')->translate($navigation->appointment) }}
                            @endif</a></li>
                            <li class="language-switcher">
                                <a href="#" onclick="toggleLanguage()">
                                    @if($setting->text_direction == 'RTL')
                                        En
                                    @else
                                        العربيه
                                    @endif
                                </a>
                            </li>
                 <!-- Modal -->
                 <div class="modal fade" id="appointment_modal1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','create_app')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','create_app')->first()->custom_lang) }}
                            @endif</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body book-appointment">

                                <form action="{{ url('create-appointment') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_dep')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_dep')->first()->custom_lang) }}
                            @endif</label>
                                        <select name="department_id" onchange="loadMobileModalDoctor()" class="form-control modal-department-id mySelect2Item">
                                            <option value="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_dep')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_dep')->first()->custom_lang) }}
                            @endif</option>
                                            @foreach ($modalDepartments as $item)
                                            <option value="{{ $item->id }}">@if($setting->text_direction=='RTL'){{ $item->name}}@else
                            {{ $translator->setTarget('en')->translate($item->name) }}
                            @endif</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group d-none" id="mobile-modal-doctor-box">
                                        <label for="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_doc')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_doc')->first()->custom_lang) }}
                            @endif</label>
                                        <select name="" class="form-control modal-doctor-id mySelect2Item" onchange="loadModalDate()" >
                                            <option value="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_doc')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_doc')->first()->custom_lang) }}
                            @endif</option>
                                        </select>
                                    </div>
                                    <div class="form-group d-none" id="mobile-modal-date-box">
                                        <label for="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_date')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_date')->first()->custom_lang) }}
                            @endif</label>
                                        <input type="text" name="date" class="form-control datepicker" id="mobile-modal-datepicker-value">
                                        <input type="hidden" name="doctor_id" value="" id="mobile_modal_doctor_id">
                                    </div>

                                    <div class="form-group d-none" id="mobile-modal-schedule-box">
                                        <label for="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_schedule')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_schedule')->first()->custom_lang) }}
                            @endif</label>
                                        <select name="schedule_id" class="form-control" id="available-mobile-modal-schedule">

                                        </select>
                                    </div>
                                    <div id="mobile-modal-schedule-error" class="d-none"></div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','close')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','close')->first()->custom_lang) }}
                            @endif</button>
                                        <input type="submit" value="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','submit')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','submit')->first()->custom_lang) }}
                            @endif" class="btn btn-primary" id="mobile-modal-sub" disabled>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- // Modal -->
                



            </ul>

        </div>
    </div>
    <!--Mobile Menu End-->

    <!--Menu End-->

<!-- Modal -->
<div class="modal fade" id="appointment_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','create_app')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','create_app')->first()->custom_lang) }}
                            @endif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @php
                $modalDepartments=App\Department::where('status',1)->get();
            @endphp
            <div class="modal-body book-appointment">
                <form action="{{ url('create-appointment') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_doc')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_doc')->first()->custom_lang) }}
                            @endif</label>
                        <select name="department_id" onchange="loadDoctor()" class="form-control department-id select2">
                            <option value="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_dep')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_dep')->first()->custom_lang) }}
                            @endif</option>
                            @foreach ($modalDepartments as $item)
                            <option value="{{ $item->id }}">@if($setting->text_direction=='RTL'){{ $item->name}}@else
                            {{ $translator->setTarget('en')->translate($item->name) }}
                            @endif</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group d-none" id="modal-doctor-box">
                        <label for="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_doc')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_doc')->first()->custom_lang) }}
                            @endif</label>
                        <select name="" class="form-control doctor-id select2" onchange="loadDate()" >
                            <option value="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_doc')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_doc')->first()->custom_lang) }}
                            @endif</option>
                        </select>
                    </div>
                    <div class="form-group d-none" id="modal-date-box">
                        <label for="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_date')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_date')->first()->custom_lang) }}
                            @endif</label>
                        <input type="text" name="date" class="form-control datepicker" id="modal-datepicker-value">
                        <input type="hidden" name="doctor_id" value="" id="modal_doctor_id">
                    </div>
                    <div class="form-group d-none" id="modal-schedule-box">
                        <label for="">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','select_schedule')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','select_schedule')->first()->custom_lang) }}
                            @endif</label>
                        <select name="schedule_id" class="form-control" id="available-modal-schedule">

                        </select>
                    </div>
                    <div id="modal-schedule-error" class="d-none"></div>
                    <div class="form-group">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','close')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','close')->first()->custom_lang) }}
                            @endif</button>
                        <input type="submit" value="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','submit')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','submit')->first()->custom_lang) }}
                            @endif" class="btn btn-primary" id="modal-sub" disabled>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- // Modal -->
<!-- Modal -->
<div class="modal fade" id="employment_application_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','fill_form')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','fill_form')->first()->custom_lang) }}
                            @endif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @php
                $modalDepartments=App\Department::where('status',1)->get();
            @endphp
            <div class="modal-body book-appointment">
                <form action="{{ url('create-employment-application') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','name')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','name')->first()->custom_lang) }}
                            @endif</label>
                        <input type="text" id="name" name="name"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','phone')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','phone')->first()->custom_lang) }}
                            @endif</label>
                        <input type="number" id="phone" name="phone"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="job_title">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','job_title')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','job_title')->first()->custom_lang) }}
                            @endif</label>
                        <input type="text" id="job_title" name="job_title"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="certificate_file">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','certificate_file')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','certificate_file')->first()->custom_lang) }}
                            @endif</label>
                        <input type="file" id="certificate_file" name="certificate_file"  class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','close')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','close')->first()->custom_lang) }}
                            @endif</button>
                        <input type="submit" value="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','submit')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','submit')->first()->custom_lang) }}
                            @endif" class="btn btn-primary" id="modal-sub">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- // Modal -->
<!-- Modal -->
<div class="modal fade" id="employment_application_modal1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $websiteLang->where('lang_key','fill_form')->first()->custom_lang }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @php
                $modalDepartments=App\Department::where('status',1)->get();
            @endphp
            <div class="modal-body book-appointment">
                <form action="{{ url('create-employment-application') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','name')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','name')->first()->custom_lang) }}
                            @endif</label>
                        <input type="text" id="name" name="name"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','phone')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','phone')->first()->custom_lang) }}
                            @endif</label>
                        <input type="number" id="phone" name="phone"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="job_title">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','job_title')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','job_title')->first()->custom_lang) }}
                            @endif</label>
                        <input type="text" id="job_title" name="job_title"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="certificate_file">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','certificate_file')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','certificate_file')->first()->custom_lang) }}
                            @endif</label>
                        <input type="file" id="certificate_file" name="certificate_file"  class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','close')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','close')->first()->custom_lang) }}
                            @endif</button>
                        <input type="submit" value="@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','submit')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','submit')->first()->custom_lang) }}
                            @endif" class="btn btn-primary" id="modal-sub">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- // Modal -->

<a  class="whats-app" href="https://api.whatsapp.com/send?phone=+96653 911 1336" target="_blank">
    <i class="fa fa-whatsapp my-float"></i>
</a>
