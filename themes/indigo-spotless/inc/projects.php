<?php
/**
 * Ajax listener to retrieve projects.
 */
function aecom_ajax_get_projects(){
  //get project locations
  $locations_query = new WP_Query(array(
    'post_type' => 'location',
    'posts_per_page' => -1,
  ));
  $locations = array();
  foreach ($locations_query->posts as $loc)
    $locations[ $loc->ID ] = $loc->post_title;

  //init session
  session_start();

  //check if there is a tag parameter in the URL
  if(!empty($_GET['tag'])){
    $projects_by_tag = aecom_get_projects_by_tag($_GET['tag']);
  }
  //check if project list doesn't exist on session
  else if(!isset($_SESSION['aecom_projects_list'])){
    //get projects grouped by type
    $project_groups = aecom_get_projects_grouped();

    //randomize projects
    foreach($project_groups as $group => $ids)
      shuffle($project_groups[$group]);

    //create list of projects
    $projects = array_merge($project_groups['local'], array_merge($project_groups['featured'], $project_groups['regular']));

    //save list on session
    $_SESSION['aecom_projects_list'] = $projects;
  }

  if(!empty($_GET['tag'])){
    //get projects obtained using the tag
    $projects = $projects_by_tag;
  }
  else{
    //get projects from session var
    $projects = $_SESSION['aecom_projects_list'];
  }

  //flag for navigation button
  $next_page = false;

  //get set of projects to display
  $page = (isset($_GET['fpp']) && (int)$_GET['fpp']) ? (int)$_GET['fpp'] : 1;
  $selected_projects = array();
  $projects_per_page = 12;

  //if first load requires multiple pages
  if(isset($_GET['init_load'])){
    $init = 0;
    $end = ($projects_per_page + $projects_per_page * ($page - 1) );
  }
  //ajax loading
  else{
    $init = $projects_per_page * ($page - 1);
    $end = $projects_per_page + $init;
  }

  //extract projects to display
  for($i = $init; $i < $end; $i++)
    $selected_projects []= $projects[$i];

  //if there are more projects, then navigation is required
  if(isset($projects[1 + $end]))
    $next_page = $page + 1;

  //get data of projects
  if(!empty($selected_projects)){
    //query database
    $projects_query = new WP_Query(array(
      'post_type' => 'project',
      'posts_per_page' => count($selected_projects),
      'post__in' => $selected_projects
    ));

    //order projects to display
    $selected_ordered_projects = array();
    foreach($selected_projects as $project_id)
      foreach($projects_query->posts as $post){
        if($project_id == $post->ID){
          $post->url = get_permalink( $post->ID ) . '?qp=' . $post->original_query_order;
          $post->image = false;
          if ( has_post_thumbnail( $post->ID ) ) {
           $thumbnail_id = get_post_thumbnail_id( $post->ID );
            $img = wp_get_attachment_image( $thumbnail_id, 'grid-item-2x' );
            $post->image = $img;
          }

          //get custom meta info for the project
          $meta_info = get_post_custom($project_id);

          //get names of locations of the project
          $project_locations = array();
          if(!empty($meta_info['_locations']) && is_array($meta_info['_locations']))
            foreach($meta_info['_locations'] as $loc_id)
              $project_locations[$loc_id] = isset($locations[$loc_id]) ? $locations[$loc_id] : $loc_id;
          //add location to project object
          $post->locations = $project_locations;

          $selected_ordered_projects []= $post;
          break;
        }
      }
  }

  //print projects
  if(isset($_GET['view']) && 'list' == $_GET['view'])
    aecom_print_projects_list_view($selected_ordered_projects);
  else
    aecom_print_projects_grid_view($selected_ordered_projects);

  // show "show more" button if there are more than 12 projects
  if ( $next_page ) {
    ?>
    <div class="preloaded-posts-navigation">
      <div class="show-more" data-scope="grid">
        <a href="#" onclick="return show_more_projects(<?php echo $next_page ?>);" data-next-page="<?php echo $next_page ?>">Show more</a><span class="dots"><span class="dot"></span><span class="dot"></span><span class="dot"></span></span>
      </div>
    </div>
    <?php
  }

  //update referer page for projects
  if(!empty($_GET['referer_url'])){
    //open session
    if(!session_id())
      session_start();
    //store referer in session
    $_SESSION['project_list_referer'] = $_GET['referer_url'];
  }

  //finish ajax execution
  exit;
}
//add ajax listeners
add_action('wp_ajax_nopriv_aecom_ajax_get_projects', 'aecom_ajax_get_projects');
add_action('wp_ajax_aecom_ajax_get_projects', 'aecom_ajax_get_projects');

function aecom_print_projects_grid_view($projects){
  ?>
  <ul class="grid grid-project preloaded-posts">
  <?php

  $grid_item_count = 0;
  foreach ( $projects as $post ):
    ?><li class="grid-item" id="post-<?php echo $post->ID; ?>">
      <a href="<?php echo $post->url; ?>" rel="bookmark">
        <?php if ( $post->image ) {
          echo $post->image;
        } ?>
        <span class="title"><?php echo $post->post_title; ?></span>
      </a>
    </li><?php

    $grid_item_count += 1;
  endforeach;

  /* fill in partial rows with placeholders */
  while ( $grid_item_count % 4 !== 0 ) {
    ?><li class="grid-item placeholder" aria-role="presentation"></li><?php
    $grid_item_count += 1;
  }

  ?>
  </ul><!-- .grid -->
  <?php
}

/**
 * Create HTML code for project list view.
 */
function aecom_print_projects_list_view($projects){
  ?>
  <div class="projects-list-view-container">
  <?php foreach ( $projects as $post ): ?>
    <div class="project-list-item" id="post-<?php echo $post->ID; ?>">
      <div class="project-thumbnail">
        <a href="<?php echo $post->url; ?>" rel="bookmark">
          <?php if ( $post->image ):
            echo $post->image;
          else: ?>
            <p>No image found</p>
          <?php endif; ?>
        </a>
      </div>
      <div class="project-info">
        <div class="header">
          <a href="<?php echo $post->url; ?>" rel="bookmark">
            <h3><?php echo $post->post_title; ?></h3>
          </a>
          <span class="location"><?php echo implode(", ", $post->locations); ?></span>
        </div>
        <p><?php echo wp_trim_words($post->post_content, 42); ?></p>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
  <?php
}

/**
 * get the previous project in the list of projects saved on session for current user.
 */
function aecom_get_session_closest_projects($id = null) {
  //check if there is a list of projects in session
  session_start();
  if(empty($_SESSION['aecom_projects_list']) && empty($_SESSION['aecom_search_projects_list']))
    return false;

  //if ID is not provided, then use current id
  global $post;
  $id = $post->ID;

  //load list of projects(first use the search list, if it is not a search, then it is empty)
  $projects = $_SESSION['aecom_search_projects_list'];
  if(empty($projects))
    $projects = $_SESSION['aecom_projects_list'];

  //search project and get closest projects
  $prev = $next = null;
  for($i = 0; $i < count($projects); $i++)
    //project found
    if($projects[$i] == $id){
      //get previous project
      if($i > 0)
        $prev = $projects[$i - 1];
      //get next project
      if($i < count($projects) - 1)
        $next = $projects[$i + 1];

      break;
    }

  return compact('prev', 'next');
}
