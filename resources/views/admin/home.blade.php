@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('crumb')
    <div class="app-title">
        <div>
            <h2><i class="fa fa-dashboard"></i> @lang('site.home')</h2>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">Create a beautiful dashboard</div>
            </div>
        </div>
    </div>
@endsection
