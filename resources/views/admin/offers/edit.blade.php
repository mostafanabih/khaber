@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','offers')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('admin.offers.index') }}" class="btn btn-primary"><i class="fas fa-list" aria-hidden="true"></i> {{ $websiteLang->where('lang_key','all_offers')->first()->custom_lang }} </a></h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <!-- <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','doc_form')->first()->custom_lang }}</h6>
                </div> -->
                <div class="card-body">

                    <form action="{{ route('admin.offers.update',$offer->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ $websiteLang->where('lang_key','name')->first()->custom_lang }}</label>
                                    <input type="text" name="name" class="form-control" id="name" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">{{ $websiteLang->where('lang_key','img')->first()->custom_lang }}</label>
                                    <input type="file" name="image" class="form-control" id="image" >
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">{{ $websiteLang->where('lang_key','exist_img')->first()->custom_lang }}</label>
                                    <img src="{{ url($offer->image) }}" alt="doctor image" width="120px">
                                </div>
                            </div>


                            


                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ $websiteLang->where('lang_key','status')->first()->custom_lang }} *</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ $offer->status==1 ? 'selected':'' }} value="1">{{ $websiteLang->where('lang_key','active')->first()->custom_lang }}</option>
                                        <option {{ $offer->status==0 ? 'selected':'' }} value="0">{{ $websiteLang->where('lang_key','inactive')->first()->custom_lang }}</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>

                        

                        <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','update')->first()->custom_lang }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
