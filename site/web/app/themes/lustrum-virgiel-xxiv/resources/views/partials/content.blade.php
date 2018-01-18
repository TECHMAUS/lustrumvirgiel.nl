<article @php(post_class('news-card')) data-tilt data-tilt-perspective="1200" data-tilt-scale="1.05">
  <div class="card">
    @if(get_the_post_thumbnail_url() && get_post_type() == 'post')
      <a href="{{ the_permalink() }}" class="has-text-white">
        <div class="card-image entry-image image is-2by1 lazy" data-src="{{ the_post_thumbnail_url() }}">
          @include('partials/entry-meta')
        </div>
      </a>
    @endif
    <div class="card-content">
      <header>
        @if(!get_the_post_thumbnail_url() && get_post_type() == 'post')
          @include('partials/entry-meta')
        @endif
        <h2 class="entry-title"><a href="{{ the_permalink() }}" class="has-text-white has-text-weight-bold is-size-4">{{ the_title() }}</a></h2>
      </header>
      <div class="entry-summary">
        @php(the_excerpt())

        <hr>
        <div class="columns is-vcentered is-mobile">
          <div class="column post-categories">
            @if(! empty(get_the_category()))
            <span class="icon is-small" style="background-image:url('@asset('images/news-entry/category.svg')')"></span>
            <span>
                {!! get_the_category_list(', ')  !!}
            </span>
            @endif
          </div>
          <a class="column is-narrow read-more-tag has-text-white" href="{{ the_permalink() }}">
            <span class="has-text-right">Lees meer</span> <span class="icon is-small" style="background-image:url('@asset('images/news-entry/chevron-right.svg')')"></span>
          </a>
        </div>

      </div>
    </div>
  </div>
</article>
