@extends('layouts.patient.layout')
@section('title')
<title>{{ $navigation->register }}</title>
@endsection
@section('patient-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->login ? url($banner->login) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $navigation->register }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span>{{ $navigation->register }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Register Start-->
<div class="register-area pt_70 pb_70">
	<div class="container wow fadeIn">
		<div class="row">
            @if ($setting->text_direction=='RTL')
            <div class="col-lg-3"></div>
            @endif
			<div class="offset-lg-3 col-lg-6 offset-lg-3">
				<div class="regiser-form login-form">
					<form action="{{ route('register') }}" method="POST">
                        @csrf
						<div class="form-row row">
							<div class="form-group col-12">
								<label for="name">{{ $websiteLang->where('lang_key','name')->first()->custom_lang }}</label>
								<input name="name" type="text" id="name" class="form-control" value="{{ old('name') }}">
							</div>
							
							<div class="form-group col-12">
                              <label for="phone">{{ $websiteLang->where('lang_key','phone')->first()->custom_lang }}</label>
                              <div class="phone-input-container">
                                
                                <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                                <span class="country-code">+966</span>
                              </div>
                            </div>
							
							

							<div class="form-group col-12">
								<label for="email">{{ $websiteLang->where('lang_key','email')->first()->custom_lang }}</label>
								<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
							</div>
							<div class="form-group col-12">
								<label for="password">{{ $websiteLang->where('lang_key','pass')->first()->custom_lang }}</label>
								<input type="password" name="password" class="form-control" id="password">
							</div>
                            @if ($setting->allow_captcha==1)
                            <div class="form-group col-12">
                                <div class="g-recaptcha" data-sitekey="{{ $setting->captcha_key }}"></div>
                            </div>
                            @endif
							<div class="form-group col-12">
								<button type="submit" class="btn btn-primary">{{ $websiteLang->where('lang_key','register')->first()->custom_lang }}</button>
							</div>
						</div>
					</form>

					<a href="{{ url('login') }}" class="link">{{ $websiteLang->where('lang_key','exist_login')->first()->custom_lang }}</a>

				</div>
			</div>
		</div>
	</div>
</div>
<!--Register End-->

@endsection
