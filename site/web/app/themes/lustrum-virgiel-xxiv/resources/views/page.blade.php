@extends('layouts.app')

@section('hero')
    <section class="hero lazy" data-src="@asset('images/common/hero-bg.png')">
        <div class="hero-body">
            <div class="container">
                <h1 class="is-uppercase fancy_title has-text-centered-mobile">{!! App::title() !!}</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{  App::wps_yoast_breadcrumb_bulma() }}

    <hr>

    <div class="dropcap has-text-justified">
        @while(have_posts()) @php(the_post())
        @include('partials.content-page')
        @endwhile
    </div>
@endsection

@section('sidebar')
    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection