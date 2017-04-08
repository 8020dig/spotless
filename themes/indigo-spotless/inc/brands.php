<?php

/**
 * Manage brands post type in the website.
 */ 
class Brand{

  static $post_name = 'brand';
  
  static $brands_post_meta = 'project_brands';

  /**
   * Executes on init hook of WordPress
   */
  static function init_action(){
    //addition of brands post type
    register_post_type(self::$post_name, [
      'label' => 'Brands',
      'description' => __('Post type used to relate brands in projects.', 'aecom-indigo'),
      'public' => true,
      'menu_position' => 5,
      'supports'=> ['title', 'editor', 'thumbnail'],
    ]);
  }
  
  /**
   * Get some articles of same author of the article.
   *
   * @param mixed (integer|WP_Post) $article Post object of article or ID of article.
   * @param integer $limit amount of articles to retrieve. Default is 3.
   *
   * @return mixed list(WP_Post objects) of related articles. False on error.
   */
  static function get_related_author_articles($article, $limit = 3){
    //get author of the article
    $author = !empty($article->post_author) ? $article->post_author : get_post_field('post_author', $article);
    
    //check author
    if(empty($author))
      return false;
    
    //get last articles of same author exluding the current article
    return get_posts([
      'post_type' => self::$post_name,
      'posts_per_page' => $limit,
      'author' => $author,
      'exclude' => [ !empty($article->ID) ? $article->ID : $article ],
      'orderby' => 'date',
      'order' => 'DESC',
    ]);
  }
  
  /**
   * Get a HTML grid with related articles of same author of article.
   *
   * @param mixed (integer|WP_Post) $article Post object of article or ID of article.
   * @param integer $limit amount of articles to retrieve. Default is 3.
   *
   * @return mixed string HTML code of the grid or false if there are no articles.
   */
  static function get_html_grid_related_author_articles($article, $limit = 3){
    //get related articles
    $related_articles = self::get_related_author_articles($article);
    
    //check articles
    if(empty($related_articles))
      return false;
    
    //set global var to use in the template
    global $articles;
    $articles = $related_articles;
    
    //create HTML code
    ob_start();
    include get_stylesheet_directory() . '/templates/related-articles-grid.php';
    $content = ob_get_contents();
    ob_end_clean();
    
    return $content;
  }
  
  /**
   * Get brands related to a project.
   *
   * @param $project_id integer ID of project.
   *
   * @return mixed list(WP_Post objects) of related brands. False on error.
   */
  static function get_project_brands($project_id){
  	//get the ID of brands related to the project
    $brands_ids = get_post_meta($project_id, self::$brands_post_meta);

    //check list
    if(empty($brands_ids))
      return false;
    
    //get post objects for brands related
    return get_posts([
      'post_type' => self::$post_name,
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'include' => $brands_ids,
      'orderby' => 'post__in',
    ]);
  }
  
  /**
   * Addition of meta boxes in posts screens to save brands in projects.
   */
  static function meta_boxes(){ 	
    //add meta box in projects to create the set of brands
    add_meta_box('project-brands', 'Brands', function($current_post, $args = null){    	
      //get all brands
      $brands = get_posts([
        'posts_per_page' => -1,
        'post_type' => self::$post_name,
        'orderby' => 'title',
        'order' => 'ASC'
      ]);
      
      //get the brands in the current post
      $current_brands_ids = get_post_meta($current_post->ID, self::$brands_post_meta);
      $current_brands = array_fill_keys($current_brands_ids, "");
      
      //create multiple select
      ?>
      <select class="posts-picker qcustom-selector" multiple>
        <?php
        foreach($brands as $brand):
          $found = false;
          if($found = isset($current_brands[$brand->ID])):
            $current_brands[$brand->ID] = $brand->post_title;
          else:
          ?>
          <option value="<?= $brand->ID ?>"><?= $brand->post_title ?></option>
          <?php
          endif;
        endforeach; ?>
      </select>
      <span class="posts-adder"><?php _e('Add to list', 'aecom-indigo') ?></span>
      <ul class="sel-posts-container ui-sortable">
        <?php foreach($current_brands as $id => $title): ?>
        <li data-id="<?= $id ?>">
          <label class="li-mover"><i class="remove-post fa fa-times"></i> <?= $title ?></label>
          <input type="hidden" value="<?= $id ?>" name="project-brands[]">
        </li>
        <?php endforeach; ?>
      </ul>
      <script type="text/html" id="tmpl-brand-list-item">
      <li data-id="{{data.id}}">
        <label class="li-mover"><i class="remove-post fa fa-times"></i> {{data.title}}</label>
        <input type="hidden" value="{{data.id}}" name="project-brands[]">
      </li>
      </script>
      <?php
    }, 'project', 'advanced', 'default');
  }
  
