@extends('layouts.app')

@section('hero')
    <section class="site-hero">
        <div class="container has-text-right">
            <div class="video-promo">
                <video poster="{{ the_post_thumbnail_url(244) }}" playsinline preload="auto" loop id="hero-video">
                    <source src="{!! get_field('event_background_video', 244) !!}" type="video/mp4">
                </video>
                <div id="play-button" class="mdi mdi-play-circle"></div>
                <div class="title-card has-text-left">
                    <h3 class="is-uppercase has-text-weight-bold is-size-5 is-size-6-mobile">Het laatste hoofdstuk van het Lustrumjaar</h3>
                    <h2 class="is-uppercase has-text-weight-bold">Piekweek</h2>
                    <h4 class="is-uppercase has-text-weight-bold is-size-4 is-size-5-tablet is-size-6-mobile has-shadow z-depth-1">13 t/m 22 juli 2018, Delft</h4>
                    <div class="buttons">
                        <a href="{{ the_permalink(244) }}" class="button is-large is-uppercase is-white has-shadow z-depth-1">Programma</a>
                        <a href="{!! the_field('tickets_url', 244) !!}" class="button is-large is-uppercase button-gala has-shadow z-depth-1">Tickets</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="background-image lazy" data-src="@asset('images/front-page/confetti-bg-new.svg')"></div>
    </section>

    @include('partials.actionbanner')
@endsection

@section('content')

    @if($recent_posts->have_posts())
        <div class="news">
            <div class="section-title is-uppercase">
                <h2>{{ the_field('news_title') }}</h2>
            </div>

            <div class="columns is-multiline">

                @while($recent_posts->have_posts())  @php($recent_posts->the_post())
                <div class="column is-one-quarter">
                    @include('partials.content')
                </div>
                @endwhile
                {{ wp_reset_postdata() }}

            </div>

            @if(have_rows('home_quick_links_news'))
                <div class="quick-links has-text-centered">
                    @while(have_rows('home_quick_links_news')) @php(the_row())
                    <a href="{{ the_sub_field('button_link') }}" class="button is-medium is-uppercase has-shadow z-depth-1 hoverable {{ the_sub_field('button_style') }}">{{ the_sub_field('button_name') }}<i class="mdi mdi-chevron-right mdi-24px"></i></a>
                    @endwhile
                </div>
            @endif
        </div>
    @endif

    @while (have_posts()) @php(the_post())
    <div class="introduction columns">
        <div class="has-text-centered column is-half is-offset-one-quarter introduction-text">
            {{ the_content() }}
        </div>
    </div>
    @endwhile

    <div class="featured-media">
        <div class="section-title is-uppercase">
            <h2>{{ the_field('featured_media_title') }}</h2>
        </div>
        {{ the_field('featured_media_content') }}

        @if(have_rows('home_quick_links_featured_media'))
            <div class="quick-links has-text-centered">
                @while(have_rows('home_quick_links_featured_media')) @php(the_row())
                <a href="{{ the_sub_field('button_link') }}" class="button is-medium is-uppercase has-shadow z-depth-1 hoverable {{ the_sub_field('button_style') }}">{{ the_sub_field('button_name') }}<i class="mdi mdi-chevron-right mdi-24px"></i></a>
                @endwhile
            </div>
        @endif
    </div>

@endsection

@section('sidebar')
    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection