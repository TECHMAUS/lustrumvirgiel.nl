<!doctype html>
<html @php(language_attributes())>
  @include('partials.head')
  <body @php(body_class())>
    @php(do_action('get_header'))
    @include('partials.header')
    @yield('hero')
    <div class="section">
     <div class="wrap container" role="document">
        <div class="content @hasSection ('sidebar') columns is-desktop @endif">
          <main class="main @hasSection ('sidebar') column is-two-thirds-desktop @endif">
            @yield('content')
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
