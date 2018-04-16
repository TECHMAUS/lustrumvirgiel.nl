{{--
  Template Name: LustrumSubEvenement
--}}

@extends('layouts.app')

@section('hero')
    <section class="hero lazy" @if(get_the_post_thumbnail_url()) data-src="{{ the_post_thumbnail_url() }}" @endif>
        <div class="hero-body">
            <div class="container">
                <h1 class="is-uppercase fancy_title has-text-centered-mobile">{!! App::title() !!}</h1>
                <h2 class="is-uppercase is-size-4 has-text-weight-bold has-text-centered-mobile">{{ the_field('event_subtitle') }}</h2>
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
    <div class="quick-facts">
        @if($days_until_event >= 0)
            <div class="has-text-right">
                <div class="counter">
                    <div class="days">
                        <span class="has-text-weight-bold">{!! $days_until_event !!}</span>
                    </div>
                    <div class="text has-text-left bigtext">
                        @if($days_until_event == 1)
                            <span class="is-uppercase">Nachtje</span>
                        @else
                            <span class="is-uppercase">Nachtjes</span>
                        @endif
                        <span class="is-uppercase">Slapen</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-content">
                <div class="content is-uppercase has-text-weight-bold">
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/1d-icon.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Datum & tijd:</span>{!! $quick_facts_date !!} </p></div>
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/2d-icon.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Locatie: </span>{!! the_field('quick_facts_2d') !!}</p></div>
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/3d-icon.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Kaarten: </span>{!! the_field('quick_facts_3d') !!}</p></div>
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/4d-icon.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Contact: </span><a class="has-text-white has-word-wrap" href="mailto:{{ App::authorEmail() }}">{{ App::authorEmail() }}</a></p> </div>
                </div>
            </div>
        </div>
    </div>

    <section class="widget social-share">
        @include('partials.social-share-buttons')
    </section>

    @if($related_posts->have_posts())
        <section class="widget widget_related_posts">
            <h3><div class="widget-title has-shadow z-depth-1">
                    <span class="icon lazy" data-src="@asset('images/common/3d-icon.svg')"></span> Updates</div></h3>

            @while($related_posts->have_posts())  @php($related_posts->the_post())
            @include('partials.content-related')
            @endwhile
            {{ wp_reset_postdata() }}

        </section>

    @endif

    @if(!empty($event_location))
        <section class="widget">
            <h3><div class="widget-title has-shadow z-depth-1">
                    <span class="icon lazy" data-src="@asset('images/common/2d-icon.svg')"></span> Locatie
                </div>
            </h3>

            <div class="acf-map">
                <div class="marker" data-lat="{!! $event_location['lat'] !!}" data-lng="{!! $event_location['lng'] !!}"></div>
            </div>
        </section>
    @endif

    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection