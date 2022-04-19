@extends('layouts.admin.app')

@section('title', __('site.home'))

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

            <!-- top statistics -->
            <div class="row" id="top-statistics">

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-2">
                                <p class="mb-0"><i class="fa fa-list"></i> @lang('genres.genres')</p>
                                <a href="{{ route('admin.genres.index') }}">@lang('site.show_all')</a>
                            </div>

                            <div class="loader loader-sm"></div>

                            <h3 class="mb-0" id="genres-count" style="display: none"></h3>

                        </div>
                    </div>
                </div><!-- end of col -->

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-2">
                                <p class="mb-0"><i class="fa fa-film"></i> @lang('movies.movies')</p>
                                <a href="{{ route('admin.movies.index') }}">@lang('site.show_all')</a>
                            </div>

                            <div class="loader loader-sm"></div>

                            <h3 class="mb-0" id="movies-count" style="display: none;"></h3>

                        </div>
                    </div>
                </div><!-- end of col -->

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-2">
                                <p class="mb-0"><i class="fa fa-address-book-o"></i> @lang('actors.actors')</p>
                                <a href="{{ route('admin.actors.index') }}">@lang('site.show_all')</a>
                            </div>

                            <div class="loader loader-sm"></div>

                            <h3 class="mb-0" id="actors-count" style="display: none;"></h3>

                        </div>
                    </div>
                </div><!-- end of col -->

            </div><!-- end of row -->

            <!-- movies chart -->
            <div class="row my-3">

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">
                                <h4>@lang('movies.movies_chart')</h4>
                                <select id="movies-chart-year" style="width: 100px;">
                                    @for ($i = 5; $i >=0 ; $i--)
                                        <option value="{{ now()->subYears($i)->year }}" {{ now()->subYears($i)->year == now()->year ? 'selected' : '' }}>
                                            {{ now()->subYears($i)->year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div id="movies-chart-wrapper"></div>

                        </div><!-- end of card body -->

                    </div><!-- end of card -->

                </div><!-- end of col -->

            </div><!-- end of row -->

        </div>
    </div>
@endsection

@push('scripts')
    <!-- apex chart -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>

        $(function () {

            topStatistics();

            moviesChart("{{ now()->year }}");

            $('#movies-chart-year').on('change', function () {

                let year = $(this).find(':selected').val();

                moviesChart(year);
            });

        });

        function topStatistics() {
            $.ajax({
                url: "{{ route('admin.home.top_statistics') }}",
                cache: false,
                success: function (data) {

                    $('#top-statistics .loader-sm').hide();

                    $('#top-statistics #genres-count').show().text(data.genres_count);
                    $('#top-statistics #movies-count').show().text(data.movies_count);
                    $('#top-statistics #actors-count').show().text(data.actors_count);

                },
            });
        } //end of topStatistics

        function moviesChart(year) {

            let loader = `
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="loader loader-md"></div>
                    </div>
                `;

            $('#movies-chart-wrapper').empty().append(loader);

            $.ajax({
                url: "{{ route('admin.home.movies_chart') }}",
                data: {
                    'year': year,
                },
                cache: false,
                success: function (html) {
                    $('#movies-chart-wrapper').empty().append(html);
                },

            });//end of ajax call

        } //end of moviesChart

    </script>
@endpush
