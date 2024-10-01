@php
    $subscriberContent=App\Setting::first();
    $subscribeImage=App\BannerImage::first();
    $websiteLang=App\ManageText::all();
    $setting=App\Setting::first();
    $isRtl=$setting->text_direction;
@endphp
@php
$translator = new Stichoza\GoogleTranslate\GoogleTranslate('ar');
@endphp

<!--Start of Tawk.to Script-->
<!-- @if ($subscriberContent->live_chat==1)
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='{{ $subscriberContent->livechat_script }}';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
@endif -->
<!--End of Tawk.to Script-->

<!--Subscribe Start-->
<div class="subscribe-area" style="background-image: url({{ $subscribeImage->subscribe_us ?  url($subscribeImage->subscribe_us) : '' }})">
    <div class="container">
        <div class="row ov_hd">
            <div class="col-md-12 wow fadeInDown" data-wow-delay="0.1s">
                <div class="main-headline white">
                    <h1>@if($setting->text_direction=='RTL'){{ ucwords($subscriberContent->subscribe_heading)}}@else
                            {{ $translator->setTarget('en')->translate(ucwords($subscriberContent->subscribe_heading)) }}
                            @endif</h1>
                    <p>@if($setting->text_direction=='RTL'){{ $subscriberContent->subscribe_description}}@else
                            {{ $translator->setTarget('en')->translate($subscriberContent->subscribe_description) }}
                            @endif</p>
                </div>
            </div>
        </div>
        <div class="row ov_hd">
            <div class="col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="subscribe-form">
                    <form method="POST" action="{{ url('subscribe-us') }}">
                        @csrf
                        <input type="email" required name="email" placeholder="{{ $websiteLang->where('lang_key','email')->first()->custom_lang }}">
                        <button type="submit" class="btn-sub">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','subscribe')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','subscribe')->first()->custom_lang) }}
                            @endif</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Subscribe Start-->

<!--Brand-Area Start-->
<div class="brand-area bg-area">
    <div class="container">
        @php
            $partners=App\Partner::where('status',1)->get();
        @endphp
        <div class="row">
            <div class="col-12">
                <div class="brand-carousel owl-carousel">
                    @foreach ($partners as $item)
                    <a href="{{ $item->link }}">
                        <div class="brand-item">
                            <div class="brand-colume">
                                <div class="brand-bg"></div>
                                <img src="{{ url($item->image) }}" alt="Partner">
                            </div>
                        </div>
                    </a>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
<!--Brand-Area End-->
@php
        $contact=App\ContactUs::first();
        $contactInformation=App\ContactInformation::first();
        $logo=App\Setting::first();
        $navbar=App\ManageNavigation::first();
        $navigation=App\Navigation::first();
