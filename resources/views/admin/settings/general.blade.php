@extends('layouts.admin.app')

@section('title', __('settings.settings'))

@section('crumb')
    <div class="app-title">
        <div>
            <h2><i class="fa fa-cogs"></i> @lang('settings.settings')</h2>
        </div>

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
            <li class="breadcrumb-item">@lang('settings.general_settings')</li>
        </ul>
    </div>
@endsection

@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <form method="post" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('post')

                    {{--logo--}}
                    <div class="form-group">
                        <label>@lang('settings.logo')</label>
                        <input type="file" name="logo" class="form-control load-image">
                        <img src="{{ Storage::url('uploads/' . setting('logo')) }}" class="loaded-image" alt="" style="display: {{ setting('logo') ? 'block' : 'none' }}; width: 100px; margin: 10px 0;">
                    </div>

                    {{--fav_icon--}}
                    <div class="form-group">
                        <label>@lang('settings.fav_icon')</label>
                        <input type="file" name="fav_icon" class="form-control load-image">
                        <img src="{{ Storage::url('uploads/' . setting('fav_icon')) }}" class="loaded-image" alt="" style="display: {{ setting('fav_icon') ? 'block' : 'none' }}; width: 50px; margin: 10px 0;">
                    </div>

                    {{--title--}}
                    <div class="form-group">
                        <label>@lang('settings.title')</label>
                        <input type="text" name="title" class="form-control" value="{{ setting('title') }}">
                    </div>

                    {{--description--}}
                    <div class="form-group">
                        <label>@lang('settings.description')</label>
                        <textarea name="description" class="form-control">{{ setting('description') }}</textarea>
                    </div>

                    {{--keywords--}}
                    <div class="form-group">
                        <label>@lang('settings.keywords')</label>
                        <input type="text" name="keywords" class="form-control" value="{{ setting('keywords') }}">
                    </div>

                    {{--email--}}
                    <div class="form-group">
                        <label>@lang('users.email')</label>
                        <input type="text" name="email" class="form-control" value="{{ setting('email') }}">
                    </div>

                    {{--submit--}}
                    @if (auth()->user()->hasPermission('create_settings') or auth()->user()->hasPermission('update_settings'))
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.update')</button>
                        </div>
                    @endif

                </form><!-- end of form -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->
@endsection
