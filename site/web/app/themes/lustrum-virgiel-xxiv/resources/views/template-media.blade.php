{{--
  Template Name: Media
--}}

@extends('layouts.app')

@section('hero')
    <section class="hero is-medium lazy" data-src="@asset('images/common/hero-bg.png')">
        <div class="hero-body">
            <div class="container">
                <h1 class="is-uppercase has-word-wrap z-depth-1 is-size-1 is-size-3-touch has-text-centered-mobile has-text-weight-bold">{!! App::title() !!}</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')

    <div class="level">
        <div class="level-left">
            {{  App::wps_yoast_breadcrumb_bulma() }}
        </div>

        <div class="level-right">
            @if(defined('ADROTATE_VERSION'))
                {!! adrotate_group(2) !!}
            @endif
        </div>
    </div>

    @while(have_posts()) @php(the_post())
        @include('partials.content-page')
    @endwhile

@endsection