@endphp
<!--Footer Start-->
<div class="main-footer">
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="footer-address">
                        <ul>
                            <li>
                                <i class="far fa-envelope"></i>
                                <h5>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','email_address')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','email_address')->first()->custom_lang) }}
                            @endif </h5>
                                <p>@if($setting->text_direction=='RTL'){!! nl2br(e($contactInformation->emails))!!}@else
                            {!! $translator->setTarget('en')->translate(nl2br(e($contactInformation->emails))) !!}
                            @endif</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="footer-address">
                        <ul>
                            <li>
                                <i class="fas fa-phone"></i>
                                <h5>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','phone')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','phone')->first()->custom_lang) }}
                            @endif</h5>
                                <p>@if($setting->text_direction=='RTL'){!! nl2br(e($contactInformation->phones))!!}@else
                            {!! $translator->setTarget('en')->translate(nl2br(e($contactInformation->phones))) !!}
                            @endif</p>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="footer-address">
                        <ul>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <h5>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','address')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','address')->first()->custom_lang) }}
                            @endif</h5>
                                <p>@if($setting->text_direction=='RTL'){!! nl2br(e($contactInformation->address))!!}@else
                            {!! $translator->setTarget('en')->translate(nl2br(e($contactInformation->address))) !!}
                            @endif</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-area" style="background-image: url({{ url('patient/img/shape-2.png') }})">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="footer-item">
                        <h3>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','about_us')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','about_us')->first()->custom_lang) }}
                            @endif</h3>
                        <div class="textwidget">
                            <p>
                            @if($setting->text_direction=='RTL'){{ $contactInformation->about}}@else
                            {{ $translator->setTarget('en')->translate($contactInformation->about) }}
                            @endif
                            </p>
                            <a class="sm_fbtn" href="{{ url('about-us') }}">@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','details')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','details')->first()->custom_lang) }}
                            @endif →</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="footer-item">
                        <h3>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','important_link')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','important_link')->first()->custom_lang) }}
                            @endif</h3>
                        <ul>
                            @if ($navbar->show_homepage==1)
                                <li><a href="{{ url('/') }}">@if($setting->text_direction=='RTL'){{ $navigation->home}}@else
                            {{ $translator->setTarget('en')->translate($navigation->home) }}
                            @endif</a></li>
                            @endif
                            @if ($navbar->show_aboutus==1)
                                <li><a href="{{ url('about-us') }}">@if($setting->text_direction=='RTL'){{ $navigation->about_us}}@else
                            {{ $translator->setTarget('en')->translate($navigation->about_us) }}
                            @endif</a></li>
                            @endif
                            @if ($navbar->show_department)
                                <li><a href="{{ url('department') }}">@if($setting->text_direction=='RTL'){{ $navigation->department}}@else
                            {{ $translator->setTarget('en')->translate($navigation->department) }}
                            @endif</a></li>
                            @endif
                            @if ($navbar->show_doctor)
                                <li><a href="{{ url('doctor') }}">@if($setting->text_direction=='RTL'){{ $navigation->doctor}}@else
                            {{ $translator->setTarget('en')->translate($navigation->doctor) }}
                            @endif</a></li>
                            @endif


                        </ul>
                        <ul>
                            <li><a href="{{ url('terms-condition') }}">@if($setting->text_direction=='RTL'){{ $navigation->terms_and_condition}}@else
                            {{ $translator->setTarget('en')->translate($navigation->terms_and_condition) }}
                            @endif</a></li>
                            <li><a href="{{ url('privacy-policy') }}">@if($setting->text_direction=='RTL'){{ $navigation->privacy_policy }}@else
                            {{ $translator->setTarget('en')->translate($navigation->privacy_policy ) }}
                            @endif</a></li>
                            @if ($navbar->show_blog==1)
                            <li><a href="{{ url('blog') }}">@if($setting->text_direction=='RTL'){{ $navigation->blog}}@else
                            {{ $translator->setTarget('en')->translate($navigation->blog) }}
                            @endif</a></li>
                            @endif
                            @if ($navbar->show_faq==1)
                            <li><a href="{{ url('faq') }}">@if($setting->text_direction=='RTL'){{ $navigation->faq }}@else
                            {{ $translator->setTarget('en')->translate($navigation->faq ) }}
                            @endif</a></li>
                            @endif
                            @if ($navbar->show_contactus==1)
                            <li><a href="{{ url('contact-us') }}">@if($setting->text_direction=='RTL'){{ $navigation->contact_us}}@else
                            {{ $translator->setTarget('en')->translate($navigation->contact_us) }}
                            @endif</a></li>
                            @endif


                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    @php
                        $latestBlogs=App\Blog::orderBy('id','desc')->take(3)->get();
                    @endphp
                    <div class="footer-item">
                        <h3>@if($setting->text_direction=='RTL'){{ $websiteLang->where('lang_key','location')->first()->custom_lang}}@else
                            {{ $translator->setTarget('en')->translate($websiteLang->where('lang_key','location')->first()->custom_lang) }}
                            @endif</h3>
                        <div class="map-box  wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
            <div class="mapouter" style="
    position: relative;
    text-align: left;
    width: 100%;
">
              <div class="gmap_canvas" style="
    overflow: hidden;
    background: none;
">
                <iframe class="map-iframe" id="gmap_canvas" 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3618.645907837392!2d49.5714304!3d25.4377984!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49d74b98d3c04b%3A0xdd2d0f832f362a90!2sAlehsaa%2C%20Saudi%20Arabia!5e0!3m2!1sen!2seg!4v1624568400000!5m2!1sen!2seg" 
    width="400" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
              </div>
            </div>
          </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyrignt">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="copyright-text">
                        <p>@if($setting->text_direction=='RTL'){{ $contactInformation->copyright}}@else
                            {{ $translator->setTarget('en')->translate($contactInformation->copyright) }}
                            @endif</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer-social">
                        @if ($contact->facebook)
                        <a href="{{ $contact->facebook }}"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if ($contact->twitter)
                        <a href="{{ $contact->twitter }}"><i class="fab fa-snapchat"></i></a>
                        @endif
                        @if ($contact->pinterest)
                        <a href="{{ $contact->pinterest }}"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if ($contact->linkedin)
                        <a href="{{ $contact->linkedin }}"><i class="fab fa-tiktok"></i></a>
                        @endif
                        @if ($contact->youtube)
                        <a href="{{ $contact->youtube }}"><i class="fab fa-youtube"></i></a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Footer End-->

