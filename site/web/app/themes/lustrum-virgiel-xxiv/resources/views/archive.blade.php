{{--
  Template Name: Archief
--}}

@extends('layouts.app')

@section('hero')
    <section class="hero is-medium lazy" data-src="@asset('images/common/hero-bg.png')">
        <div class="hero-body">
            <div class="container">
                <h1 class="is-uppercase has-word-wrap z-depth-1 is-size-1 is-size-3-touch has-text-centered-mobile has-text-weight-bold">{!! App::title() !!}</h1>
                <div class="category-description is-size-5">
                    {!! category_description() !!}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{  App::wps_yoast_breadcrumb_bulma() }}

    @if (!have_posts())
        <div class="alert alert-warning">
            {{ __('Sorry, no results were found.', 'sage') }}
        </div>
        {!! get_search_form(false) !!}
    @endif

    <div class="columns is-multiline">
        @if(have_posts())
            @while(have_posts())  @php(the_post())
            <div class="column is-half is-one-third-widescreen is-one-quarter-fullhd">
                @include('partials.content')
            </div>
            @endwhile
        @endif
    </div>

    <footer class="single-footer">
        {!! get_the_posts_navigation() !!}
    </footer>

@endsection

@section('sidebar')
    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection