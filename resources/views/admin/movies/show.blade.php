@extends('layouts.admin.app')

@section('title', __('movies.movies'))

@section('crumb')
    <div class="app-title">
        <div>
            <h2><i class="fa fa-film"></i> @lang('movies.movies')</h2>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.movies.index') }}">@lang('movies.movies')</a></li>
            <li class="breadcrumb-item">@lang('site.show')</li>
        </ul>
    </div>
@endsection

@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ $movie->poster_path }}" class="img-fluid" alt="">
                    </div>

                    <div class="col-md-9">
                        <h2>{{ $movie->title }}</h2>

                        @foreach ($movie->genres as $genre)
                            <h5 class="d-inline-block"><span class="badge badge-primary">{{ $genre->name }}</span></h5>
                        @endforeach

                        <p style="font-size: 16px;">{{ $movie->description }}</p>

                        <div class="d-flex mb-2">
                            <i class="fa fa-star text-warning" style="font-size: 35px;"></i>
                            <h3 class="m-0 mx-2">{{ $movie->vote }}</h3>
                            <p class="m-0 align-self-center">@lang('movies.by') {{ $movie->vote_count }}</p>
                        </div>

                        <p><span class="font-weight-bold">@lang('movies.language')</span>: en</p>
                        <p><span class="font-weight-bold">@lang('movies.release_date')</span>: {{ $movie->release_date }}</p>

                    </div><!-- end of col  -->

                </div><!-- end of row -->

                <hr>

                <div class="row" id="movie-images">

                    @foreach ($movie->images as $image)
                        <div class="col-md-3 my-2">
                            <a href="{{ $image->image_path }}"><img src="{{ $image->image_path }}" class="img-fluid" alt=""></a>
                        </div><!-- end of col -->
                    @endforeach

                </div><!-- end of row -->

                <hr>

                <div class="row">

                    @foreach ($movie->actors as $actor)

                        <div class="col-md-2 my-2">
                            <a href="{{ route('admin.movies.index', ['actor_id' => $actor->id]) }}">
                                <img src="{{ $actor->image_path }}" class="img-fluid" alt="">
                            </a>
                        </div><!-- end of col -->

                    @endforeach

                </div><!-- end of row -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/magnific-popup/magnific-popup.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('admin_assets/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <script>
        $(function () {

            $('#movie-images').magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled: true
                }
            });

        });

    </script>
@endpush