@php
    $cookie=App\Setting::first();
@endphp
@if ($cookie->allow_cookie_consent==1)
<div class="cookie-container">
    <p>
    @if($setting->text_direction=='RTL'){!! clean($cookie->cookie_text)!!}@else
                            {!! $translator->setTarget('en')->translate(clean($cookie->cookie_text)) !!}
                            @endif
    </p>

    <button class="cookie-btn">
    @if($setting->text_direction=='RTL'){{ ucwords($cookie->cookie_button_text)}}@else
                            {{ $translator->setTarget('en')->translate(ucwords($cookie->cookie_button_text)) }}
                            @endif
    </button>
  </div>

@endif


<!--Scroll-Top-->
<div class="scroll-top">
    <i class="fas fa-angle-double-up"></i>
</div>
<!--Scroll-Top-->


<script>
    var isRtl="{{ $isRtl }}"
    var rtlTrue=false;
    if(isRtl=='RTL'){
        rtlTrue=true;
    }
</script>


<!--Js-->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="{{ url('patient/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ url('patient/js/bootstrap.min.js') }}"></script>
<script src="{{ url('patient/js/popper.min.js') }}"></script>
<script src="{{ url('patient/js/jquery-ui.min.js') }}"></script>
<script src="{{ url('patient/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ url('patient/js/jquery.collapse.js') }}"></script>
<script src="{{ url('patient/js/owl.carousel.min.js') }}"></script>
<script src="{{ url('patient/js/swiper-bundle.js') }}"></script>
<script src="{{ url('patient/js/jquery.filterizr.min.js') }}"></script>
<script src="{{ url('patient/js/select2.min.js') }}"></script>
<script src="{{ url('patient/js/wow.min.js') }}"></script>
<script src="{{ url('patient/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('patient/js/viewportchecker.js') }}"></script>
<script src="{{ url('patient/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('patient/js/custom.js') }}"></script>
<script src="{{ url('patient/js/cookie-consent.js') }}"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<script src="{{ asset('patient/js/jquery-ui.js') }}"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>



<!-- Initialize the Swiper in JavaScript -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.reviewsSlider', {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 30,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const swiperOptions = {
        spaceBetween: 30,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".client-button-next",
            prevEl: ".client-button-prev",
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        loop: true,
        breakpoints: {
            640: {
                slidesPerView: 1,
            },
            1024: {
                slidesPerView: 2,
            },
            1280: {
                slidesPerView: 3,
            }
        }
    };

    const swipers = {};

    function initSwiper(departmentId) {
        if (!swipers[departmentId]) {
            swipers[departmentId] = new Swiper(`.offers-${departmentId}`, swiperOptions);
        }
    }

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        const departmentId = $(e.target).attr('href').replace('#department-', '');
        initSwiper(departmentId);
    });

    
});
</script>


<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    @if(Session::has('messege'))
      var type="{{Session::get('alert-type','info')}}"
      switch(type){
          case 'info':
               toastr.info("{{ Session::get('messege') }}");
               break;
          case 'success':
              toastr.success("{{ Session::get('messege') }}");
              break;
          case 'warning':
             toastr.warning("{{ Session::get('messege') }}");
              break;
          case 'error':
              toastr.error("{{ Session::get('messege') }}");
              break;
      }
    @endif
</script>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{ $error }}');
        </script>
    @endforeach
@endif


