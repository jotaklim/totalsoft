<?php
//----------category---------------
function category_has_children( $term_id = 0, $taxonomy = 'category' ) {
    $children = get_categories( array( 'child_of' => $term_id, 'taxonomy' => $taxonomy ) );
    return ( $children );
}
//------------Allow svg-------------
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
//------------End Allow svg-------------

//------------Register menu--------------
function register_menu() {
    register_nav_menu('primary-menu', __('Primary Menu'));
}
add_action('init', 'register_menu');
//------------End Register menu--------------

//------------Post thumbnails-------------
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 795, 460 );

if ( function_exists( 'add_theme_support' ) ) {

    set_post_thumbnail_size(795, 460);
    add_image_size('thumb-big', 795, 460, true);

}
//------------End Post thumbnails-------------


//----------Theme Options---------------
function theme_settings_page()
{
    ?>

    <div class="wrap">
        <h1>Theme Settings</h1>

        <form method="post" action="options.php">
            <?php
            settings_fields("section");
            do_settings_sections("theme-options");
            submit_button();
            ?>
        </form>
    </div>

    <?php
}

function add_theme_menu_item()
{
    add_menu_page("Theme Settings", "Theme Settings", "manage_options", "theme-settings", "theme_settings_page", null, 99);
}

add_action("admin_menu", "add_theme_menu_item");

function display_social_accounts()
{
    ?>
    <input class="admin-inp" type="text" name="linkedin" id="linkedin" placeholder="LinkedIn"
           value="<?php echo get_option('linkedin'); ?>"/>
<!--    <input class="admin-inp" type="text" name="gp" id="gp" placeholder="Google"-->
<!--           value="--><?php //echo get_option('gp'); ?><!--"/>-->
<!--    <input class="admin-inp" type="text" name="inst" id="inst" placeholder="Instagram"-->
<!--           value="--><?php //echo get_option('inst'); ?><!--"/>-->
<!--    <input class="admin-inp" type="text" name="tw" id="tw" placeholder="Twitter"-->
<!--           value="--><?php //echo get_option('tw'); ?><!--"/>-->
<!--    <input class="admin-inp" type="text" name="yt" id="yt" placeholder="Youtube"-->
<!--           value="--><?php //echo get_option('yt'); ?><!--"/>-->
    <?php
}

function display_theme_panel_fields()
{
    add_settings_section("section", "All Settings", null, "theme-options");

    add_settings_field("socialAccounts", "Social Accounts", "display_social_accounts", "theme-options", "section");

//    register_setting("section", "fb");
//    register_setting("section", "gp");
//    register_setting("section", "inst");
//    register_setting("section", "tw");
//    register_setting("section", "yt");
    register_setting("section", "linkedin");
}

add_action("admin_init", "display_theme_panel_fields");

function display_phone_number()
{
    ?>
    <input class="admin-inp" type="text" name="phonenum_head" id="phonenum_head" placeholder="Phone number"
           value="<?php echo get_option('phonenum_head'); ?>"/>
    <?php
}
function display_theme_panel_fields2()
{
    add_settings_section("section", "All Settings", null, "theme-options");

    add_settings_field("phoneNumber", "Phone number in header", "display_phone_number", "theme-options", "section");

    register_setting("section", "phonenum_head");
}

add_action("admin_init", "display_theme_panel_fields2");

function display_home_hero()
{
    ?>
    <input class="admin-inp" type="text" name="home_hero" id="home_hero" placeholder="/wp-content/uploads/2017/07/hero_image.jpg"
           value="<?php echo get_option('home_hero'); ?>"/>
    <?php
}

function display_theme_panel_fields3()
{
    add_settings_section("section", "All Settings", null, "theme-options");

    add_settings_field("home_hero", "Home hero image", "display_home_hero", "theme-options", "section");

    register_setting("section", "home_hero");
}

add_action("admin_init", "display_theme_panel_fields3");
//----------End Theme Options---------------

//---------Admin styles-------------
add_action('admin_enqueue_scripts', 'load_admin_style');
function load_admin_style()
{
    wp_enqueue_style('thickbox');
    wp_register_style('admin_css', get_template_directory_uri() . '/assets/css/admin-style.css', false, '1.0.0');
    wp_enqueue_style('admin_css', get_template_directory_uri() . '/assets/css/admin-style.css', false, '1.0.0');
}

add_action('admin_enqueue_scripts', 'load_admin_scripts');
function load_admin_scripts()
{
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('my-upload', get_template_directory_uri() . '/assets/js/admin-script.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_script('my-upload');
}

//---------End Admin styles-------------

//--------Post excerpt---------------
function new_excerpt_length()
{
    return 27;
}

add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($more)
{
    return ' ...';
}

add_filter('excerpt_more', 'new_excerpt_more');
//--------End Post excerpt---------------

//----------Custom single gallery----------

add_filter('post_gallery','customFormatGallery',10,2);

function customFormatGallery($string,$attr){
    $date = get_the_date('dmy');
    $date = $date.rand();

    $output = '<div id="'.$date.'" class="single-gallery-wrap">';
    $posts = get_posts(array('include' => $attr['ids'],'post_type' => 'attachment'));

    $output .= '<div class="photo-slider-aside-nav slick_aside_nav"><div class="slick-aside-inner slick_aside_inner">';
    foreach($posts as $imagePost) {
        $imgUrl = wp_get_attachment_image_src($imagePost->ID);
        $output .= '<div  class="pp-aside-thumb aside_thumb" style="background-image: url(' . $imgUrl[0] . ');"></div>';
    }

    $output .= "</div></div>";

    $output .= '<div class="single-gallery-inner slick_slider_inner">';

    foreach($posts as $imagePost){
        $imgUrl = wp_get_attachment_image_src($imagePost->ID, 'full');
        $caption = $imagePost->post_excerpt;
        $output .= '<div class="sg-item"><img src="'.$imgUrl[0].'" alt="">';
        if(!empty($caption)){
            $output .= '<div class="slide-caption">'.$caption.'</div>';
        }
        $output .= '</div>';
    }
    $output .= "</div>";


    $output .= "</div>";

    return $output;
}
//----------end Custom single gallery----------

// Custom post type function
function create_posttype() {

    register_post_type( 'partners',
        // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Partners' ),
                'singular_name' => __( 'Partner' )
            ),
            'public' => true,
            'has_archive' => true,
            'supports'            => array( 'title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'partners'),
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );



/* Basic WP SEO
	Usage:
		1. add this code to functions.php
		2. replace the $default_keywords with your own
		3. add <?php echo basic_wp_seo(); ?> to header.php
		4. test well and fine tune as needed

	Optional: add custom description, keywords, and/or title
	to any post or page using these custom field keys:

		mm_seo_desc
		mm_seo_keywords
		mm_seo_title

	To migrate from any SEO plugin, replace its custom field
	keys with those listed above. More information:

		@ https://digwp.com/2013/08/basic-wp-seo/
*/
function basic_wp_seo() {
    global $page, $paged, $post;
    $default_keywords = 'POS, web POS, business intelligence software, bi implementation, microsoft bi consulting, power bi implementation, dynamics consulting, ms dynamics implementation, ms dynamics customization, microsoft bi partner, microsoft crm partner, microsoft partner, microsoft partner vienna, microsoft partner kiev, microsoft partner bucharest, dynamics partner vienna, dynamics partner kiev, dynamics partner bucharest, business software, accounting software, erp implementation, charisma erp, totalsoft austria, totalsoft charisma'; // customize
    $output = '';

    // description
    $seo_desc = get_post_meta($post->ID, 'mm_seo_desc', true);
    $description = get_bloginfo('description', 'display');
    $pagedata = get_post($post->ID);
    if (is_singular()) {
        if (!empty($seo_desc)) {
            $content = $seo_desc;
        } else if (!empty($pagedata)) {
            $content = apply_filters('the_excerpt_rss', $pagedata->post_content);
            $content = substr(trim(strip_tags($content)), 0, 155);
            $content = preg_replace('#\n#', ' ', $content);
            $content = preg_replace('#\s{2,}#', ' ', $content);
            $content = trim($content);
        }
    } else {
        $content = $description;
    }
    $output .= '<meta name="description" content="' . esc_attr($content) . '">' . "\n";

    // keywords
    $keys = get_post_meta($post->ID, 'mm_seo_keywords', true);
    $cats = get_the_category();
    $tags = get_the_tags();
    if (empty($keys)) {
        if (!empty($cats)) foreach($cats as $cat) $keys .= $cat->name . ', ';
        if (!empty($tags)) foreach($tags as $tag) $keys .= $tag->name . ', ';
        $keys .= $default_keywords;
    }
    $output .= "\t\t" . '<meta name="keywords" content="' . esc_attr($keys) . '">' . "\n";

    // robots
    if (is_category() || is_tag()) {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        if ($paged > 1) {
            $output .=  "\t\t" . '<meta name="robots" content="noindex,follow">' . "\n";
        } else {
            $output .=  "\t\t" . '<meta name="robots" content="index,follow">' . "\n";
        }
    } else if (is_home() || is_singular()) {
        $output .=  "\t\t" . '<meta name="robots" content="index,follow">' . "\n";
    } else {
        $output .= "\t\t" . '<meta name="robots" content="noindex,follow">' . "\n";
    }

    // title
    $title_custom = get_post_meta($post->ID, 'mm_seo_title', true);
    $url = ltrim(esc_url($_SERVER['REQUEST_URI']), '/');
    $name = get_bloginfo('name', 'display');
    $title = trim(wp_title('', false));
    $cat = single_cat_title('', false);
    $tag = single_tag_title('', false);
    $search = get_search_query();

    if (!empty($title_custom)) $title = $title_custom;
    if ($paged >= 2 || $page >= 2) $page_number = ' | ' . sprintf('Page %s', max($paged, $page));
    else $page_number = '';

    if (is_home() || is_front_page()) $seo_title = $name . ' | ' . $description;
    elseif (is_singular())            $seo_title = $title . ' | ' . $name;
    elseif (is_tag())                 $seo_title = 'Tag Archive: ' . $tag . ' | ' . $name;
    elseif (is_category())            $seo_title = 'Category Archive: ' . $cat . ' | ' . $name;
    elseif (is_archive())             $seo_title = 'Archive: ' . $title . ' | ' . $name;
    elseif (is_search())              $seo_title = 'Search: ' . $search . ' | ' . $name;
    elseif (is_404())                 $seo_title = '404 - Not Found: ' . $url . ' | ' . $name;
    else                              $seo_title = $name . ' | ' . $description;

    $output .= "\t\t" . '<title>' . esc_attr($seo_title . $page_number) . '</title>' . "\n";

    return $output;
}



?>