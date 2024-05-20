<?php
/**
 * Generate breadcrumbs
 *
 * Get path to current page and leave breadcrumb trail for users to navigate back up the decision tree
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/
 *
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0
 */

/**
 *  Create the breadcrumb
 *
 * @param int     $id Post id of the page being queried.
 * @param boolean $link Should current page be linked or not.
 * @param string  $separator Add any fancy separators.
 * @param string  $nicename Clean up the name or not.
 * @param array   $visited Has this page been visited.
 * @param boolean $iscrumb Is this to be added to the breadcrumb.
 * @param boolean $is_hierarchy Is this part of the new hierarchy sidebar.
 *
 * @return array  $chain
 */
function hale_category_parents( $id, $link = false, $separator = '', $nicename = false, $visited = array(), $iscrumb = false, $is_hierarchy = false ) {
	$chain  = '';
	$parent = get_term( $id, 'category' );
	if ( is_wp_error( $parent ) ) {
		return $parent;
	}
	if ( $nicename ) {
		$name = $parent->slug;
	} else {
		$name = $parent->name;
	}
	if ( $parent->parent && ( $parent->parent !== $parent->term_id ) && ! in_array( $parent->parent, $visited, true ) ) {
		$visited[] = $parent->parent;
		$chain    .= get_category_parents( $parent->parent, $link, $separator, $nicename );
	}
	if ($is_hierarchy) {
		$list_class = "hale-side-hierarchy__item hale-side-hierarchy__item--ancestor";
	} else {
		$list_class = "govuk-breadcrumbs__list-item";
	}
	if ( $iscrumb ) {
		$chain .= '<li class="'.$list_class.'"><a class="govuk-breadcrumbs__link" itemprop="item" href="' . esc_url( get_category_link( $parent->term_id ) ) . '">' . $name . '</a></li>' . $separator;
	} elseif ( $link && ! $iscrumb ) {
		$chain .= '<li class="'.$list_class.'"><a class="govuk-breadcrumbs__link" itemprop="item" href="' . esc_url( get_category_link( $parent->term_id ) ) . '">' . $name . '</a>' . $separator . '</li>';
	} else {
		$chain .= '<li class="'.$list_class.'">' . $name . $separator . '</li>';
	}

	return $chain;
}


/**
 * Check to see if LearnDash extension Uncanny Toolkit is running.
 *
 * @return bool
 */
