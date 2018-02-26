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
    @while (have_posts()) @php(the_post())
    <div class="introduction">
        <div class="dropcap has-text-justified">
            {{ the_content() }}
        </div>
    </div>

    @if(have_rows('events'))
        <div class="year-overview">
            <div class="timeline is-centered">
                <header class="timeline-header">
                    <span class="tag is-medium is-dark z-index-1 is-uppercase">{{ the_field('timeline_text_start') }}</span>
                </header>

                    @while(have_rows('events')) @php(the_row())

                        <div class="timeline-item">
                            <div class="timeline-marker has-text-centered is-image is-48x48 z-index-1">
                                <img src="{{ the_sub_field('event_image') }}">
                            </div>
                            <div class="timeline-content">
                                <span class="tag is-medium heading z-depth-1 has-shadow" style="background-color: {{ the_sub_field('event_color') }}">{{ the_sub_field('event_title') }}</span>
                                <p class="is-size-7 is-uppercase">{{ the_sub_field('event_subtitle') }}</p>
                                <p>"{{ the_sub_field('event_description') }}"</p>
                                <a class="button is-small" href="{{ the_sub_field('event_link') }}">Meer info...</a>
                            </div>
                        </div>

                    @endwhile

                <header class="timeline-header">
                    <span class="tag is-medium is-uppercase is-dark z-index-1">{{ the_field('timeline_text_end') }}</span>
                </header>
            </div>
        </div>
    @endif

    @endwhile
@endsection

@section('sidebar')
    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection