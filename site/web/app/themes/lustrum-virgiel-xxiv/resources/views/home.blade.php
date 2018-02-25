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
    @if($news_filters)
    <div class="news-filter has-text-centered">
        <div class="columns is-vcentered">
            <div class="column is-narrow column-left">
                <h2 class="is-marginless"><span class="is-uppercase has-text-weight-bold filter-title">Filter</span></h2>
            </div>

            <div class="column column-right">
                <div class="tags">
                    @foreach( $news_filters as $news_filter )
                        <a href="{{ get_term_link( $news_filter ) }}">
                            <span class="tag is-uppercase has-text-weight-bold"> {!! $news_filter->name !!} </span>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <hr>
    @endif

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