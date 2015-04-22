<?php

if (!class_exists('Plyyr_Template')) {

  /**
   * A PostTypeTemplate class that provides 3 additional meta fields
   */
  class Plyyr_Template
  {

    const POST_TYPE = "plyyr";


    /**
     * The Constructor
     */
    public function __construct()
    {
      // register actions
      add_action('init', array(&$this, 'init'));
      add_action('template_redirect', array(&$this, 'redirect'));
    }

    /**
     * hook into WP's init action hook
     */
    public function init()
    {
      // Initialize Post Type
      $this->create_post_type();
    }
    
    public function getPortalCode()
    {
      $portal = trim(get_option('plyyr_setting_portal',  'plyyr'));
      if (!$portal) {
        $portal = 'plyyr';
      }
      return $portal;
    }

    /**
     * Create the post type
     */
    public function create_post_type()
    {
      register_post_type(self::POST_TYPE, array(
          'labels' => array(
              'name' => __(sprintf('%ss', ucwords(str_replace("_", " ", self::POST_TYPE)))),
              'singular_name' => __(ucwords(str_replace("_", " ", self::POST_TYPE)))
          ),
          'rewrite' => false,
          'public' => true,
          'publicly_queryable' => true,
          'show_in_menu' => true,
          'show_in_nav_menus' => true,
          'exclude_from_search' => false,
          'has_archive' => true,
          'description' => __("Embed quizzes on your own posts as seen on plyyr.com"),
          'supports' => array(
              'title', 'editor', 'excerpt',
          ),
              )
      );
      register_taxonomy(self::POST_TYPE, self::POST_TYPE, array('rewrite' => false));
      //Custom styles
      wp_enqueue_style('plyyr', plugins_url('css/plyyr.css', __FILE__ ));
      flush_rewrite_rules();
    }

    /**
     * Parse any url on the namespace plyyr and creates a post using the id parameter 
     * with the correspondent quiz embedded.
     */
    public function redirect()
    {
      if (!is_404()) {
        return;
      }
      
      //Is query string present?
      if (isset($_REQUEST['plyyr'])) {
        $term = trim($_REQUEST['plyyr']);
        if ($this->term_has_id_format($term)) {
          $id = $this->create_new_post($term);
        } elseif ($this->term_has_tag_format($term)) {
          $this->get_term_posts_list($term);
        }     
      }

      if ($id) {
        header('Location: ' . get_permalink($id));
      }
    }
    
    protected function term_has_id_format($term)
    {
      if ($term) {
        $parts = explode('-', $term);
        //The second part looks like an id
        return count($parts) > 2 && preg_match('/[0-9]+[a-zA-Z]+|[a-zA-Z]+[0-9]+/', $parts[1]);
      }
    }
    
    protected function term_has_tag_format($term)
    {
      return $term != '';
    }

    /**
     * Contatcts an api to get the quiz information based on the id received and generates
     * the wordpress post. If the api returns an error nothing is generated.
     */
    protected function create_new_post($code)
    {
      $code = urlencode(trim(trim($code), '/'));

      //Now, extract the portal code from the host
      $portal = $this->getPortalCode();

      $response = file_get_contents("https://games.gamecloudnetwork.com/game/decode/$code?portal=$portal&plugin=wordpress&iw=360");
      if ($response) {
        $content = json_decode($response, true);
      }

      if ($content) {
        if (isset($content['type']) && $content['type'] == 'error') {
          return false;
        }
      } else {
        return false;
      }

      //Do we have the word quiz on the title?
      $title = $content['title_with_gametype'];
      
      //Check that the post doesnt exist
      if (get_page_by_title($title, OBJECT, 'plyyr')) {
        return false;
      }

      $args = array(
          'post_content' => $content['wp_shortcode'],
          'post_name' => $content['slug'],
          'post_status' => 'publish',
          'post_title' => $title,
          'post_type' => 'plyyr',
          'post_excerpt' => $content['description'],
      );

      $id = wp_insert_post($args);
      //Store image
      add_post_meta($id, 'plyyr_image', $content['picture']);
      add_post_meta($id, 'plyyr_description', $content['description']);
      $tags = $this->register_tags($id, $content['tags']);
      $tags_html =  get_the_term_list($id, self::POST_TYPE, 'More games that contain: ', ', ');
      //$terms = wp_get_post_terms($id, self::POST_TYPE);
      //var_export($tags_html);exit;
      $args['post_content'] = $args['post_content'] . $tags_html;
      $args['ID'] = $id;
      wp_update_post($args);
      
      return $id;
    }
    
    /**
     * Register the post tags as plyyr taxonomies
     * @param type $tagstring
     */
    protected function register_tags($object_id, $tagstring)
    {
      $tags = explode(',', $tagstring);
      $cleaned_tags = array();
      foreach ($tags as $tag) {
        $tag = trim(strtolower($tag));
        if ($tag) {
          $cleaned_tags[] = ucwords($tag);
        }
      }
      wp_set_object_terms($object_id, $cleaned_tags, self::POST_TYPE);
      return $cleaned_tags;
    }
    
    /** 
     * Prints a list of posts
     */
    protected function get_term_posts_list($term)
    {
      if ($theme_file = locate_template(array('plyyr-by-tag.php'))) {
          $template_path = $theme_file;
      } else {
          $official_theme_file = locate_template(array('page.php', 'index.php'));
          $template_path = plugin_dir_path( __FILE__ ) . '../templates/plyyr-by-tag.php';
          $theme = file_get_contents($official_theme_file);
          $toks = token_get_all($theme);
          $result = array();
          $start_article_index = null;
          $end_article_index = 0;
          foreach ($toks as $tok) {
            if( $tok[0] == T_INLINE_HTML )   {
              $result[] = $tok[1];
              if (substr_count($tok[1], '<article') && $start_article_index === null) {
                $start_article_index = count($result);
              }
              if (substr_count($tok[1], '</article')) {
                $last_article_index = count($result);
              }
            }
          }
          $_wrapper_start = implode('', array_slice($result, 0, $start_article_index - 1));
          
          $_wrapper_end =  implode('', array_slice($result, $last_article_index));
      }

      $myposts = array('post_type' => 'plyyr', 'tax_query' => array(
        array(
            'taxonomy' => 'plyyr',
            'field' => 'slug',
            'terms' => $term
        )
      ));
      $loop = new WP_Query($myposts);
      include_once $template_path;
      exit;
    }              

  }

}
