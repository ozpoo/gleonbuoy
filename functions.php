<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

if (function_exists('add_theme_support')) {
    add_theme_support('menus');

    add_theme_support('post-thumbnails');
    add_image_size('x-large', 2400, '', true);
    add_image_size('large', 1200, '', true);
    add_image_size('medium', 800, '', true);
    add_image_size('small', 600, '', true);
    add_image_size('micro', 300, '', true);
    add_image_size('tile', 512, 512, true);
    add_image_size('holder', 2, '', true);

    add_theme_support('automatic-feed-links');
    load_theme_textdomain('oz', get_template_directory() . '/languages');
}

function header_scripts() {
  if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
    wp_register_script('js-cookie',
      get_template_directory_uri() . '/assets/js/_lib/js-cookie/js.cookie.js',
      array(), '1.0.0');
    wp_enqueue_script('js-cookie');

    wp_register_script('tinycolor',
      get_template_directory_uri() . '/assets/js/_lib/tinycolor2/dist/tinycolor-min.js',
      array(), '1.0.0');
    wp_enqueue_script('tinycolor');

    wp_register_script('fontawesome',
      get_template_directory_uri() . '/assets/font/Font Awesome/svg-with-js/js/fontawesome-all.min.js',
      array('jquery'), '1.0.0');
    wp_enqueue_script('fontawesome');

    wp_register_script('script',
      get_template_directory_uri() . '/assets/js/build/build.js?v='.time(),
      array('jquery'), '1.0.0');
    wp_enqueue_script('script');
  }
}

