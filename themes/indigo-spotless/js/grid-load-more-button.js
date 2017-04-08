/**
 * This file creates add feature to load more grid tiles using button load more.
 */
var GridLoadMoreButton = {
  //flag to indicate loading of items
  loading: false,

  //current page loaded
  current_page: 1,
  
  //default params
  params: {
    //URL of remote server
    remote_url: null,
    //WP action to use in ajax request
    wp_action: null,
    //WP template to load responses
    template_name: null,
    //additional data to use in requests
    additional_data: {},
    //grid container
    grid_container: jQuery("#grid"),
    //load more button
    button: jQuery("#gridLoadMoreButton")
  },
  
  /**
   * This function retrieves new items and add them to the grid.
   *
   * @param remote_url string URL of the server.
   * @param wp_action string WP action to use in ajax request.
   * @param template_name string WP template name.
   * @param additional_data Object extra data to send in request.
   */
  get_items: function(){
    var obj = this;
    
    //check if a loading is under process
    if(obj.loading)
      return;
    
    //set loading flag to avoid multiple requests
    obj.loading = true;

    //make ajax request
    jQuery.ajax({
      //method: 'get',
      url: obj.params.remote_url,
      dataType: 'json',
      data: jQuery.extend(obj.params.additional_data, {
        page: obj.current_page,
        action: obj.params.wp_action
      }),
      beforeSend: function(){
        //add loading image
        obj.params.grid_container.after("<div class='loading-container'></span>");
      },
      success: function(response){
        //remove loading image
        obj.params.grid_container.parent().find("div.loading-container").remove();
        
        //check if there are publications
        if(response){
          
          //add publications to the page
          var template = wp.template(obj.params.template_name);
          var objs = [];
          for(var i in response){
            var new_publication = jQuery(template(response[i]));
            obj.params.grid_container.append(new_publication);
            
            //call JS function of other custom script to add CSS effect
            //apply_grid_transition(new_publication);
          }
          
          //increase pages flag
          obj.current_page++;
          
          //enable loading of next set of publications
          obj.loading = false;
          new AnimOnScroll( document.getElementById( 'grid' ), {
            minDuration : 0.4,
            maxDuration : 0.7,
            viewportFactor : 0
          } );
        }
        //if there are no publications
        else {
          //remove load more button
          obj.params.button.remove();
        }
      }
    });
  },
  
  /**
   * Init button event listener.
   *
   * @param args array Params: page, remote_url, wp_action, template_name, additional_args, grid_container, button.
   */
  init: function(args){
    var obj = this;
    
    //get initial params
    if(undefined != args.page)
      obj.current_page = args.page;
    jQuery.extend(obj.params, args);
      
    //add listener on scroll event to retrieve more items
    obj.params.button.click(function(e){
      obj.get_items();
      e.stopPropagation();
      return false;
    });
    
    //makes first request
    obj.get_items();
  }
};
