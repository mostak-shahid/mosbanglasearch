<?php
function add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) AND $post->post_type == 'page' ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    } else {
        $classes[] = $post->post_type . '-archive';
    }
    if(is_user_logged_in()){
        $classes[] = 'logged-in-user';        
    } else {
        $classes[] = 'guest-user';
        
    }
    return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

function mos_admin_body_class( $classes ) {
    global $pagenow, $typenow;
    // var_dump($pagenow); //edit.php
    // var_dump($typenow); //qa
    $user = wp_get_current_user();
    foreach ($user->roles as $role) {
        $classes .= ' '.$role; 
    }
    $classes .= ' '.$pagenow;
    $classes .= ' '.$typenow;
    return $classes;
}
add_filter( 'admin_body_class', 'mos_admin_body_class' );

add_action( 'action_below_footer', 'back_to_top_fnc', 10, 1 );
function back_to_top_fnc () {
    global $mosbanglasearch_options;
    if ($mosbanglasearch_options['misc-back-top']) :
    ?>
    <a href="javascript:void(0)" class="scrollup" style="display: none;"><img width="40" height="40" src="<?php echo get_template_directory_uri() ?>/images/icon_top.png" alt="Back To Top"></a>
    <?php 
    endif;
}
function custom_admin_script(){
    $frontpage_id = get_option( 'page_on_front' );
    if ($_GET['post'] == $frontpage_id){ 
        ?>
        <script>
        jQuery(document).ready(function($){
            $('#_mosbanglasearch_banner_details').hide();
        });
        </script>
        <?php 
    }
        
}
mos_add_page('search', 'Search', 'default');
mos_add_page('listings', 'Listings', 'default');
mos_add_page('jobs', 'Jobs', 'default');
function mos_add_page($page_slug, $page_title, $page_template) {
    $page = get_page_by_path( $page_slug , OBJECT );
    //var_dump($page);
    if(!$page){
        $page_details = array(
            'post_title' => $page_title,
            'post_name' => $page_slug,
            'post_date' => gmdate("Y-m-d h:i:s"),
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
        );
        $page_id = wp_insert_post( $page_details );
        add_post_meta( $page_id, '_wp_page_template', $page_template );
    }
}
// add_action('admin_head', 'custom_admin_script');
add_filter('wpcf7_form_elements', function($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
    return $content;
});

function mos_add_capability() {
    // print_r(get_role( 'businessman' ));


    /*$administrator = get_role('administrator');
    //$administrator->add_cap('upload_files');
    $administrator->add_cap('edit_published_listings');
    $administrator->add_cap('publish_listings');
    $administrator->add_cap('edit_listings');       
    $administrator->add_cap('read_listing');

    $administrator->add_cap('edit_others_listings');
    $administrator->add_cap('delete_published_listings');
    $administrator->add_cap('delete_listings');*/
}
add_action('admin_init', 'mos_add_capability');

function mos_businessman_redirect() {
    global $pagenow, $typenow;
    /*var_dump($pagenow);
    var_dump($typenow);
    var_dump($_GET['post_type']);*/
    $user = wp_get_current_user();
    //if (($pagenow == 'edit.php' &&  $typenow == 'post') OR ($pagenow == 'post-new.php' &&  $typenow == 'post')){
    if ( in_array('businessman', $user->roles) AND ($pagenow == 'edit.php' OR $pagenow == 'post-new.php' OR $pagenow == 'edit-comments.php' OR $pagenow == 'admin.php' OR $pagenow == 'tools.php') AND $_GET['post_type'] == NULL){
        wp_redirect( admin_url() );
        exit;
    }

}
add_action('init', 'mos_businessman_redirect');

function mos_add_login_logout_register_menu( $items, $args ) {
	if ( $args->theme_location != 'topmenu' ) {
		return $items;
	}

	if ( is_user_logged_in() ) {
		$items .= '<li class="admin-link menu-item menu-item-type-post_type menu-item-object-page"><a href="#">' . __( 'Log Out' ) . '</a></li>';
	} else {
		$items .= '<li class="admin-link menu-item menu-item-type-post_type menu-item-object-page"><a href="#">' . __( 'Member login' ) . '</a></li>';
		$items .= '<li class="admin-link menu-item menu-item-type-post_type menu-item-object-page"><a href="#">' . __( 'Create Account' ) . '</a></li>';
	}

	return $items;
}

add_filter( 'wp_nav_menu_items', 'mos_add_login_logout_register_menu', 199, 2 );

// Limit post access  
function mos_show_posts_for_current_author($query) {
    global $pagenow;
 
    if( 'edit.php' != $pagenow || !$query->is_admin )
        return $query;
 
    if( !current_user_can( 'edit_others_posts' ) ) {
        global $user_ID;
        $query->set('author', $user_ID );
    }
    return $query;
}
add_filter('pre_get_posts', 'mos_show_posts_for_current_author');

// Limit media library access   
function mos_show_current_user_attachments( $query ) {
    $user_id = get_current_user_id();
    if ( $user_id && !current_user_can('activate_plugins') && !current_user_can('edit_others_posts') ) {
        $query['author'] = $user_id;
    }
    return $query;
} 
add_filter( 'ajax_query_attachments_args', 'mos_show_current_user_attachments' );

add_filter('enter_title_here', 'my_title_place_holder' , 20 , 2 );
function my_title_place_holder($title , $post){

    if( $post->post_type == 'listing' ){
        $my_title = "Business name";
        return $my_title;
    } else if( $post->post_type == 'job' ){
        $my_title = "Job Title";
        return $my_title;
    }

    return $title;

}