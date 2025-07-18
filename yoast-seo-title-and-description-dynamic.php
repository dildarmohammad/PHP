<!--Yoast SEO Title and description dynamic-->
<?php
global $post;

if (defined('WPSEO_VERSION') && class_exists('WPSEO_Frontend')) {
    $yoast = WPSEO_Frontend::get_instance();
    $yoast_title = $yoast->title('', false);
    $yoast_description = $yoast->metadesc();

    echo '<title>' . esc_html($yoast_title) . '</title>' . "\n";

    if (!$yoast_description) {
        $yoast_description = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);
    }

    if (!$yoast_description) {
        $yoast_description = get_the_excerpt();
    }

    echo '<meta name="description" content="' . esc_attr($yoast_description) . '">';
}
?>
<!--End Yoast SEO Title and description dynamic-->
