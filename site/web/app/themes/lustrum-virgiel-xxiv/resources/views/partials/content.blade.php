<article @php(post_class('news-card')) data-tilt data-tilt-perspective="1200" data-tilt-scale="1.05">
  <div class="card">
    @if(get_the_post_thumbnail_url() && get_post_type() == 'post')
          <a href="{{ the_permalink() }}"><div class="card-image entry-image image is-2by1 lazy" data-src="{{ the_post_thumbnail_url() }}">
          @include('partials/entry-meta')
        </div></a>
    @endif
    <div class="card-content has-text-centered">
      <header>
        @if(!get_the_post_thumbnail_url() && get_post_type() == 'post')
          @include('partials/entry-meta')
        @endif
          @if(! empty(get_the_category()))
            <div class="category-title">
              <span class="is-uppercase is-size-6 has-text-weight-bold">
                {!! get_the_category_list('&#32;&#8211;&#32;')  !!}
              </span>
            </div>
          @endif
        <h2 class="entry-title has-text-centered"><a href="{{ the_permalink() }}" class="has-text-white is-uppercase has-text-weight-bold is-size-5">{{ the_title() }}</a></h2>
          <a href="{{ the_permalink() }}" class="is-uppercase has-text-weight-bold is-size-7">Lees meer...</a>
      </header>
    </div>
  </div>
</article>
