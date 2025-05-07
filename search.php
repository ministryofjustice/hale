<?php
/**
 * The search results page
 * This is the template file to display search results.
 * It is used to display a a list of pages / posts matching a search query.
 * Each result is presented in its own promo panel at 1/3 width.
 * The sidebar is intentionally disabled on this view, regardless of site settings.
 *
 * @link      https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   2.0
 */

get_header();
?>

	<div id="primary" class="govuk-grid-column-two-thirds">
		<header class="hale-search-header" style="">
      <h1 style="line-height:0;">
        <span class="govuk-heading-xl govuk-!-margin-bottom-0">
          <?php _e("Search results","hale");?>
        </span>
        <br />
        <span class="govuk-body-l">
          <?php 
            /* translators: %s: search term */
            if (get_search_query() == "") {
              _e("No search words entered","hale");
            } else {
              $search_query_HTML = esc_html(get_search_query());
              echo sprintf(__('for %s', 'hale' ), $search_query_HTML);
            }

            $header_search = get_theme_mod( 'show_search', 'yes' );
          ?>
        </span>
      </h1>
      <?php get_search_form(); ?>
		</header>
		<div class="index">
			<?php
			if ( have_posts() ) :
				?>

				<h2 class="govuk-heading-m">
					<?php /* Search Count */
						echo sprintf(__('%s results', 'hale' ), $wp_query->found_posts);
					?>
				</h2>

				<div class="hale-search-results">
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
						?>
           <hr class="govuk-section-break govuk-section-break--m govuk-section-break--visible">
						<div class="hale-search-result__item">
              <?php
              if ( has_post_thumbnail() ) :
                the_post_thumbnail( 'thumbnail', [ 'class' => 'hale-promo__image' ] );
              else :
                $fallback = get_theme_mod( 'blog_fallback' );
                if ( $fallback ) {
                  echo wp_get_attachment_image( $fallback, 'thumbnail', false, [ 'class' => 'hale-promo__image' ] );
                }
              endif;
              ?>

              <h3 class="govuk-heading-m">
                <a class="govuk-link" href="<?php the_permalink(); ?>">
                  <?php echo strip_tags(get_the_title()); ?>
                </a>
              </h2>

              <?php do_action( 'hale_before_archive_content' ); ?>
              <p class="govuk-body">
                <?php
                  the_excerpt();
                ?>
              </p>
              <?php do_action( 'hale_after_archive_content' ); ?>

              <?php
              // Get and display the last updated time of the search result
                $u_time = get_the_time('U');
                $u_modified_time = get_the_modified_time('U');
                echo "<p class='govuk-body hale-search-results__last-updated-date'>";
                echo "Published: " . get_the_date();
                echo "</p> ";
              ?>
						</div>
						<?php
					endwhile;
					?>
				</div>
				<?php
				hale_archive_pagination();
				else :
					get_template_part( 'template-parts/content', 'none' );
			endif;
				?>
		</div>
	</div><!-- #primary -->
<?php
get_footer();
