/**
 * Handle feature to add articles in the publication.
 */
jQuery(document).ready(function(){
  //get HTML template for brand items
  let template = wp.template("brand-list-item");

  //get meta box to add brands in the project
  let meta_box = jQuery("#project-brands");
  
  //get sortable list of brands added in the project
  let brands_added = meta_box.find("ul:first");
  
  //get selector list of brands
  let brands_selector = meta_box.find("select:first");
  
  //get button to add brands in the project
  let add_button = meta_box.find(".posts-adder:first");
  
  //add listener to button
  add_button.click(function(){
    add_brand_in_project();
    return false;
  });
  
  brands_selector.dblclick(function(e){
    //check if click is on an option item
    if("option" != e.target.tagName.toLowerCase())
      return false;
    
    //add brand in projects
    add_brand_in_project();
    return false;
  });
  
  //add listener to deletion buttons in brands added in project
  brands_added.click(function(e){
    //check if click was on deletion button
    if(-1 != e.target.className.indexOf("remove-post")){
      //add option in selector
      let item = jQuery(e.target).parents("li:first");
      brands_selector.append("<option value='" + item.find("input:first").val() + "'>" + item.find("label").text() + "</option>");
      
      //show selector if it is hidden, it is when there is no options when page is loaded
      brands_selector.show();
    }
  });
  
  /**
   * This function gets the brands selected in the selector and add them in the project.
   */
  function add_brand_in_project(){
    //get selected items in selector
    let brands_selected = brands_selector.val();
  
    //add brand to list
    for(let i in brands_selected){
      let option_selected = brands_selector.find("option[value='" + brands_selected[i] + "']");
      brands_added.append(template({
        id: brands_selected[i],
        title: option_selected.text()
      }));
      
      //remove option in selector
      option_selected.remove();
    }
  }
});

