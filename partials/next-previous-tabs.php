<?php

/**
 * Next/Previous tabs based off of category
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hale
 * @copyright Ministry Of Justice
 * @version 2.0
 */

// Requires category-nav.php to be loaded first to set $prev_page and $next_page vars

if ($is_cat_page && (!empty($prev_page) || !empty($next_page))) { ?>
    <nav role="navigation" aria-label="Pagination" class="gem-c-pagination

    <?php if (!empty($prev_page)) {
        echo 'has-prev-page';
    }

    if (!empty($next_page)) {
        echo 'has-next-page';
    } ?>">
      <ul class="gem-c-pagination__list">
        <?php
				if (!empty($prev_page)) {
						?>
						<li class="gem-c-pagination__item gem-c-pagination__item--previous">
							<a href="<?php echo get_permalink($prev_page->ID); ?>" class="gem-c-pagination__link hale-article-nav hale-article-nav--previous" rel="prev">
								<span class="gem-c-pagination__link-title">
									<svg class="gem-c-pagination__link-icon" xmlns="http://www.w3.org/2000/svg" height="13" width="17" viewBox="0 0 17 13">
										<path d="m6.5938-0.0078125-6.7266 6.7266 6.7441 6.4062 1.377-1.449-4.1856-3.9768h12.896v-2h-12.984l4.2931-4.293-1.414-1.414z"></path>
									</svg>
									<span class="gem-c-pagination__link-text">
										Previous
									</span>
								</span>
								<span class="gem-c-pagination__link-divider govuk-visually-hidden">:</span>
								<span class="gem-c-pagination__link-label">
									<?php echo $prev_page->post_title; ?>
								</span>
							</a>
						</li>
						<?php
				}

				if (!empty($next_page)) {
						?>
						<li class="gem-c-pagination__item gem-c-pagination__item--next">
							<a href="<?php echo get_permalink($next_page->ID); ?>" class="gem-c-pagination__link hale-article-nav hale-article-nav--next" rel="next">
								<span class="gem-c-pagination__link-title">
									<svg class="gem-c-pagination__link-icon" xmlns="http://www.w3.org/2000/svg" height="13" width="17" viewBox="0 0 17 13">
										<path d="m10.107-0.0078125-1.4136 1.414 4.2926 4.293h-12.986v2h12.896l-4.1855 3.9766 1.377 1.4492 6.7441-6.4062-6.7246-6.7266z"></path>
									</svg>
									<span class="gem-c-pagination__link-text">
										Next
									</span>
								</span>
								<span class="gem-c-pagination__link-divider govuk-visually-hidden">:</span>
								<span class="gem-c-pagination__link-label">
									<?php echo $next_page->post_title; ?>
								</span>
							</a>
						</li>
						<?php
				}
				?>
			</ul>
    </nav>
    <?php
}

