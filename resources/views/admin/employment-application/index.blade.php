@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','app')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','all_employment_applications')->first()->custom_lang }}</h6>
        </div>
        <div class="card-body" id="search-appointment">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">{{ $websiteLang->where('lang_key','name')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','phone')->first()->custom_lang }}</th>
                            
                            <th width="15%">{{ $websiteLang->where('lang_key','job_title')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','certificate_file')->first()->custom_lang }}</th>
                            
                            <th width="10%">{{ $websiteLang->where('lang_key','date')->first()->custom_lang }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employmentApplications as $index => $item)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ ucfirst($item->name) }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>
                                @if(pathinfo($item->certificate_file, PATHINFO_EXTENSION) == 'pdf')
                                    <a href="{{ asset($item->certificate_file) }}" target="_blank">
                                        <i class="fas fa-file-pdf"></i> {{ basename($item->certificate_file) }}
                                    </a>
                                @else
                                    <a href="{{ asset($item->certificate_file) }}" target="_blank">
                                        {{ basename($item->certificate_file) }}
                                    </a>
                                @endif
                            </td>
                            <td>{{ date('m-d-Y',strtotime($item->created_at)) }}</td>
                            
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

