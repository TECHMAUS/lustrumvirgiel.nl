{{--
  Template Name: Media Overview
--}}

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
    @if( have_rows('media_overview_subjects') )

        @while( have_rows('media_overview_subjects') ) @php(the_row())

            <div class="columns media-event {{ strtolower(TemplateMediaOverview::subjectTitle()) }}">
                <div class="column is-2 media-title">
                    <h2 class="title is-marginless is-size-4-desktop is-size-5 is-uppercase has-text-weight-bold z-depth-1 has-word-wrap"><a id="{{ strtolower(TemplateMediaOverview::subjectTitle()) }}"> {{ TemplateMediaOverview::subjectTitle() }}</a></h2>
                </div>

                @if( have_rows('items') )
                    <div class="column media-content">
                        <div class="columns is-multiline is-vcentered">

                        @while( have_rows('items') ) @php(the_row())
                            @if(get_sub_field('item_family') == 'embed')

                                <div class="column has-text-centered is-half-tablet is-one-third-desktop">
                                    <div class="wrap z-depth-1 is-hoverable">
                                        {!! apply_filters('the_content', TemplateMediaOverview::oEmbed()) !!}
                                    </div>
                                </div>

                            @elseif(get_sub_field('item_family') == 'pagina')

                                <div class="column has-text-centered is-half-tablet is-one-third-desktop">
                                    <a href="{{ get_permalink(TemplateMediaOverview::pageObject()->ID) }}">
                                        <div class="image is-16by9 z-depth-1 is-hoverable lazy" data-src="{{ get_the_post_thumbnail_url(TemplateMediaOverview::pageObject()->ID) }}">
                                            <div class="title z-depth-1">
                                                <h3 class="is-uppercase is-size-5 is-marginless has-text-weight-bold">{!! get_the_title(TemplateMediaOverview::pageObject()->ID) !!}</h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endwhile

                        </div>
                    </div>

                @endif

            </div>
        @endwhile
    @endif
@endsection
