@extends('layouts.app')

@section('hero')
    <section class="hero">
        <div class="hero-head">

        </div>
        <div class="hero-part hero-body is-paddingless scattered-4d">
            <div class="container is-fluid has-text-centered">
                <div>
                    <span id="scattered-1">4</span>
                    <span id="scattered-2">e</span>
                </div>
                <div class="is-uppercase">
                    <span id="scattered-3">d</span>
                    <span id="scattered-4">i</span>
                    <span id="scattered-5">m</span>
                    <span id="scattered-6">e</span>
                    <span id="scattered-7">n</span>
                    <span id="scattered-8">s</span>
                    <span id="scattered-9">i</span>
                    <span id="scattered-10">e</span>
                </div>
            </div>
        </div>
        <div class="section hero-part hero-foot">
            <div class="container is-fluid">
                <div class="level is-mobile">
                    <div class="level-left is-one-quarter">
                        @include('partials.social')
                    </div>

                    <div class="level-item">
                        <span class="is-size-7 has-text-centered is-uppercase has-text-weight-bold">
                          Scroll
                        </span>
                        <object class="chevron-down animated infinite bounce" type="image/svg+xml" data="@asset('images/front-page/chevron-down.svg')">Down</object>
                    </div>

                    <div class="level-right is-one-quarter is-uppercase has-text-weight-bold">
                        '17<br>'18
                    </div>
                </div>
            </div>
        </div>

        <div class="background-image lazy" data-src="{{ the_post_thumbnail_url($size = 'large') }}"></div>
        <div class="background-image background-confetti lazy" data-src="@asset('images/common/hero-bg.png')"></div>

    </section>

    @include('partials.actionbanner')
@endsection

@section('content')

    @while (have_posts()) @php(the_post())
        <div class="introduction">
            <div class="dropcap has-text-justified">
                {{ the_content() }}
            </div>

            @if(have_rows('home_quick_links_introduction'))
                <div class="quick-links has-text-centered">
                        @while(have_rows('home_quick_links_introduction')) @php(the_row())
                            <a href="{{ the_sub_field('button_link') }}" class="button is-uppercase has-shadow z-depth-1 hoverable {{ the_sub_field('button_style') }}">{{ the_sub_field('button_name') }}</a>
                        @endwhile
                </div>
            @endif
        </div>
    @endwhile

    @if(defined('ADROTATE_VERSION'))
        {!! adrotate_group(1) !!}
    @endif

    @if($recent_posts->have_posts())
        <div class="news">
            <div class="section-title title-has-icon">
                <span class="icon lazy" data-src="@asset('images/front-page/latest-news.svg')"></span>
                <h2>{{ the_field('news_title') }}</h2>
            </div>

            <div class="columns is-multiline">

                @while($recent_posts->have_posts())  @php($recent_posts->the_post())
                    <div class="column is-half">
                        @include('partials.content')
                    </div>
                @endwhile
                    {{ wp_reset_postdata() }}



            </div>

            @if(have_rows('home_quick_links_news'))
                <div class="quick-links has-text-centered">
                    @while(have_rows('home_quick_links_news')) @php(the_row())
                    <a href="{{ the_sub_field('button_link') }}" class="button is-uppercase has-shadow z-depth-1 hoverable {{ the_sub_field('button_style') }}">{{ the_sub_field('button_name') }}</a>
                    @endwhile
                </div>
            @endif
        </div>
    @endif

        <div class="featured-media">
            <div class="section-title title-has-icon">
                <span class="icon lazy" data-src="@asset('images/front-page/featured-media.svg')"></span>
                <h2>{{ the_field('featured_media_title') }}</h2>
            </div>
            {{ the_field('featured_media_content') }}

            @if(have_rows('home_quick_links_featured_media'))
                <div class="quick-links has-text-centered">
                    @while(have_rows('home_quick_links_featured_media')) @php(the_row())
                    <a href="{{ the_sub_field('button_link') }}" class="button is-uppercase has-shadow z-depth-1 hoverable {{ the_sub_field('button_style') }}">{{ the_sub_field('button_name') }}</a>
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