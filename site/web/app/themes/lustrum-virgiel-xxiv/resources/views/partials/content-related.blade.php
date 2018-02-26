<a rel="external" href="{{ the_permalink() }}">
	<article class="related-post">
		<div class="related-left">
			<figure class="image is-64x64 is-marginless">
				{{ the_post_thumbnail(array(64,64)) }}
			</figure>
		</div>
		<div class="related-content">
			<div class="content">
				<small class="has-text-white is-uppercase is-marginless">{{ get_the_date() }}</small>
				<h4 class="title is-6 is-uppercase has-text-weight-bold is-marginless">{{  the_title() }}</h4>
			</div>
		</div>
	</article>
</a>