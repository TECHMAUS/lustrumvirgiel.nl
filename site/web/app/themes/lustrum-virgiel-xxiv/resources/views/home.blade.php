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