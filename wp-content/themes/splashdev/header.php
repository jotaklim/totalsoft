<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
<!---->
<!--    --><?php
//    $blog_title = get_bloginfo('name');
//        if (is_home()) {
//            $blog_title = get_bloginfo('name') . " | " . get_bloginfo('description');
//        }
//        if (is_single()) {
//            $blog_title = get_the_title() . " | " . get_bloginfo('name');
//        }
//        if (is_tag()) {
//            $blog_title = single_tag_title("",false) . " | " . get_bloginfo('name');
//        }
//        if (is_category()) {
//            $blog_title = single_cat_title("",false) . " | " . get_bloginfo('name');
//        }
//        if (is_page()) {
//            $blog_title = the_title();
//        }
//
//    ?>

<!--    <title>--><?php //echo $blog_title; ?><!--</title>-->
    <?php echo basic_wp_seo(); ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MX3VRTG');</script>
    <!-- End Google Tag Manager -->
    <link href="https://fonts.googleapis.com/css?family=Signika:300,400,600,700|Slabo+27px|Roboto:300,400,500,700&amp;subset=cyrillic" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/style.css">
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/css/style.css?v=1">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MX3VRTG"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>