function hale_uncanny_breadcrumb_check() {
	if ( in_array( 'uncanny-learndash-toolkit/uncanny-learndash-toolkit.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
		$uo_active_classes = get_option( 'uncanny_toolkit_active_classes', 0 );
		if ( 0 !== $uo_active_classes ) {
			if ( ! key_exists( 'uncanny_learndash_toolkit\Breadcrumbs', $uo_active_classes ) ) {
				return false; // plugin is active but breadcrumbs aren't turned on.
			}
		}
		$classes = get_body_class();
		$matches = preg_grep( '/sfwd/i', $classes );
		if ( count( $matches ) > 0 ) {
			return true; // this is a LearnDash page, the Uncanny Toolkit is installed and the breadcrumb is active.
		} else {
			return false; // this isn't a Learndash page.
		}
	} else {
		return false; // plugin isn't active.
	}
}

/**
 * Theme specific breadcrumb creation logic.
 */
function hale_breadcrumb() {
	global $wp_query;

    $theme_show_breadcrumb = get_theme_mod('show_breadcrumb', 'yes');

	if ( ! is_home() && $theme_show_breadcrumb == 'yes') {

        $show_page_breadcrumb = 'yes';

        if(is_singular('page')) {
            global $post;

            // Get breadcrumb setting, is it set to display or not
            $show_page_breadcrumb_setting = get_post_meta($post->ID, 'hale_metabox_page_breadcrumb', true);

            if(!empty($show_page_breadcrumb_setting)){
                $show_page_breadcrumb = $show_page_breadcrumb_setting;
            }
        }



		if ( ! is_front_page() &&  $show_page_breadcrumb == 'yes') {
			$back_one_level = array( esc_url( home_url() ), __( 'Home', 'hale' ) );
			?>
			<nav class="govuk-breadcrumbs" aria-label="Breadcrumb">
				<div class="govuk-width-container">
					<?php
					if ( true === hale_uncanny_breadcrumb_check() ) {

						echo esc_html( uo_breadcrumbs() );
						?>

						<p class="hale-width--show-narrow-40 govuk-!-margin-0">
							<a class="govuk-back-link" href="<?php echo esc_url( $back_one_level[0] ); ?>">
								<?php echo esc_html( __( 'Back to ', 'hale' ) ) . esc_html( $back_one_level[1] ); ?>
							</a>
						</p>
						<style>
							.ld-breadcrumbs {
								position: relative;
							}

							.ld-breadcrumbs-segments {
								display: none !important;
							}

							.ld-status {
								position: absolute;
								right: 0;
							}
						</style>
						<?php
					} else {
						?>
						<ol class="govuk-breadcrumbs__list hale-width--hide-narrow-40">
							<li class="govuk-breadcrumbs__list-item">
								<a class="govuk-breadcrumbs__link" href="<?php echo esc_url( home_url() ); ?>">
									<?php echo esc_html( __( 'Home', 'hale' ) ); ?>
								</a>
							</li>
							<?php
							// Check for categories, archives, search page, single posts, pages, the 404 page, and attachments.
							if ( is_post_type_archive('news') ) {
                                ?>
                            <li class="govuk-breadcrumbs__list-item">
                                <?php
                                esc_html_e( 'News', 'hale' );
                                ?>
                            </li>
                            <?php
                            }
                            elseif ( is_category() ) {
								$cat_obj    = $wp_query->get_queried_object();
								$this_cat   = get_category( $cat_obj->term_id );
								$parent_cat = get_category( $this_cat->parent );
								if ( 0 !== $this_cat->parent ) {
									$cat_parents = hale_category_parents( $parent_cat, true, '', false, array(), true );
								}
								if ( 0 !== $this_cat->parent && ! is_wp_error( $cat_parents ) ) {
									echo $cat_parents; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}
								echo '<li class="govuk-breadcrumbs__list-item"><a class="govuk-breadcrumbs__link" href="' . esc_url( get_category_link( $this_cat ) ) . '">' . esc_html( single_cat_title( '', false ) ) . '</a></li>';
							}
                            elseif ( is_tag() ) {
                                $tag_obj    = $wp_query->get_queried_object();

                                ?>
                                <li class="govuk-breadcrumbs__list-item">
                                    #<?php echo $tag_obj->name?>
                                </li>
                                <?php
                            }
							elseif ( is_post_type_archive( 'tribe_events' ) ) {
								?>
								<li class="govuk-breadcrumbs__list-item">
									<?php
									echo esc_html( tribe_get_event_label_plural() );
									?>
								</li>
								<?php
							} elseif ( is_archive() && ! is_category() ) {
								?>
								<li class="govuk-breadcrumbs__list-item">
									<?php
									esc_html_e( 'Archives', 'hale' );
									?>
								</li>
								<?php
							} elseif ( is_search() ) {
								?>
								<li class="govuk-breadcrumbs__list-item">
									<?php
									esc_html_e( 'Search Results', 'hale' );
									?>
								</li>
								<?php
							} elseif ( is_404() ) {
								?>
								<li class="govuk-breadcrumbs__list-item">
									<?php
									esc_html_e( '404 Not Found', 'hale' );
									?>
								</li>
								<?php
							} elseif ( is_singular( 'post' ) ) {
								$category    = get_the_category();
								$category_id = get_cat_ID( $category[0]->cat_name );
								$cat_parents = hale_category_parents( $category_id, true, '', false, array(), true );
								if ( ! is_wp_error( $cat_parents ) ) {
									echo $cat_parents; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}
							} elseif ( is_singular( 'attachment' ) ) {
								?>
								<li class="govuk-breadcrumbs__list-item">
									<?php
									the_title();
									?>
								</li>
								<?php
							} elseif ( is_singular( 'news' ) ) {
                                ?>
                                <li class="govuk-breadcrumbs__list-item">
                                    <a href="<?php echo get_post_type_archive_link('news');?>" class="govuk-breadcrumbs__link">
                                    News
                                    </a>
                                </li>
                                <?php
                            } elseif ( is_singular( 'tribe_events' ) ) {
								?>
								<li class="govuk-breadcrumbs__list-item">
									<a class="govuk-breadcrumbs__link" href="<?php echo esc_url( tribe_get_events_link() ); ?>">
										<?php echo esc_html( tribe_get_event_label_plural() ); ?>
									</a>
								</li>
								<?php
							} elseif ( is_page() ) {
								$post = $wp_query->get_queried_object();
								if ( 0 !== $post->post_parent ) {
									$title     = the_title( '', '', false );
									$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
									array_push( $ancestors, $post->ID );
									$home_page = get_option( 'page_on_front' );
									foreach ( $ancestors as $ancestor ) {
										if ( ( end( $ancestors ) !== $ancestor ) && ( ( $home_page !== $ancestor ) ) ) {
											?>
											<li class="govuk-breadcrumbs__list-item">
												<a class="govuk-breadcrumbs__link" href="<?php echo esc_url( get_permalink( $ancestor ) ); ?>">
													<?php echo esc_html( wp_strip_all_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) ); ?>
												</a>
											</li>
											<?php
											$back_one_level = array(
												esc_url( get_permalink( $ancestor ) ),
												wp_strip_all_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ),
											);
										}
									}
									$parent         = $post->post_parent;
									$back_one_level = array( get_permalink( $parent ), get_the_title( $parent ) );

								}
							}
							if ( ! ( is_archive() || is_category() || is_post_type_archive() || is_search() || is_404() ) ) {

								?>

								<li class="govuk-breadcrumbs__list-item"><?php echo esc_html( the_title() ); ?></li>

							<?php } ?>
						</ol>
						<p class="hale-width--show-narrow-40 govuk-!-margin-0">
                            <?php
                            if ( is_singular( 'news' ) ) { ?>

                            <a class="govuk-back-link" href="<?php echo get_post_type_archive_link('news'); ?>">
                                <?php echo esc_html( __( 'Go back to News', 'hale' ) ); ?>
                            </a>
                            <?php
                            }
                            else { ?>
							<a class="govuk-back-link" href="<?php echo esc_url( $back_one_level[0] ); ?>">
								<?php echo esc_html_e( 'Go back to ', 'hale' ) . esc_html( $back_one_level[1] ); ?>
							</a>
                            <?php } ?>
						</p>
					<?php } // end of LearnDash / Uncanny Toolkit conditional ?>
				</div>
			</nav>
			<?php
		}
	}
}


