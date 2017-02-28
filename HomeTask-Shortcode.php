<?php

/*
Plugin Name: HomeTask-ShortCode
Plugin URI: 
Description: HometaskShortCode
Version: 1.0
Author: babychroman
Domain Path: /languages/

*/
require_once plugin_dir_path(__FILE__) . '/config-path.php';
require_once HOMETASKSHORTCODE_PlUGIN_DIR.'/includes/common/HomeTaskAutoload.php';
require_once HOMETASKSHORTCODE_PlUGIN_DIR.'/includes/HomeTaskPlugin.php';
   

   function hometask_shortcode( $atts ) {

  $atts = shortcode_atts(
    array(
      'address'           => false,
      'width'             => '100%',
      'height'            => '400px',
      'enablescrollwheel' => 'true',
      'zoom'              => 15,
      'disablecontrols'   => 'false',
      'key'               => 'AIzaSyBXctG_Vi99XjBqKc1oOWEXNPtaFoQo2hs'
    ),
    $atts
  );

  $address = $atts['address'];

  wp_enqueue_script( 'google-maps-api', '//maps.google.com/maps/api/js?key=' . sanitize_text_field( $atts['key'] ) );

  if( $address  ) :

    wp_print_scripts( 'google-maps-api' );

    $coordinates = home_map_get_coordinates( $address );

    if( !is_array( $coordinates ) )
      return;

    $map_id = uniqid( 'home_map_' ); 

    ob_start(); ?>
    <div class="home_map_canvas" id="<?php echo esc_attr( $map_id ); ?>" style="height: <?php echo esc_attr( $atts['height'] ); ?>; width: <?php echo esc_attr( $atts['width'] ); ?>"></div>
    <script type="text/javascript">

      var map_<?php echo $map_id; ?>;
      function home_run_map_<?php echo $map_id ; ?>(){
        var location = new google.maps.LatLng("<?php echo $coordinates['lat']; ?>", "<?php echo $coordinates['lng']; ?>");
        var map_options = {
          zoom: <?php echo $atts['zoom']; ?>,
          center: location,
          scrollwheel: <?php echo 'true' === strtolower( $atts['enablescrollwheel'] ) ? '1' : '0'; ?>,
          disableDefaultUI: <?php echo 'true' === strtolower( $atts['disablecontrols'] ) ? '1' : '0'; ?>,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map_<?php echo $map_id ; ?> = new google.maps.Map(document.getElementById("<?php echo $map_id ; ?>"), map_options);
        var marker = new google.maps.Marker({
        position: location,
        map: map_<?php echo $map_id ; ?>
        });
      }
      home_run_map_<?php echo $map_id ; ?>();
    </script>
    <?php
    return ob_get_clean();
  else :
    return __( 'Map cannot be loaded because the maps API does not appear to be loaded', 'HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN' );
  endif;
}
add_shortcode( 'home_map', 'hometask_shortcode' );



function home_map_get_coordinates( $address, $force_refresh = false ) {

  $address_hash = md5( $address );

  $coordinates = get_transient( $address_hash );

  if ( $force_refresh || $coordinates === false ) {

    $args       = apply_filters( 'home_map_query_args', array( 'address' => urlencode( $address ), 'sensor' => 'false' ) );
    $url        = add_query_arg( $args, 'http://maps.googleapis.com/maps/api/geocode/json' );
    $response   = wp_remote_get( $url );

    if( is_wp_error( $response ) )
      return;

    $data = wp_remote_retrieve_body( $response );

    if( is_wp_error( $data ) )
      return;

    if ( $response['response']['code'] == 200 ) {

      $data = json_decode( $data );

      if ( $data->status === 'OK' ) {

        $coordinates = $data->results[0]->geometry->location;

        $cache_value['lat']   = $coordinates->lat;
        $cache_value['lng']   = $coordinates->lng;
        $cache_value['address'] = (string) $data->results[0]->formatted_address;

        // cache coordinates for 3 months
        set_transient($address_hash, $cache_value, 3600*24*30*3);
        $data = $cache_value;

      } elseif ( $data->status === 'ZERO_RESULTS' ) {
        return __( 'No adress found.', 'HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN' );
      } elseif( $data->status === 'INVALID_REQUEST' ) {
        return __( 'Invalid request. Did you enter an address?', 'HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN' );
      } else {
        return __( 'Please ensure you have entered the short code correctly.', 'HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN' );
      }

    } else {
      return __( 'Unable to contact Google API service.', 'HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN' );
    }

  } else {
     // return cached results
     $data = $coordinates;
  }

  return $data;
}


add_action('admin_menu', 'add_plugin_page');
function add_plugin_page(){
  add_options_page( 'Настройки HomeTaskPlugin', 'HomeTaskPlugin', 'manage_options', 'hometask_slug', 'hometask_options_page_output' );
}

function hometask_options_page_output(){
  ?>
  <div class="wrap">
    <h2><?php echo get_admin_page_title() ?></h2>

    <form action="options.php" method="POST">
      <?php
        settings_fields( 'option_group' );     // скрытые защитные поля
        do_settings_sections( 'hometask_page' ); // секции с настройками (опциями). У нас она всего одна 'section_id'
        submit_button();
      ?>
    </form>
  </div>
  <?php
}

/**
 * Регистрируем настройки.
 * Настройки будут храниться в массиве, а не одна настройка = одна опция.
 */
add_action('admin_init', 'plugin_settings');
function plugin_settings(){
  // параметры: $option_group, $option_name, $sanitize_callback
  register_setting( 'option_group', 'option_name', 'sanitize_callback' );

  // параметры: $id, $title, $callback, $page
  add_settings_section( 'section_id', 'Основные настройки', '', 'hometask_page' ); 

  // параметры: $id, $title, $callback, $page, $section, $args
  add_settings_field('hometask_field1', 'API KEY', 'fill_hometask_field1', 'hometask_page', 'section_id' );
  add_settings_field('hometask_field2', 'Сохранить', 'fill_hometask_field2', 'hometask_page', 'section_id' );
}

## Заполняем опцию 1
function fill_hometask_field1(){
  $val = get_option('option_name');
  $val = $val['input'];
  ?>
  <input type="text" name="option_name[input]" value="<?php echo esc_attr( $val ) ?>" />
  <?php
}

## Заполняем опцию 2
function fill_hometask_field2(){
  $val = get_option('option_name');
  $val = $val['checkbox'];
  ?>
  <label><input type="checkbox" name="option_name[checkbox]" value="1" <?php checked( 1, $val ) ?> /> отметить</label>
  <?php
}

## Очистка данных
function sanitize_callback( $options ){ 
  // очищаем
  foreach( $options as $name => & $val ){
    if( $name == 'input' )
      $val = strip_tags( $val );

    if( $name == 'checkbox' )
      $val = intval( $val );
  }

  //die(print_r( $options )); // Array ( [input] => aaaa [checkbox] => 1 )

  return $options;
}

/ Создаю posttype функцию
function HomePostType() {

  register_post_type( 'movies',
  // задаю опции
    array(
      'labels' => array(
        'name' => __( 'Фильмы' ),
        'singular_name' => __( 'Фильм' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'movies'),
    )
  );
}

add_action( 'init', 'HomePostType' );

/*
* Создание кастомпосттайпа
*/

function custom_post_type() {


  $labels = array(
    'name'                => _x( 'Фильмы', 'Общее имя', 'twentyseventeen' ),
    'singular_name'       => _x( 'Фильм', 'Одинорное имя', 'twentyseventeen' ),
    'menu_name'           => __( 'Фильмы', 'twentyseventeen' ),
    'parent_item_colon'   => __( 'Родительский фильм', 'twentyseventeen' ),
    'all_items'           => __( 'Все Фильмы', 'twentyseventeen' ),
    'view_item'           => __( 'Посмотреть фильм', 'twentyseventeen' ),
    'add_new_item'        => __( 'Добавить новый фильм', 'twentyseventeen' ),
    'add_new'             => __( 'Добавить новый', 'twentyseventeen' ),
    'edit_item'           => __( 'Редактировать фильм', 'twentyseventeen' ),
    'update_item'         => __( 'Обновить Фильм', 'twentyseventeen' ),
    'search_items'        => __( 'Найти фильм', 'twentyseventeen' ),
    'not_found'           => __( 'Не сущуствует', 'twentyseventeen' ),
    'not_found_in_trash'  => __( 'Не сущуствует в корзине', 'twentyseventeen' ),
  );
  

  
  $args = array(
    'label'               => __( 'Фильмы', 'twentyseventeen' ),
    'description'         => __( 'Новости фильмов', 'twentyseventeen' ),
    'labels'              => $labels,
  
    'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),

    'taxonomies'          => array( 'genres' ),

    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capability_type'     => 'post',
  );
  
  // Регистрация Custom Post Type
  register_post_type( 'movies', $args );

}



add_action( 'init', 'custom_post_type', 0 );

//Вывод на сайт
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

function add_my_post_types_to_query( $query ) {
  if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', array( 'post', 'movies' ) );
  return $query;
}





register_activation_hook( __FILE__, array('includes\HomeTaskPlugin' ,  'activation' ) );
register_deactivation_hook( __FILE__, array('includes\HomeTaskPlugin' ,  'deactivation' ) );