  /**
   * Saving of brands when a project is saved.
   */
  function save_post($post_id){
    // If this is just a revision, don't save custom fields
    if ( wp_is_post_revision( $post_id ) )
      return;
		
	  //get post type of current post
    $current_post_type = get_post_type($post_id);
     
    //check if current post is a project
    if('project' != $current_post_type)
      return;

    //get brands to save in the project
    $brands = isset($_POST['project-brands']) ? $_POST['project-brands'] : array();
    
    //get current brands of the project
    $current_brands = get_post_meta($post_id, self::$brands_post_meta);
    
    //get new brands
    $new_brands = array_diff($brands, $current_brands);
    
    //save new brands
    if(!empty($new_brands))
    	foreach($new_brands as $brand)
    		add_post_meta($post_id, self::$brands_post_meta, $brand);
    
    //get brands to delete
    $deleted_brands = array_diff($current_brands, $brands);
    
    //delete brands
    if(!empty($deleted_brands))
    	foreach($deleted_brands as $brand)
    		delete_post_meta($post_id, self::$brands_post_meta, $brand);
  }
  
  /**
   * Enqueue CSS and JS scripts in admin side.
   */
  static function admin_enqueue_scripts($hook){
    wp_register_script('admin-project-brands', get_stylesheet_directory_uri() . '/js/project-brands.js');
    wp_enqueue_script('admin-project-brands');
  }
  
  /**
   * Filter projects by brands when archive of projects is displayed.
   * This function is a copy of function urs_projects_pre_get_posts in urs-projects plugin.
   *
   */
	static function filter_projects_by_brands( $query ) {
		
		// --------------------------------------------------------------------------
  	// post_type == 'project'
  	// --------------------------------------------------------------------------
  	
		if ( isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] == 'project' && !$query->get( 'no_filter' )) {
			// init
	    $meta = array();
  
  	  // filtering by query...
    	// ... is handled by WP
    
    	// we may need to restart Relevanssi tho
	    if ( $query->get( 'restart_search' ) ) {
  	    global $relevanssi_active;
    	  $relevanssi_active = false;
	    }
    
  	  // filtering by markets
    	if ( isset( $_GET['qb'] ) && $_GET['qb'] && sizeof( $_GET['qb'] ) ) {
	      reset( $_GET['qb'] );
  	    while ( list ( , $id ) = each ( $_GET['qb'] ) ) {
    	    if ( !empty( $id ) )  {
      	    $meta[] = array(
        	    'key' => self::$brands_post_meta,
          	  'value' => urs_projects_merge_children(array( $id ), 'brand'),
            	'type' => 'numeric',
	            'compare' => 'IN'
  	        );
    	    }
      	}//while
      	
      	$query->set( 'meta_query', $meta );
    	}//if qb

		}
		
	}//filter_projects_by_brands
}

add_action('init', '\Brand::init_action');
add_action('add_meta_boxes', '\Brand::meta_boxes');
add_action('save_post', '\Brand::save_post');
add_action('admin_enqueue_scripts', '\Brand::admin_enqueue_scripts');
add_action('pre_get_posts', '\Brand::filter_projects_by_brands');
