{{--
  Template Name: Media
--}}

<!doctype html>
<html @php(language_attributes())>
@include('partials.head')
<body @php(body_class())>
@php(do_action('get_header'))
@include('partials.header')
<section class="hero is-medium lazy" data-src="@asset('images/common/hero-bg.png')">
    <div class="hero-body">
        <div class="container is-fluid">
            <h1 class="is-uppercase has-word-wrap z-depth-1 is-size-1 is-size-3-touch has-text-centered-mobile has-text-weight-bold">{!! App::title() !!}</h1>
        </div>
    </div>
</section>
<div class="section">
    <div class="container is-fluid" role="document">
        <div class="content @hasSection ('sidebar') columns is-desktop @endif">
            <main class="main @hasSection ('sidebar') column is-two-thirds-desktop @endif">
                {{  App::wps_yoast_breadcrumb_bulma() }}


                @while(have_posts()) @php(the_post())
                @include('partials.content-page')
                @endwhile
            </main>
            @hasSection ('sidebar')
                <aside class="sidebar column">
                    @yield('sidebar')
                </aside>
            @endif
        </div>
    </div>
</div>
@php(do_action('get_footer'))
@include('partials.footer')
@php(wp_footer())
</body>
</html>
