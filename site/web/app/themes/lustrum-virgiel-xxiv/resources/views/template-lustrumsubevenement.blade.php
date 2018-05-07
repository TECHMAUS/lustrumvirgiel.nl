{{--
  Template Name: LustrumSubEvenement
--}}

@extends('layouts.app')

@section('hero')
    <section class="hero lazy" @if(get_the_post_thumbnail_url()) data-src="{{ the_post_thumbnail_url() }}" @endif>
        <div class="hero-body">
            <div class="container">
                <h1 class="is-uppercase fancy_title has-text-centered-mobile">{!! App::title() !!}</h1>
                @if(!empty(get_field('event_subtitle')))
                    <div class="subtitle">
                        <h2 class="is-uppercase is-size-5 is-size-4-tablet is-size-3-desktop has-text-weight-bold has-text-centered-mobile">{{ the_field('event_subtitle') }}</h2>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{  App::wps_yoast_breadcrumb_bulma() }}

    <hr>

    @while(have_posts()) @php(the_post())
    <div class="dropcap has-text-justified">
        @include('partials.content-page')
    </div>

        @if(have_rows('artists'))
            <div class="artists">
                <h2>Line-up</h2>
                <div class="columns is-multiline is-mobile">
                    @while(have_rows('artists')) @php(the_row())
                        <div class="artist column is-half-mobile is-one-third-tablet is-one-quarter-desktop">
                            <a href="{!! TemplateLustrumsubevenement::artistLink() !!}" target="_blank" rel="nofollow">
                                <div class="artist-tile has-shadow z-depth-1" data-tilt>
                                    <div class="artist-image lazy" data-src="{!! TemplateLustrumsubevenement::artistImage() !!}">
                                    </div>
                                    <div class="artist-title">
                                        <h5 class="has-text-weight-bold is-marginless is-uppercase has-shadow z-depth-2">{{ TemplateLustrumsubevenement::artistName() }}</h5>
                                    </div>
                                    <div class="artist-link-out">
                                        <svg viewBox="0 0 24 24">
                                            <path fill="#fff" d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endwhile
                </div>
            </div>
        @endif

    <div class="dropcap has-text-justified">
        {{ the_field('practical_information') }}
    </div>
    @endwhile
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
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/3d-icon.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Kaarten: </span>{!! $ticket_fact !!}</p></div>
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/4d-icon.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Contact: </span><a class="has-text-white has-word-wrap" href="mailto:{{ App::authorEmail() }}">{{ App::authorEmail() }}</a></p> </div>
                </div>
            </div>
        </div>
    </div>

    <div class="social-share">
        @if(!get_field('sold_out'))
            <a  href="{!! the_field('tickets_url', TemplateLustrumsubevenement::parentPageID()) !!}"
                class="share-button tickets button z-depth-1 mdi mdi-ticket mdi-rotate-315 is-uppercase"
                target="_blank"
                rel="noopener">
                Tickets
            </a>
        @endif
        @if(!empty(the_field('fb_event_url')))
            <a href="{!! the_field('fb_event_url') !!}"
               class="share-button facebook button z-depth-1 mdi mdi-facebook is-uppercase"
               target="_blank"
               rel="noopener">
                Event
            </a>
        @endif
    </div>

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

    @if(have_rows('timetable'))
        <section class="widget timetable">
            <h3><div class="widget-title has-shadow z-depth-1 mdi mdi-clock mdi-24px">
                Timetable
            </div></h3>
            <table class="timetable-table">
                <tbody>
                    @while(have_rows('timetable')) @php(the_row())
                        <tr class="row">
                            <td class="time has-text-weight-light">{{ the_sub_field('time') }}</td>
                            <td class="artist has-text-weight-bold is-size-5 is-uppercase">{{ the_sub_field('artist') }}</td>
                        </tr>
                    @endwhile
                </tbody>
            </table>
        </section>
    @endif

    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection