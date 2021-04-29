<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

get_header();
?>
	<div id="primary" class="govuk-grid-column-two-thirds">
    <section class="hale-error-404">
      <h1 class="govuk-heading-l">Page not found</h1>
      <p class="govuk-body">
        If you typed the web address, check it is correct.
      </p>
      <p class="govuk-body">
        If you pasted the web address, check you copied the entire address.
      </p>
      <p class="govuk-body">
        Use the search facility below, select an item from the contents or 
        alternatively <a class="govuk-link" href="<?php echo esc_attr( get_home_url() ); ?>">return to the home page</a>.
      </p>
      <?php
        get_search_form();
      ?>
      <div class="govuk-clearfix"></div>
    </section>
		<div class="govuk-grid-column-full ">
			<?php
			dynamic_sidebar( '404-error' );
			?>
		</div>
	</div><!-- #primary -->

<?php
get_footer();