/**
 * Hierarchy sidebar creation logic.
 */
function hale_hierarchy_sidebar_1() {
	global $wp_query;

	if ( ! is_home() && ! is_front_page() ) {
		$back_one_level = array( esc_url( home_url() ), __( 'Home', 'hale' ) );
		?>
		<nav class="hale-side-hierarchy" aria-label="Breadcrumb">
			<ol>
				<li class="hale-side-hierarchy__item hale-side-hierarchy__item--ancestor">
					<a class="govuk-breadcrumbs__link" href="<?php echo esc_url( home_url() ); ?>">
						<?php echo esc_html( __( 'Home', 'hale' ) ); ?>
					</a>
				</li>
				<?php
				// Check for categories, archives, search page, single posts, pages, the 404 page, and attachments.
				if ( is_post_type_archive('news') ) {
					?>
				<li class="hale-side-hierarchy__item hale-side-hierarchy__item--current">
					<?php
					esc_html_e( 'News', 'hale' );
					?>
				</li>
				<?php
				}
				elseif ( is_category() ) {
					$cat_obj    = $wp_query->get_queried_object();
					$this_cat   = get_category( $cat_obj->term_id );
					$parent_cat = get_category( $this_cat->parent );
					if ( 0 !== $this_cat->parent ) {
						$cat_parents = hale_category_parents( $parent_cat, true, '', false, array(), true, true );
					}
					if ( 0 !== $this_cat->parent && ! is_wp_error( $cat_parents ) ) {
						echo $cat_parents; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					echo '<li class="hale-side-hierarchy__item hale-side-hierarchy__item--current"><a class="govuk-breadcrumbs__link" href="' . esc_url( get_category_link( $this_cat ) ) . '">' . esc_html( single_cat_title( '', false ) ) . '</a></li>';
				}
				elseif ( is_tag() ) {
					$tag_obj    = $wp_query->get_queried_object();

					?>
					<li class="hale-side-hierarchy__item hale-side-hierarchy__item--current">
						#<?php echo $tag_obj->name?>
					</li>
					<?php
				}
				elseif ( is_post_type_archive( 'tribe_events' ) ) {
					?>
					<li class="hale-side-hierarchy__item hale-side-hierarchy__item--current">
						<?php
						echo esc_html( tribe_get_event_label_plural() );
						?>
					</li>
					<?php
				} elseif ( is_archive() && ! is_category() ) {
					?>
					<li class="hale-side-hierarchy__item hale-side-hierarchy__item--current">
						<?php
						esc_html_e( 'Archives', 'hale' );
						?>
					</li>
					<?php
				} elseif ( is_search() ) {
					?>
					<li class="hale-side-hierarchy__item hale-side-hierarchy__item--current">
						<?php
						esc_html_e( 'Search Results', 'hale' );
						?>
					</li>
					<?php
				} elseif ( is_404() ) {
					?>
					<li class="hale-side-hierarchy__item hale-side-hierarchy__item--current">
						<?php
						esc_html_e( '404 Not Found', 'hale' );
						?>
					</li>
					<?php
				} elseif ( is_singular( 'post' ) ) {
					$category    = get_the_category();
					$category_id = get_cat_ID( $category[0]->cat_name );
					$cat_parents = hale_category_parents( $category_id, true, '', false, array(), true, true );
					if ( ! is_wp_error( $cat_parents ) ) {
						echo $cat_parents; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
				} elseif ( is_singular( 'attachment' ) ) {
					?>
					<li class="hale-side-hierarchy__item hale-side-hierarchy__item--ancestor">
						<?php
						the_title();
						?>
					</li>
					<?php
				} elseif ( is_singular( 'news' ) ) {
					?>
					<li class="hale-side-hierarchy__item hale-side-hierarchy__item--ancestor">
						<a href="<?php echo get_post_type_archive_link('news');?>" class="govuk-breadcrumbs__link">
							News
						</a>
					</li>
					<?php
				} elseif ( is_singular( 'tribe_events' ) ) {
					?>
					<li class="hale-side-hierarchy__item hale-side-hierarchy__item--ancestor">
						<a class="govuk-breadcrumbs__link" href="<?php echo esc_url( tribe_get_events_link() ); ?>">
							<?php echo esc_html( tribe_get_event_label_plural() ); ?>
						</a>
					</li>
					<?php
				} elseif ( is_page() ) {
					$post = $wp_query->get_queried_object();
					if ( 0 !== $post->post_parent ) {
						$title     = the_title( '', '', false );
						$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
						array_push( $ancestors, $post->ID );
						$home_page = get_option( 'page_on_front' );
						foreach ( $ancestors as $ancestor ) {
							if ( ( end( $ancestors ) !== $ancestor ) && ( ( $home_page !== $ancestor ) ) ) {
								?>
								<li class="hale-side-hierarchy__item hale-side-hierarchy__item--ancestor">
									<a class="govuk-breadcrumbs__link" href="<?php echo esc_url( get_permalink( $ancestor ) ); ?>">
										<?php echo esc_html( wp_strip_all_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) ); ?>
									</a>
								</li>
								<?php
								$back_one_level = array(
									esc_url( get_permalink( $ancestor ) ),
									wp_strip_all_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ),
								);
							}
						}
						$parent         = $post->post_parent;
						$back_one_level = array( get_permalink( $parent ), get_the_title( $parent ) );

					}
				}
				if ( ! ( is_archive() || is_category() || is_post_type_archive() || is_search() || is_404() ) ) {

					?>

					<li class="hale-side-hierarchy__item hale-side-hierarchy__item--current"><span id="this-page"><?php echo esc_html( the_title() ); ?></span></li>

				<?php 

					$child_pages = get_children( array( 'post_parent' => get_the_ID() ) );

					if( !empty( $child_pages ) ) {
						foreach ( $child_pages as $child ) {
							if (get_post_type($child->ID) == "page") {
								echo '<li class="hale-side-hierarchy__item hale-side-hierarchy__item--descendant"><a class="govuk-breadcrumbs__link" href="' . esc_url( get_permalink( $child->ID )) . '">' . $child->post_title . '</a></li>';
							}
						}
					}
				} 
				?>
			</ol>
		</nav>
		<?php
	}
}


