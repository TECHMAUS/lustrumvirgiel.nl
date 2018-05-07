@extends('layouts.app')

@section('hero')
    <section class="hero">
        <div class="hero-head">

        </div>
        <div class="hero-part hero-body columns is-vcentered">
            <div class="lustrumweek column has-text-centered is-half">
                <div class="title-card">
                    <h2 class="fancy_title">Lustrumweek</h2>
                    <h3>{{ the_field('event_subtitle', 242) }}</h3>
                    <h4>06 t/m 12 mei 2018, Delft</h4>

                    <div class="buttons">
                        <a href="{{ the_permalink(242) }}" class="button is-outlined is-uppercase has-shadow z-depth-1 hoverable mdi mdi-calendar">Programma</a>
                        <a href="{!! the_field('tickets_url', 242) !!}" rel="noopener" class="button is-outlined is-uppercase has-shadow z-depth-1 hoverable mdi mdi-ticket">Tickets</a>
                        <a href="/category/lustrumweek/" class="button is-outlined is-uppercase has-shadow z-depth-1 hoverable mdi mdi-bell">Updates</a>
                    </div>
                </div>
            </div>
            <div class="piekweek column has-text-centered is-half">
                <div class="title-card">
                    <h2 class="fancy_title">Piekweek</h2>
                    <h3>{{ the_field('event_subtitle', 244) }}</h3>
                    <h4>13 t/m 22 juli 2018, Delft</h4>

                    <div class="buttons">
                        <a href="{{ the_permalink(244) }}" class="button is-outlined is-uppercase has-shadow z-depth-1 hoverable mdi mdi-calendar">Programma</a>
                        <a href="{!! the_field('tickets_url', 244) !!}" rel="noopener" class="button is-outlined is-uppercase has-shadow z-depth-1 hoverable mdi mdi-ticket">Tickets</a>
                        <a href="/category/piekweek/" class="button is-outlined is-uppercase has-shadow z-depth-1 hoverable mdi mdi-bell">Updates</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section hero-part hero-foot">
            <div class="container is-fluid">
                <div class="level is-mobile">
                    <div class="level-item">
                        <span class="is-size-7 has-text-centered is-uppercase has-text-weight-bold">
                          Scroll
                        </span>
                        <object class="chevron-down animated infinite bounce" type="image/svg+xml" data="@asset('images/front-page/chevron-down.svg')">Down</object>
                    </div>
                </div>
            </div>
        </div>

        <div class="background-image" data-bg="{{ the_post_thumbnail_url($size = 'large') }}"></div>
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
                <div class="column is-one-third">
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