<script>
    //Search
    function openSearch() {
        document.getElementById("myOverlay").style.display = "block";
    }

    function closeSearch() {
        document.getElementById("myOverlay").style.display = "none";
    }

    //Mobile Menu
    function openNav() {
        document.getElementById("mySidenav").style.width = "100%";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

	(function($) {

    "use strict";
    // load available appointment in doctor details
    $(document).on('change', '#datepicker-value', function() {
            var value=$(this).val();
            var doctor_id=$("#doctor_id").val();
            var url="{{ url('/get-appointment/') }}";
            $.ajax({
            type: 'GET',
            url: url,
            data:{'doctor_id':doctor_id,'date':value},
            success: function (response) {
                if(response.success){
                    $("#doctor-available-schedule").html(response.success)
                    $("#schedule-box-outer").removeClass('d-none')
                    $("#doctor-schedule-error").addClass('d-none')
                    $("#sub").prop("disabled", false);
                }
                if(response.error){
                    $("#schedule-box-outer").addClass('d-none')
                    $("#doctor-schedule-error").removeClass('d-none')
                    $("#doctor-schedule-error").html(response.error)
                    $("#sub").prop("disabled", true);
                }

            },
            error: function(err) {
                console.log(err);
            }
        });
    });
	})(jQuery);


    // load doctor in modal
    function loadDoctor(){
        var id=$(".department-id").val();
        if(id){
            var url="{{ url('get-department-doctor/') }}"+"/"+id;
            $.ajax({
                type: 'GET',
                url: url,
                success: function (response) {
                    $(".doctor-id").html(response)
                    $("#modal-doctor-box").removeClass('d-none')
                },
                error: function(err) {
                    console.log(err);
                }
            });

        }
    }
    // load doctor in mobile menu modal
    function loadMobileModalDoctor(){
        var id=$(".modal-department-id").val();
        if(id){
            var url="{{ url('get-department-doctor/') }}"+"/"+id;
            $.ajax({
                type: 'GET',
                url: url,
                success: function (response) {
                    $(".modal-doctor-id").html(response)
                    $("#mobile-modal-doctor-box").removeClass('d-none')
                },
                error: function(err) {
                    console.log(err);
                }
            });

        }
    }

    // load date in modal
    function loadDate(){
        var doctorId=$('.doctor-id').val()
        $('#modal_doctor_id').val(doctorId)
        $("#modal-date-box").removeClass('d-none')

    }

    // load date in mobile menu modal
    function loadModalDate(){
        var doctorId=$('.modal-doctor-id').val()
        $('#mobile_modal_doctor_id').val(doctorId)
        $("#mobile-modal-date-box").removeClass('d-none')

    }




	(function($) {

    "use strict";
    // load available appointment in appoinment model
    $(document).on('change', '#modal-datepicker-value', function() {
            var value=$(this).val();
            var doctorId=$("#modal_doctor_id").val();
            var url="{{ url('/get-appointment/') }}";
            $.ajax({
            type: 'GET',
            url: url,
            data:{'doctor_id':doctorId,'date':value},
            success: function (response) {
                if(response.success){
                    $("#available-modal-schedule").html(response.success)
                    $("#modal-schedule-box").removeClass('d-none')
                    $("#modal-schedule-error").addClass('d-none')
                    $("#modal-sub").prop("disabled", false);
                }
                if(response.error){
                    $("#modal-schedule-box").addClass('d-none')
                    $("#modal-schedule-error").removeClass('d-none')
                    $("#modal-schedule-error").html(response.error)
                    $("#modal-sub").prop("disabled", true);


                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    // load available appointment in appoinment model
    $(document).on('change', '#mobile-modal-datepicker-value', function() {
            var value=$(this).val();
            var doctorId=$("#mobile_modal_doctor_id").val();
            var url="{{ url('/get-appointment/') }}";
            $.ajax({
            type: 'GET',
            url: url,
            data:{'doctor_id':doctorId,'date':value},
            success: function (response) {
                if(response.success){
                    $("#available-mobile-modal-schedule").html(response.success)
                    $("#mobile-modal-schedule-box").removeClass('d-none')
                    $("#mobile-modal-schedule-error").addClass('d-none')
                    $("#mobile-modal-sub").prop("disabled", false);
                }
                if(response.error){
                    $("#mobile-modal-schedule-box").addClass('d-none')
                    $("#mobile-modal-schedule-error").removeClass('d-none')
                    $("#mobile-modal-schedule-error").html(response.error)
                    $("#mobile-modal-sub").prop("disabled", true);
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    $(document).on('click', '#zoom_demo_mode', function () {
        var demoNotify="{{ env('NOTIFY_TEXT') }}"
        toastr.error(demoNotify);
    });

	})(jQuery);


// stripe

$(function() {
    var $form         = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('d-none');

        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('d-none');
        e.preventDefault();
      }
    });

    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }

  });

  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }

});




</script>

<script>

    var receiver_id = '';
    @auth
    var my_id = "{{ Auth::guard('web')->user()->id }}";
    @endauth


	(function($) {

    "use strict";

    $(document).ready(function () {
        $('.user').on('click',function () {
            $('.user').removeClass('active');
            $(this).addClass('active');
            $(this).find('.pending').remove();

            receiver_id = $(this).attr('id');
            $.ajax({
                type: "get",
                url: "{{ url('patient/get-message/') }}"+ "/" + receiver_id,
                data: "",
                cache: false,
                success: function (data) {
                    $('#messages').html(data);
                    scrollToBottomFunc();
                }
            });
        });

        $(document).on('keyup', '.input-text input', function (e) {
            var message = $(this).val();

            if(message != ''){
                $("#sentMessageBtn").prop("disabled", false);
            }else{
                $("#sentMessageBtn").prop("disabled", true);
            }

            if (e.keyCode == 13 && message != '' && receiver_id != '') {
                $(this).val('');

                var datastr = "receiver_id=" + receiver_id + "&message=" + message;

                // project demo mode check
                var isDemo="{{ env('PROJECT_MODE') }}"
                var demoNotify="{{ env('NOTIFY_TEXT') }}"
                if(isDemo==0){
                    toastr.error(demoNotify);
                    return;
                }
                // end

                $.ajax({
                    type: "get",
                    url: "{{ url('/patient/send-message') }}",
                    data: datastr,
                    cache: false,
                    success: function (data) {
                        scrollToBottomFunc();
                        $('#' + data.doctor_id).click();

                    },
                    error: function (jqXHR, status, err) {
                    }
                })
            }
        });

    });
	})(jQuery);


    // make a function to scroll down auto
    function scrollToBottomFunc() {
        $('.message-wrapper').animate({
            scrollTop: $('.message-wrapper').get(0).scrollHeight
        }, 50);
    }

    // send messag by click button
    function sendMessage(){
        var message=$(".submit").val();
        $(".submit").val('');
        var datastr = "receiver_id=" + receiver_id + "&message=" + message;

        // project demo mode check
        var isDemo="{{ env('PROJECT_MODE') }}"
        var demoNotify="{{ env('NOTIFY_TEXT') }}"
        if(isDemo==0){
            toastr.error(demoNotify);
            return;
        }
        // end

        $.ajax({
            type: "get",
            url: "{{ url('/patient/send-message') }}",
            data: datastr,
            cache: false,
            success: function (data) {
                scrollToBottomFunc();
                $('#' + data.doctor_id).click();
            },
            error: function (jqXHR, status, err) {
            }
        })


    }

</script>

<script>
    $(document).ready(function() {
    $('[data-toggle="modal"][data-target="#offer_modal"]').on('click', function() {
        var offerId = $(this).data('offer-id');
        var offerImage = $(this).data('offer-img');
        var offerName = $(this).data('offer-name');
        updateModalContent(offerName,offerId,offerImage);
    });
});

function updateModalContent(offerName,offerId,offerImage) {
    var modal = $('#offer_modal');
    modal.find('.modal-title').text(' بادر بالحجز الان مع عرض ' + offerName);
    $('#servicerb').val(offerId); // Set the value of the #servicerb input field
    $('#offer_modal img').attr('src', offerImage); // Set the image source in the modal
    // Update other modal content as needed
}
</script>

<script>

$(document).ready(function () {
 
	var currentdate = new Date(); 
var datetime = "" + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + "  "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();

                // alert(datetime);

      const scriptURL = "https://script.google.com/macros/s/AKfycbzuZxUr8-F8mHZPeFACyzgKDHvY-3gVry-pqSv2DZdZ2KVjb2qNJhOAOuySYEyMb7yhMA/exec";
      //alert(scriptURL);
  const form = document.forms['myform']
 
  form.addEventListener('submit', e => {


    
	$(':input[type=submit]').prop('disabled', true)
  $('#today').attr('value', datetime )
  $('#w_link_id').attr('value', 'wa.me/966'+$("#phn_id").val() )
//   element.style.display = "block"
  //alert("progress")
    e.preventDefault()
    fetch(scriptURL, { method: 'POST', body: new FormData(form)})
      .then(response => 

      google_response()
    
	  )
      .catch(error => console.error('Error!', error.message))
  })


    
  function google_response() {
  
    event_service=$("#servicerb").val();
   
    alert("تمت عملية التسجيل بخصوص خدمه " + event_service + "بنجاح وسيتم التواصل معك في اقرب وقت ")

}

$('#offer_modal').modal('hide');

	
});

    </script>

<script type="text/javascript">
    $(document).ready(function() {
    // Show the modal on page load
    $('#myModal2').modal('show');

    // Hide the modal after 5 seconds
    setTimeout(function() {
        $('#myModal2').modal('hide');
    }, 7000); // 5000 milliseconds = 5 seconds
});
</script>
<script>
    function toggleLanguage() {
    fetch('/update-language', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ text_direction: '{{ $setting->text_direction == "RTL" ? "LTR" : "RTL" }}' })
    })
    .then(response => response.json())
    .then(data => {
        // Refresh the page or update the UI as needed
        location.reload();
    })
    .catch(error => {
        console.error('Error updating language:', error);
    });
}
</script>



</body>

</html>
