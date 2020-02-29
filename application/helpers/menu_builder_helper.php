<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function build_tree_menu_on_admin($top_nav, $active_menu_id){
	$ci =& get_instance();
	$nav_string = '';
  	foreach($top_nav->result() as $nav){
  		/* START getting the active menu */
  		$is_active = false;
  		$parent_menu_id = '';
  		$find_menu_id = $active_menu_id;
  		if($nav->menu_id == $active_menu_id)
  			$is_active = true;
  		else{
  			while($parent_menu_id<>"*"){
	  			$get_parent = $ci->Content_m->get_parent_navigator($find_menu_id, $ci->session->userdata('level'));
	  			if($nav->menu_id == $get_parent->menu_id)
	  				$is_active = true;
	  			if($get_parent->parent_menu=="*")
	  				$parent_menu_id = "*";
	  			$find_menu_id = $get_parent->menu_id;
	  		}
  		}
  		/* END */
  		if($nav->parent_menu == "*" and $is_active)
  			$nav_string .= '<li class="active treeview">';
  		else if($nav->parent_menu == "*" and !$is_active)
  			$nav_string .= '<li class="treeview">';
  		else if($nav->parent_menu <> "*" and $is_active)
  			$nav_string .= '<li class="active">';
  		else if($nav->parent_menu <> "*" and !$is_active)
  			$nav_string .= '<li>';
      $href_string = '';
      if(substr($nav->href, 0, 4)=="http" or substr($nav->href, 0, 4)=="https")
        $href_string = $nav->href;
      else if($nav->href=="#")
        $href_string = current_url().'#';
      else
        $href_string = base_url($nav->href);
  		$nav_string .= 
  				'<a href="'.$href_string.'">
	              <i class="'.$nav->icon_class.'"></i> <span>'.$nav->menu_label.'</span>';
        if($ci->Content_m->check_navigator_has_child($nav->menu_id, $ci->session->userdata('level')) > 0){
        	$nav_string .= 
        		'<i class="fa fa-angle-left pull-right"></i> 
        		</a>
        		<ul class="treeview-menu">
        			';
        	$get_child = $ci->Content_m->get_child_navigator($nav->menu_id, $ci->session->userdata('level'));
        	$nav_string .= build_tree_menu_on_admin($get_child, $active_menu_id);

        	$nav_string .= '</ul>';
        }
        else
        	$nav_string .= '</a>';
        
        $nav_string .= '</li>';
  			
  	}

  	return $nav_string;
}