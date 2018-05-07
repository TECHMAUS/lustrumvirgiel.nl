{{--
  Template Name: Lustrumevenement
--}}

@extends('layouts.app')

@section('hero')
    <section class="hero video lazy" data-src="{{ the_post_thumbnail_url() }}">

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
                @if(!empty(get_field('event_subtitle')))
                    <div class="subtitle">
                        <h2 class="is-uppercase is-size-5 is-size-4-tablet is-size-3-desktop has-text-weight-bold has-text-centered">{{ the_field('event_subtitle') }}</h2>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @include('partials.actionbanner')
@endsection

@section('content')
    {{  App::wps_yoast_breadcrumb_bulma() }}

    <hr>

    @while(have_posts()) @php(the_post())
    <div class="dropcap has-text-justified">
        @include('partials.content-page')
    </div>
    @endwhile

    @if(have_rows('activiteiten'))
        <div class="event-programm">
            <div class="section-title">
                <h2 class="programm-title">Programma</h2>
            </div>

            <div class="columns is-multiline is-mobile event-tiles">
                @while(have_rows('activiteiten')) @php(the_row())
                    <div class="column is-half-mobile is-one-quarter-tablet">
                        <a href="{!! get_permalink(TemplateLustrumevenement::activityPage()->ID) !!}">
                            <div class="event-tile has-shadow z-depth-1">
                                <div class="event-image lazy" data-src="{!! TemplateLustrumevenement::activityImage() !!}">
                                </div>
                                <div class="event-date">
                                    <span class="font-fit">{!! TemplateLustrumevenement::activityDate(TemplateLustrumevenement::activityPage()) !!}</span>
                                    <span class="font-fit">{!! TemplateLustrumevenement::activityMonth(TemplateLustrumevenement::activityPage()) !!}</span>
                                </div>
                                <div class="event-title">
                                    <span class="font-fit">{!! TemplateLustrumevenement::activityTitle() !!}</span>
                                </div>
                                <div class="event-read-more has-text-black has-text-weight-bold">
                                    <span class="is-size-7">Lees meer</span>
                                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                        <path fill="#000" d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z" />
                                    </svg>
                                </div>
                                @if(get_field('sold_out', TemplateLustrumevenement::activityPage()->ID))
                                    <span class="sold-out is-uppercase has-text-weight-bold has-background-danger">Uitverkocht!</span>
                                @endif
                            </div>
                        </a>
                    </div>
                @endwhile
            </div>
        </div>
    @endif
@endsection

@section('sidebar')
    @if($related_posts->have_posts())
        <section class="widget widget_related_posts">
            <h3><div class="widget-title has-shadow z-depth-1">
                    <span class="icon lazy" data-src="@asset('images/common/3d-icon.svg')"></span> Nieuws</div></h3>

            @while($related_posts->have_posts())  @php($related_posts->the_post())
                @include('partials.content-related')
            @endwhile
            @php(wp_reset_postdata())

            <div class="has-text-centered">
                <a href="{!! home_url() !!}/tag/{!! App::pageSlug() !!}" class="button is-uppercase has-shadow z-depth-1 hoverable button-gala">Meer nieuws ></a>
            </div>

        </section>
    @endif

    @php(dynamic_sidebar('sidebar-event-' . get_post_field('post_name')))
@endsection