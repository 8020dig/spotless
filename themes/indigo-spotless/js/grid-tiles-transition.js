/**
 * Applies the transition effect to the set of element
 */
function apply_grid_transition(elements){
  elements.each(function(i, el) {
    var el = jQuery(el);
    if (!el.hasClass("shown")) {
      setTimeout(function(){
        el.addClass("shown").delay(1000);
      }, 0 + (i * 150));
    }
  });
}

/**
 * Addition of CSS transition to tiles in the grid
 */
jQuery(document).ready(function(){
  //get window object
  var win = jQuery(window);
  //get tiles of the grid
  var allMods = jQuery(".grid article");

  // Already visible modules
  /*allMods.each(function(i, el) {
    console.log(i, el);
    var el = jQuery(el);
    if (el.visible(true)) {
      el.addClass("already-visible");
    }
  });*/
  
  //init effect without scrolling
  apply_grid_transition(jQuery(".grid article"));

  //add listener to scroll event
  win.scroll(function(event) {
    apply_grid_transition(jQuery(".grid article"));
  });
});

