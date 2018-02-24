<article @php(post_class())>
  <div class="entry-content has-text-justified dropcap">
    @php(the_content())
  </div>
  <footer class="single-footer">
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}

    <nav class="pagination" role="navigation" aria-label="pagination">
      {{ previous_post_link('<span class="pagination-next chevron-left">%link</span>', '%title') }}
      {{ next_post_link('<span class="pagination-previous chevron-right">%link</span>', '%title') }}
    </nav>
  </footer>
</article>