function conditional_scripts() {
  if(is_page("intro")) {
		wp_register_script('three',
			get_template_directory_uri() . '/assets/js/_lib/three/build/three.min.js',
			array('jquery'), '1.0.0');
		wp_enqueue_script('three');

    wp_register_script('OrbitControls',
      get_template_directory_uri() . '/assets/js/_lib/three/examples/js/controls/OrbitControls.js',
      array('jquery'), '1.0.0');
    wp_enqueue_script('OrbitControls');

    wp_register_script('OceanShaders',
      get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/OceanShaders.js',
      array('jquery'), '1.0.0');
    wp_enqueue_script('OceanShaders');

    wp_register_script('Ocean',
      get_template_directory_uri() . '/assets/js/_lib/three/examples/js/Ocean.js',
      array('jquery'), '1.0.0');
    wp_enqueue_script('Ocean');

    // wp_register_script('BleachBypassShader',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/BleachBypassShader.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('BleachBypassShader');
    //
    // wp_register_script('ColorifyShader',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/ColorifyShader.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('ColorifyShader');
    //
    // wp_register_script('ConvolutionShader',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/ConvolutionShader.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('ConvolutionShader');
    //
    // wp_register_script('CopyShader',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/CopyShader.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('CopyShader');
    //
    // wp_register_script('DotScreenShader',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/DotScreenShader.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('DotScreenShader');
    //
    // wp_register_script('FilmShader',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/FilmShader.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('FilmShader');
    //
    // wp_register_script('HorizontalBlurShader',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/HorizontalBlurShader.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('HorizontalBlurShader');
    //
    // wp_register_script('SepiaShader',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/SepiaShader.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('SepiaShader');
    //
    // wp_register_script('VerticalBlurShader',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/VerticalBlurShader.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('VerticalBlurShader');
    //
    // wp_register_script('VignetteShader',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/VignetteShader.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('VignetteShader');
    //
    // wp_register_script('EffectComposer',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/EffectComposer.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('EffectComposer');
    //
    // wp_register_script('RenderPass',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/RenderPass.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('RenderPass');
    //
    // wp_register_script('BloomPass',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/BloomPass.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('BloomPass');
    //
    // wp_register_script('FilmPass',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/FilmPass.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('FilmPass');
    //
    // wp_register_script('DotScreenPass',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/DotScreenPass.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('DotScreenPass');
    //
    // wp_register_script('TexturePass',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/TexturePass.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('TexturePass');
    //
    // wp_register_script('ShaderPass',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/ShaderPass.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('ShaderPass');
    //
    // wp_register_script('MaskPass',
    //   get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/MaskPass.js',
    //   array('jquery'), '1.0.0');
    // wp_enqueue_script('MaskPass');

  } elseif ( is_single() || is_page("grid") ) {
		$library = get_field("library")[0];
		if($library == "p5.js") {
			wp_register_script('p5',
				get_template_directory_uri() . '/assets/js/_lib/p5/p5.min.js',
				array('jquery'), '1.0.0');
			wp_enqueue_script('p5');
		} else if($library == "processing.js") {
			wp_register_script('processing',
				get_template_directory_uri() . '/assets/js/_lib/processing/processing.min.js',
				array('jquery'), '1.0.0');
			wp_enqueue_script('processing');
		} else if($library == "three.js" || is_page("grid")) {
			wp_register_script('detector',
				get_template_directory_uri() . '/assets/js/_lib/three/examples/js/Detector.js',
				array('jquery'), '1.0.0');
			wp_enqueue_script('detector');

			wp_register_script('three',
				get_template_directory_uri() . '/assets/js/_lib/three/build/three.min.js',
				array('jquery'), '1.0.0');
			wp_enqueue_script('three');

      wp_register_script('OrbitControls',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/controls/OrbitControls.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('OrbitControls');

      wp_register_script('OceanShaders',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/OceanShaders.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('OceanShaders');

      wp_register_script('Ocean',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/Ocean.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('Ocean');

			wp_register_script('d3',
				'https://d3js.org/d3.v4.min.js',
				array('jquery'), '1.0.0');
			wp_enqueue_script('d3');

      wp_register_script('BleachBypassShader',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/BleachBypassShader.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('BleachBypassShader');

      wp_register_script('ColorifyShader',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/ColorifyShader.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('ColorifyShader');

      wp_register_script('ConvolutionShader',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/ConvolutionShader.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('ConvolutionShader');

      wp_register_script('CopyShader',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/CopyShader.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('CopyShader');

      wp_register_script('DotScreenShader',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/DotScreenShader.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('DotScreenShader');

      wp_register_script('FilmShader',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/FilmShader.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('FilmShader');

      wp_register_script('HorizontalBlurShader',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/HorizontalBlurShader.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('HorizontalBlurShader');

      wp_register_script('SepiaShader',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/SepiaShader.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('SepiaShader');

      wp_register_script('VerticalBlurShader',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/VerticalBlurShader.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('VerticalBlurShader');

      wp_register_script('VignetteShader',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/shaders/VignetteShader.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('VignetteShader');

      wp_register_script('EffectComposer',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/EffectComposer.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('EffectComposer');

      wp_register_script('RenderPass',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/RenderPass.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('RenderPass');

      wp_register_script('BloomPass',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/BloomPass.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('BloomPass');

      wp_register_script('FilmPass',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/FilmPass.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('FilmPass');

      wp_register_script('DotScreenPass',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/DotScreenPass.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('DotScreenPass');

      wp_register_script('TexturePass',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/TexturePass.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('TexturePass');

      wp_register_script('ShaderPass',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/ShaderPass.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('ShaderPass');

      wp_register_script('MaskPass',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/postprocessing/MaskPass.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('MaskPass');

      wp_register_script('AnaglyphEffect',
        get_template_directory_uri() . '/assets/js/_lib/three/examples/js/effects/AnaglyphEffect.js',
        array('jquery'), '1.0.0');
      wp_enqueue_script('AnaglyphEffect');
		}

    $url = get_template_directory_uri() . "/assets/data/GLEON_XML/split_files/GLEON-2-1.xml";
    $xml = simplexml_load_file($url);
    $xml = json_encode($xml, JSON_PRETTY_PRINT);
    wp_localize_script( 'script', 'GLEON_DATA', $xml );
  }
}

function xml2array ( $xmlObject, $out = array () ){
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}

function styles() {
  wp_register_style('Space Mono',
    get_template_directory_uri() . '/assets/font/Space Mono Web/stylesheet.css',
    array(), '1.0', 'all');
  wp_enqueue_style('Space Mono');

  wp_register_style('Sofia Pro',
    get_template_directory_uri() . '/assets/font/Sofia Pro/stylesheet.css',
    array(), '1.0', 'all');
  wp_enqueue_style('Sofia Pro');

  wp_register_style('Alpha',
    get_template_directory_uri() . '/assets/font/Alpha Headline/stylesheet.css',
    array(), '1.0', 'all');
  wp_enqueue_style('Alpha');

  wp_register_style('style',
    get_template_directory_uri() . '/assets/css/build/build.css?v='.time(),
    array(), '1.0', 'all');
  wp_enqueue_style('style');
}

function my_wp_nav_menu_args($args = '') {
    $args['container'] = false;
    return $args;
}

function my_css_attributes_filter($var) {
    return is_array($var) ? array() : '';
}

function remove_category_rel_from_category_list($thelist) {
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

function add_slug_to_body_class($classes) {
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

function remove_admin_bar() {
    return false;
}

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

add_action('init', 'header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'conditional_scripts'); // Add Conditional Page Scripts
add_action('wp_enqueue_scripts', 'styles'); // Add Theme Stylesheet
add_action('init', 'pagination'); // Add our HTML5 Pagination

remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

function fb_unautop_4_img( $content ) {
  $content = preg_replace(
    '/<p>\\s*?(<a rel=\"attachment.*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s',
    '<figure>$1</figure>',
    $content
  );
  return $content;
}
add_filter( 'the_content', 'fb_unautop_4_img', 99 );

function alx_embed_html( $html ) {
    return '<figure>' . $html . '</figure>';
}
add_filter( 'embed_oembed_html', 'alx_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'alx_embed_html' );

function wp_rest_api_alter() {
  register_api_field( 'selfies', 'fields',
    array(
      'get_callback'    => function($data, $field, $request, $type){
        if (function_exists('get_fields')) {
          return get_fields($data['id']);
        }
        return [];
      },
      'update_callback' => null,
      'schema'          => null,
    )
  );
}
add_action( 'rest_api_init', 'wp_rest_api_alter');

function wp_api_add_tax($post, $data, $update){
    foreach( $data['cat_selfies'] as $tax => $val ){
        wp_set_object_terms( $post['ID'], $data['cat_selfies'], 'cat_selfies' );
    }
}
add_filter('json_insert_post', 'wp_api_add_tax', 10, 3);

function my_js_variables(){ ?>
    <script type="text/javascript">
      var canvas;
      var canvasWidth = 960;
      var canvasHeight = 720;
    </script><?php
}
add_action ( 'wp_head', 'my_js_variables' );

function my_modify_main_query( $query ) {
  if ( $query->is_home() && $query->is_main_query() ) {
    $query->query_vars['orderby'] = 'title';
    $query->query_vars['order'] = 'ASC';
    $query->query_vars['posts_per_page'] = -1;
  }
}
add_action( 'pre_get_posts', 'my_modify_main_query' );

function add_slug_body_class( $classes ) {
  global $post;
  if ( isset( $post ) ) {
    if(is_home()) {
      $classes[] = 'list';
    } else {
      $classes[] = $post->post_type . '-' . $post->post_name;
    }

  }
  return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );
?>
