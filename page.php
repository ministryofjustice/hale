<?php

/**
 * Default template
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

$is_cat_page = false;

get_header();

flush();

$main_lang = get_blog_option(get_current_blog_id(), 'WPLANG');

$GLOBALS['page_language'] = $lang_attr = "";
$custom_lang_code = trim(esc_html(get_post_meta($post->ID, 'page_custom_language_code', true)));
if (!empty($custom_lang_code) && strpos($main_lang, $custom_lang_code) === false && strlen($custom_lang_code) <= 12) {
    /**
     * If: custom language code is set, and it is not the same as the language for the main page
     * We ignore it if it is longer than 12 chars (longest we'll find is something like zh-Hant-HK, but in reality, es-419 is likely the longest - Spanish in Latin America)
     * We should encourage 2 letter codes, but not exclude the longer ones.
     */
    $GLOBALS['page_language'] = $custom_lang_code;
    $lang_attr = "lang='$custom_lang_code'";
}

while (have_posts()) :
    the_post();
    ?>

<div <?php echo $lang_attr;?> id="primary" class="govuk-grid-column-two-thirds">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    $show_title_section = get_post_meta($post->ID, 'hale_metabox_page_title_section', true);

    if (empty($show_title_section)) {
        $show_title_section = 'yes';
    }

    if(is_front_page() === false && $show_title_section == 'yes') { ?>

        <div class="page-header-section">

            <?php

        /**
         * Category page list section
         * This loads the category list section if cat metabox is checked
         *
         * */
        include(locate_template('partials/category-list-section.php', false, false));



         // Header loads if category not selected on page
                if (empty($is_cat_page)) { ?>
                 <h1 class="govuk-heading-xl govuk-!-static-margin-bottom-6"><?php the_title(); ?></h1>
             <?php
                }

        ?>
        </div>
    <?php
    } elseif (is_front_page()) {
        // If we are on a landing page, we need to check that an H1 is present.
        // If one is not present, we need to add in a hidden one.
        if (strpos(get_the_content(),"<h1") === false) {
            $hidden_title = get_bloginfo("name")." &ndash; ".__("Homepage","hale");
            echo "<h1 class='govuk-visually-hidden'>$hidden_title</h1>";
        }
    }
    ?>
      <div class=" <?php echo hale_sidebar_location('sidebar-1'); ?>">

        <?php

        // Page title if category selected on page
        if (is_front_page() === false) {
            if (!empty($is_cat_page)) {

            // Add special heading CSS class depending on if category menu is activated
            $hale_heading_class = $is_cat_page ? ' govuk-heading-l' : '';

                echo '<h1 class="entry-title' . $hale_heading_class . '">' . get_the_title() . '</h1>';
            }
        }

        // Page excerpt
        if (has_excerpt()) {
            echo '<div class="intro">' . get_the_excerpt() . '</div>';
        }

        // Page body content
        get_template_part('template-parts/content', 'page');

        // Page previous/next tabs
        include(locate_template('partials/next-previous-tabs.php', false, false));
        ?>
        </div>

    </article><!-- #post-<?php the_ID(); ?> -->
</div><!-- #primary -->
<div class="govuk-grid-column-one-third">
    <?php
    /**
     * Load page sidebar
     *
     * */
    get_sidebar('page');

    ?>
</div>
<?php endwhile;

flush();

get_footer();
