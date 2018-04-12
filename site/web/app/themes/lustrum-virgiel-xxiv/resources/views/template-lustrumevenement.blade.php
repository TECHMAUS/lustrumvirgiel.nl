{{--
  Template Name: Lustrumevenement
--}}

@extends('layouts.app')

@section('hero')
    <section class="hero is-medium video lazy" data-src="{{ the_post_thumbnail_url() }}">

        @if(!empty($event_video))
            <div class="hero-video">
                <video poster="{{ the_post_thumbnail_url() }}" id="bgvid" playsinline autoplay muted loop>
                    <source src="{!! $event_video !!}" type="video/mp4">
                </video>
            </div>
        @endif

        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="is-uppercase fancy_title has-text-centered">{!! App::title() !!}</h1>
                <h2 class="is-uppercase is-size-3 has-text-weight-bold has-text-centered">{{ the_field('event_subtitle') }}</h2>
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
    <section class="widget">
    @include('partials.social-share-buttons')
    </section>

    @if($related_posts->have_posts())
        <section class="widget widget_related_posts">
            <h3><div class="widget-title has-shadow z-depth-1">
                    <span class="icon lazy" data-src="@asset('images/common/3d-icon.svg')"></span> Nieuws</div></h3>

            @while($related_posts->have_posts())  @php($related_posts->the_post())
            @include('partials.content-related')
            @endwhile
            {{ wp_reset_postdata() }}

            <div class="has-text-centered">
                <a href="{!! home_url() !!}/tag/{!! get_post_field('post_name') !!}" class="button is-uppercase has-shadow z-depth-1 hoverable button-gala">Meer nieuws ></a>
            </div>

        </section>
    @endif

    @php(dynamic_sidebar('sidebar-event-' . get_post_field('post_name')))
@endsection