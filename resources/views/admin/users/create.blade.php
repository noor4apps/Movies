@extends('layouts.admin.app')

@section('title', 'Users')

@section('crumb')
    <div class="app-title">
        <div>
            <h2><i class="fa fa-user"></i> @lang('users.users')</h2>
        </div>

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">@lang('users.users')</a></li>
            <li class="breadcrumb-item">@lang('site.create')</li>
        </ul>
    </div>
@endsection

@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <form method="post" action="{{ route('admin.users.store') }}">
                    @csrf
                    @method('post')

                    @include('admin.partials._errors')

                    <!-- name -->
                    <div class="form-group">
                        <label>@lang('users.name')<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                    </div>

                    <!-- email -->
                    <div class="form-group">
                        <label>@lang('users.email')<span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <!-- password -->
                    <div class="form-group">
                        <label>@lang('users.password')<span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" value="{{ old('password') }}" required>
                    </div>

                    <!-- password_confirmation -->
                    <div class="form-group">
                        <label>@lang('users.password_confirmation')<span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.create')</button>
                    </div>

                </form><!-- end of form -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->

@endsection