function hale_hierarchy_sidebar_2() {
	$home_page = get_option('page_on_front');
	echo "<nav class='hale-side-hierarchy hale-side-hierarchy--wp-list'>";
	echo "<ol class='hale-side-hierarchy__top-list'>";
	echo '<li class="page_item"><a href="'.esc_url( home_url() ).'">'.esc_html( __( 'Home', 'hale' ) ).'</a></li>';
	wp_list_pages(
		[
			"title_li"=> '',
			"exclude"=>$home_page,
			"link_before"=> '<span>',
			"link_after"=> '</span>',
		]
	);
	echo "</ol></nav>";
}

function hale_hierarchy_sidebar_3() {
	$current_id = get_the_id();
	$ancestors = get_post_ancestors($current_id);
	$home_page = get_option('page_on_front');
	echo "<nav class='hale-side-hierarchy'><ol>";
	echo "<li class='hale-side-hierarchy__item hale-side-hierarchy__item--ancestor'>
			<a class='govuk-breadcrumbs__link' href='".esc_url(home_url())."'>".esc_html( __( 'Home', 'hale' ) )."</a>
		</li>";
	$pages = get_pages($home_page);
	foreach ($pages as $page) {
		
		$current_page = false;
		$title = $page->post_title;
		$id = $page->ID;
		if ($id == $home_page) continue;
		$parent = $page->post_parent;
		$link = esc_url(get_permalink($id));
		$class="hale-side-hierarchy__item--nothing";
		if (!empty($ancestors) && $ancestors[0] == $parent) $class = " hale-side-hierarchy__item--sibling"; // the page shares a parent with the current page
		if (empty($ancestors) && !$parent) $class = " hale-side-hierarchy__item--sibling"; // the page's parent is 0 and there are no ancestors to the current page'
		if (!empty($ancestors) && in_array($id,$ancestors)) $class = " hale-side-hierarchy__item--ancestor";
		if ($parent == $current_id) $class = " hale-side-hierarchy__item--descendant";
		if ($current_id == $id) {
			$current_page = true;
			$class = " hale-side-hierarchy__item--current";
		}
		echo "<li class='hale-side-hierarchy__item $class'>";
		if (!$current_page) echo "<a class='govuk-breadcrumbs__link' itemprop='item' href='$link'>";
		echo $title;
		if (!$current_page) echo "</a>";
		echo "</li>";
	}
	echo "</ol></nav>";
}

function hale_hierarchy() {
	if ( ! is_home() && ! is_front_page() ) {
		$theme_show_breadcrumb = get_theme_mod('show_breadcrumb', 'yes');
		if ($theme_show_breadcrumb == "side1" || $theme_show_breadcrumb == "side2" || $theme_show_breadcrumb == "side3") {
			echo '
			<div class="govuk-grid-column-one-quarter-from-desktop hale-side-nav">
			<button type="button" id="side-nav-button" class="hale-side-nav__expand-control govuk-!-font-size-27" aria-expanded="false" aria-label="Open and close hierarchy navigation">'
			.__("Hierarchy","hale")
			.'</button>';
			if ($theme_show_breadcrumb == "side1") {
				hale_hierarchy_sidebar_1();
			} elseif ($theme_show_breadcrumb == "side2") {
				hale_hierarchy_sidebar_2();
			} elseif ($theme_show_breadcrumb == "side3") {
				hale_hierarchy_sidebar_3();
			}
			echo'</div>';
			return true;
		}
	}
	return false;
}
