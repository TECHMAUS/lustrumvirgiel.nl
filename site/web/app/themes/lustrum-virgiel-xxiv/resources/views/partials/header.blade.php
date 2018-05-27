    <header class="site-header z-depth-2">
            <div class="level is-mobile header-bar is-marginless">
                <button class="header-toggle level-left is-paddingless">
                    <div class="header-toggleBurger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="header-toggleLabel is-uppercase has-text-weight-bold is-size-5">Menu</div>
                </button>

                <a class="brand-title has-text-centered is-uppercase" href="{{ home_url('/') }}">
                    <h1 class="subtitle has-text-weight-bold"> {{ get_bloginfo('name', 'display') }} </h1>
                </a>

                @if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && App::published_products())
                    <a class="header-announcement has-text-centered is-uppercase" href="{{ get_permalink( wc_get_page_id( 'shop' ) ) }}">
                        <h1 class="subtitle has-text-weight-bold">🚨 Koop nu je Lustrumgadgets in de Lustrumshop! <i class="mdi mdi-arrow-right"></i></h1>
                    </a>
                @endif

                <div class="level-right">
                    <div class="buttons">
                        <a href="{{ the_permalink(244) }}" class="button is-outlined is-uppercase button-piekweek">Programma</a>
                        <a href="{!! the_field('tickets_url', 244) !!}" class="button is-outlined is-uppercase button-gala">Tickets</a>
                        @if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && App::published_products())
                            <a href="{!! wc_get_cart_url() !!}" class="mdi mdi-cart mdi-24px has-text-white shopping-cart-header" title="Bekijk je winkelwagen"><span class="cart-counter">{!! WC()->cart->get_cart_contents_count() !!}</span>{!! WC()->cart->get_cart_total() !!}</a>
                        @endif
                    </div>
                </div>

            </div>
                <div id="sidenav-main" class="has-text-white is-uppercase">
                    <nav>
                        <div class="menu-header">
                            <a class="nav-close is-pulled-right has-text-white">&times;</a>
                            @if(has_custom_logo())
                                <a href="{{ home_url( '/' )}}" rel="home" class="logo-header-menu">
                                    <img src="{{ wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' )[0] }}" class="logo-sticker image" alt="De Vierde Dimensie" />
                                </a>
                            @endif
                        </div>

                        <div class="menu-items">
                            {{ wp_nav_menu( array( 'theme_location' => 'primary_navigation', 'depth' => 2 ) ) }}
                        </div>

                        <div class="menu-footer">

                            <hr>

                            <div class="menu-search has-text-centered">
                              {{ get_search_form() }}
                            </div>

                            <div class="social has-text-centered">
                              <p class="is-uppercase has-text-weight-bold has-text-white">Volg het 24ᵉ Lustrum ook online!</p>
                              <div class="social-links">
                                @include('partials/social')
                              </div>
                            </div>

                        </div>
                        <div id="page-overlay" role="presentation"></div>
                    </nav>
                </div>
    </header>

