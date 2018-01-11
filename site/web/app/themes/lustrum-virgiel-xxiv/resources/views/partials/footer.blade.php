<footer class="section content-info">
  <div class="container">
    <div class="columns">
      <div class="column has-text-centered-mobile">
        @php(dynamic_sidebar('sidebar-footer-1'))
      </div>
      <div class="column has-text-centered">
        @php(dynamic_sidebar('sidebar-footer-2'))
        <section class="widget widget_social has-text-centered">
          <h3>
            <div class="widget-title">Volg de 4e Dimensie!</div>
          </h3>
          <p class="is-size-4 is-uppercase has-text-weight-bold">#LustrumVirgiel</p>
          <div class="social-icons-footer">
            @include('partials.social')
          </div>
        </section>
      </div>
      <div class="column has-text-centered-mobile">
        @php(dynamic_sidebar('sidebar-footer-3'))
      </div>
    </div>
    <hr>
    <div class="footer-bottom level has-text-centered-mobile">
      <div class="level-left">

        @if(has_custom_logo())
          <div class="level-item">
            <figure class="image is-48x48">
              <img src="{{ wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' )[0] }}" />
            </figure>
          </div>
          <div class="level-item">
            <p>&copy; K.S.V. Sanctus Virgilius | Lustrum Media&Marketing Commissie <br>
              Vragen/opmerkingen/suggesties: <a href="mailto:{{ antispambot('media@lustrumvirgiel.nl') }}">{{ antispambot('media@lustrumvirgiel.nl') }}</a>.</p>
          </div>
        @endif
      </div>
      <div class="level-right">
        <a href="https://www.techmaus.nl/" target="_blank" rel="noopener" class="level-item">
          <figure class="image is-48x48">
            <img src="@asset('images/common/techmaus-footer.png')" alt="TECHMAUS - Website Ontwikkeling, Grafisch Design, IT-ondersteuning" />
          </figure>
        </a>
      </div>
    </div>
  </div>
</footer>