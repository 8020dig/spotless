<?php
// do not allow direct access to this file
if ( !defined( 'URS_LOADER' ) )
  exit();

//init session to check if response is already available
if("projects" == $section)
  session_start();

//if projects are randomized and stored in session for the current site
$request_uri = array_filter(explode("/", $_SERVER['REQUEST_URI']));
$blog_code = current($request_uri);
if("projects" == $section && !empty($_SESSION['aecom_projects_list'][$blog_code])){
  $projects = $_SESSION['aecom_projects_list'][$blog_code];
}
else{
  // load project data
  $projects = urs_dynamic_data_get( 'featured-' . URS_LANG, 'projects' );

  // randomly order
  function urs_projects_random_sort ( $a, $b ) {
    $aw = mt_rand( 0, 1000 ); // + ( (int) $a->post_local_priority * 10000 );
    $bw = mt_rand( 0, 1000 ); // + ( (int) $b->post_local_priority * 10000 );
    return $bw - $aw;
  }
  if(is_array($projects))
    usort( $projects, 'urs_projects_random_sort' );

  //save in session the list of projects but only for current blog(delete other blogs to not save a too much data)
  if("projects" == $section)
    $_SESSION['aecom_projects_list'] = array($blog_code => $projects);
}
?>

<ul class="grid grid-project preloaded-posts">

<?php

$grid_item_count = 0;
$hide = false;
$page = (isset($_GET['fpp']) && (int)$_GET['fpp']) ? (int)$_GET['fpp'] : 1;

$selected_projects = array();
$next_page = false;
$projects_per_page = 12;
//if first load requires multiple pages
if(!isset($_GET['ajax_load'])){
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

foreach ( $selected_projects as $post ):
  ?><li class="grid-item<?php echo ( $hide ? ' hidden' : '' ); ?>" id="post-<?php echo $post->ID; ?>">
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
  $hide = $hide || ( $grid_item_count >= 12 );
  ?><li class="grid-item placeholder<?php echo ( $hide ? ' hidden' : '' ); ?>" aria-role="presentation"></li><?php
  $grid_item_count += 1;
}

?>

</ul><!-- .grid -->

<?php
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