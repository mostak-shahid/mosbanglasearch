<?php
function admin_shortcodes_page(){
	//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null )
    add_menu_page( 
        __( 'Theme Short Codes', 'textdomain' ),
        'Short Codes',
        'manage_options',
        'shortcodes',
        'shortcodes_page',
        'dashicons-book-alt',
        3
    ); 
}
add_action( 'admin_menu', 'admin_shortcodes_page' );
function shortcodes_page(){
	?>
	<div class="wrap">
		<h1>Theme Short Codes</h1>
		<ol>
			<li>[home-url slug=''] <span class="sdetagils">displays home url</span></li>
			<li>[site-identity class='' container_class=''] <span class="sdetagils">displays site identity according to theme option</span></li>
			<li>[site-name link='0'] <span class="sdetagils">displays site name with/without site url</span></li>
			<li>[copyright-symbol] <span class="sdetagils">displays copyright symbol</span></li>
			<li>[this-year] <span class="sdetagils">displays 4 digit current year</span></li>
			<li>[phone offset=0 index=0 all=1 seperator=', '] <span class="sdetagils">displays phone from theme option</span></li>
			<li>[fax offset=0 index=0 all=1 seperator=', '] <span class="sdetagils">displays fax from theme option</span></li>
			<li>[email offset=0 index=0 all=1 seperator=', '] <span class="sdetagils">displays email from theme option</span></li>
			<li>[buseness-hour] <span class="sdetagils">displays Business Hours from theme option</span></li>
			<li>[address offset=0 index=0 all=1 seperator=', '] <span class="sdetagils">displays address from theme option</span></li>
			<li>[social-menu display='inline/block' title='0/1'] <span class="sdetagils">displays social media from theme option</span></li>		
			<li>[feature-image wrapper_element='div' wrapper_atts='' height='' width=''] <span class="sdetagils">displays feature image</span></li>		
			<li>[business-search-form] <span class="sdetagils">displays bysiness search form</span></li>		
		</ol>
	</div>
	<?php
}
function business_search_formfunc( $atts = array(), $content = '' ) {
    $category = @$_GET['category'];
    $location = @$_GET['location'];
    $html = '';
	$atts = shortcode_atts( array(
		'slug' => 'listings',
	), $atts, 'business-search-form' );
    global $wpdb;
    //SELECT DISTINCT `meta_value` FROM `bs_wp_postmeta` WHERE `meta_key`='business_category'
    $results = $wpdb->get_results( "SELECT DISTINCT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key='business_category'", OBJECT );
    if ($results) {
        $html .= '<datalist id="categories">';
        foreach($results as $row){
            $html .= '<option value="'.$row->meta_value.'">';
        }
        $html .= '</datalist>';
    }
    $html .='<form class="listing-search-form" action="'.home_url($atts['slug']).'" method="get">';
        $html .= '<div class="form-row">';
            $html .= '<div class="col">';
                $html .= '<div class="input-group">';
                    $html .= '<div class="input-group-prepend">';
                        $html .= '<span class="input-group-text" id="basic-addon1">Find</span>';
                    $html .= '</div>';
                    $html .= '<input name="category" type="text" class="form-control" placeholder="Category" value="'.$category.'" list="categories">';
                $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="col">';
                $html .= '<div class="input-group">';
                    $html .= '<div class="input-group-prepend">';
                        $html .= '<span class="input-group-text" id="basic-addon1">Near</span>';
                    $html .= '</div>';
                    $html .= '<input name="location" type="text" class="form-control" placeholder="Location" value="'.$location.'">';

                    $html .= '<div class="input-group-append">';
                        $html .= '<button class="btn bg-theme text-theme-2" type="submit"><i class="fa fa-search"></i></button>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';
    $html .='</form>';
	return $html;
}
add_shortcode( 'business-search-form', 'business_search_formfunc' );
function home_url_func( $atts = array(), $content = '' ) {
	$atts = shortcode_atts( array(
		'slug' => '',
	), $atts, 'home-url' );

	return home_url( $atts['slug'] );
}
add_shortcode( 'home-url', 'home_url_func' );
function site_identity_func( $atts = array(), $content = null ) {
	global $mosbanglasearch_options;
	$logo_url = ($mosbanglasearch_options['logo']['url']) ? $mosbanglasearch_options['logo']['url'] : get_template_directory_uri(). '/images/logo.png';
	$logo_option = $mosbanglasearch_options['logo-option'];
	$html = '';
	$atts = shortcode_atts( array(
		'class' => '',
		'container_class' => ''
	), $atts, 'site-identity' ); 
	
	
	$html .= '<div class="logo-wrapper '.$atts['container_class'].'">';
		if($logo_option == 'logo') :
			$html .= '<a class="logo '.$atts['class'].'" href="'.home_url().'">';
			// list($width, $height) = getimagesize($logo_url);
			$html .= '<img class="img-responsive img-fluid" src="'.$logo_url.'" alt="'.get_bloginfo('name').' - Logo" width="'.$mosbanglasearch_options['logo']['width'].'" height="'.$mosbanglasearch_options['logo']['height'].'">';
			$html .= '</a>';
		else :
			$html .= '<div class="text-center '.$atts['class'].'">';
				$html .= '<h1 class="site-title"><a href="'.home_url().'">'.get_bloginfo('name').'</a></h1>';
				$html .= '<p class="site-description">'.get_bloginfo( 'description' ).'</p>';
			$html .= '</div>'; 
		endif;
	$html .= '</div>'; 
		
	return $html;
}
add_shortcode( 'site-identity', 'site_identity_func' );

function site_name_func( $atts = array(), $content = '' ) {
	$html = '';
	$atts = shortcode_atts( array(
		'link' => 0,
	), $atts, 'site-name' );
	if ($atts['link']) $html .=	'<a href="'.esc_url( home_url( '/' ) ).'">';
	$html .= get_bloginfo('name');
	if ($atts['link']) $html .=	'</a>';
	return $html;
}
add_shortcode( 'site-name', 'site_name_func' );
function copyright_symbol_func() {
	return '&copy;';
}
add_shortcode( 'copyright-symbol', 'copyright_symbol_func' );
function this_year_func() {
	return date('Y');
}
add_shortcode( 'this-year', 'this_year_func' );
function email_func( $atts = array(), $content = '' ) {	
	global $mosbanglasearch_options;
	$contact_email = $mosbanglasearch_options['contact-email'];
	$html = '';	
	$atts = shortcode_atts( array(
		'offset' => 0,
		'index' => 0,
		'all' => 1,
		'seperator' => ', ',
	), $atts, 'email' );
	$n = 1;

	$html .= '<span class="email-wrap">';
	if ($atts['index']) :
		$i = $atts['index'] - 1;
		$html .= '<span class="email">';
			$html .= '<a class="mailToShow" href="mailto:'.$contact_email[$i].'">'.$contact_email[$i].'</a>';
		$html .= '</span>';	
	else :
		if(@$contact_email) :
			foreach ($contact_email as $email) :
				if ($n > $atts['offset']) :
					$html .= '<span class="email">';
						$html .= '<a class="mailToShow" href="mailto:'.$email.'">'.$email.'</a>';
					$html .= '</span>';
					$html .= $atts['seperator'];
				endif;
				$n++;
			endforeach;
		endif;
	endif;
	$output = rtrim(  $html, $atts['seperator']);
	$output .= '</span>';
	return $output;
}
add_shortcode( 'email', 'email_func' );

function phone_func( $atts = array(), $content = '' ) {
    global $mosbanglasearch_options;
    $html = '';
	$atts = shortcode_atts( array(
		'offset' => 0,
		'index' => 0,
		'all' => 1,
		'seperator' => ', '
	), $atts, 'phone' );
	$n = 1; 
	$html .= '<span class="phone-number-wrap">';
	if ($atts['index']) :
		$i = $atts['index'] - 1;
	    $html .= '<span class="phone-number">';
	    $html .= '<a class="phoneToShow" href="tel:';
	    $html .= preg_replace('/[^0-9]/', '', $mosbanglasearch_options['contact-phone'][$i]);
	    $html .= '" >';
	    $html .= $mosbanglasearch_options['contact-phone'][$i];  
	    $html .= '</a>';
	    $html .= '</span>';		
	else :
		if (@$mosbanglasearch_options['contact-phone']) :
			foreach ($mosbanglasearch_options['contact-phone'] as $phone) :
				if ($n > $atts['offset']) :
				    $html .= '<span class="phone-number">';
				    $html .= '<a class="phoneToShow" href="tel:';
				    $html .= preg_replace('/[^0-9]/', '', $phone);
				    $html .= '" >';
				    $html .= $phone;  
				    $html .= '</a>';
				    $html .= '</span>';
				    $html .= $atts['seperator'];
				endif;
				$n++;
			endforeach;
		endif;
	endif;
	$output = rtrim(  $html, $atts['seperator']);
	$output .= '</span>';
	return $output;
}
add_shortcode( 'phone', 'phone_func' );

function fax_func( $atts = array(), $content = '' ) {
    global $mosbanglasearch_options;
    $html = '';
	$atts = shortcode_atts( array(
		'offset' => 0,
		'index' => 0,
		'all' => 1,
		'seperator' => ', '
	), $atts, 'fax' );
	$n = 1; 
	$html .= '<span class="fax-number-wrap">';
	if ($atts['index']) :
		$i = $atts['index'] - 1;
	    $html .= '<span class="fax-number">';
	    $html .= '<a class="faxToShow" href="tel:';
	    $html .= preg_replace('/[^0-9]/', '', $mosbanglasearch_options['contact-fax'][$i]);
	    $html .= '" >';
	    $html .= $mosbanglasearch_options['contact-fax'][$i];  
	    $html .= '</a>';
	    $html .= '</span>';		
	else :
		if (@$mosbanglasearch_options['contact-fax']) :
			foreach ($mosbanglasearch_options['contact-fax'] as $fax) :
				if ($n > $atts['offset']) :
				    $html .= '<span class="fax-number">';
				    $html .= '<a class="faxToShow" href="tel:';
				    $html .= preg_replace('/[^0-9]/', '', $fax);
				    $html .= '" >';
				    $html .= $fax;  
				    $html .= '</a>';
				    $html .= '</span>';
				    $html .= $atts['seperator'];
				endif;
				$n++;
			endforeach;
		endif;
	endif;
	$output = rtrim(  $html, $atts['seperator']);
	$output .= '</span>';
	return $output;
}
add_shortcode( 'fax', 'fax_func' );
function business_hour_func( $atts = array(), $content = '' ) {
	$html = '';
	global $mosbanglasearch_options;
	$contact_hours = $mosbanglasearch_options['contact-hour'];
	if ($contact_hours){
		$html .= '<ul class="business-houes">';
		foreach ($contact_hours as $contact_hour) {
			$html .= '<li>' . $contact_hour . '</li>';
		}
		$html .= '</ul>';
	}
	return $html;
}
add_shortcode( 'business-hour', 'business_hour_func' );
function address_func( $atts = array(), $content = '' ) {
    global $mosbanglasearch_options;
    $html = '';
	$atts = shortcode_atts( array(
		'offset' => 0,
		'index' => 0,
		'all' => 1,
		'seperator' => ', '
	), $atts, 'address' );
	$n = 1; 
	$html .= '<span class="address-wrap">';	
	if ($atts['index']) :
		$i = $atts['index'] - 1;
	    $html .= '<span class="address address-'.$n.'">';
	    $html .= '<span class="address-title">'.$mosbanglasearch_options['contact-address'][$i]['title'].'</span>';
		if ($mosbanglasearch_options['contact-address'][$i]['map_link']) :
			$html .= '<a class="address-details" href="'.$mosbanglasearch_options['contact-address'][$i]['map_link'].'" target="_blank">'.$mosbanglasearch_options['contact-address'][$i]['description'].'</a>';
		else :
			$html .= '<span  class="address-details">'.$mosbanglasearch_options['contact-address'][$i]['description'].'</span>';
		endif;
	    $html .= '</span>';
	else :
		if(@$mosbanglasearch_options['contact-address']) :
			foreach ($mosbanglasearch_options['contact-address'] as $address) :
				if ($n > $atts['offset']) :
				    $html .= '<span class="address address-'.$n.'">';
					$html .= '<span class="address-title">'.$address['title'].'</span>';
					if ($address['map_link']) :
						$html .= '<a class="address-details" href="'.$address['map_link'].'" target="_blank">'.$address['description'].'</a>';
					else :
						$html .= '<span  class="address-details">'.$address['description'].'</span>';
					endif;
				    $html .= '</span>';
				    $html .= $atts['seperator'];
				endif;
				$n++;
			endforeach;
		endif;
	endif;	    
	$output = rtrim(  $html, $atts['seperator']);
	$output .= '</span>';
	return $output;

	// do shortcode actions here
}
add_shortcode( 'address', 'address_func' );
function social_menu_fnc( $atts = array(), $content = '' ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'mos-image-alt/mos-image-alt.php' ) ) {
		$alt_tag = mos_alt_generator(get_the_ID());
	} 
	global $mosbanglasearch_options;
	$html = '';
	$contact_social = $mosbanglasearch_options['contact-social'];
	$contact_address = $mosbanglasearch_options['contact-address'];
	$atts = shortcode_atts( array(
		'display' => 'inline',
		'title' => 0,
	), $atts, 'social-menu' );
	if ($atts['display'] == 'inline') $display = 'list-inline';
	else  $display = 'list-unstyled';
	$html .= '<ul class="'.$display.' social-menu">';
	foreach ($contact_social as $social) :	
		if ($social['link_url'] AND $social['basic_icon']) :
			$str = '';
			$basic_icon = do_shortcode(mos_home_url_replace($social['basic_icon']));

			if (filter_var($basic_icon, FILTER_VALIDATE_URL)) {
				//$basic_icon = do_shortcode();
				list($width, $height) = getimagesize($basic_icon);
				$str = '<span class="social-img"><img src="'.$basic_icon.'" alt="'.$alt_tag['social'] . $social['title'].'" width="'.$width.'" height="'.$height.'"></span>';
				if ($social['hover_icon']) {
					//$hover_icon = do_shortcode(str_replace('{{home_url}}', home_url(), $social['hover_icon']));
					$hover_icon = do_shortcode(mos_home_url_replace($social['hover_icon']));
					list($hwidth, $hheight) = getimagesize($hover_icon);
					$str .= '<span class="social-img-hover"><img src="'.$hover_icon.'" alt="'.$alt_tag['social'] . $social['title'].'" width="'.$hwidth.'" height="'.$hheight.'"></span>'; //hover_icon
				}
			}
			else { 
				$str = '<span class="social-icon"><i class="'.$social['basic_icon'].'"></i></span>';
				if ($social['hover_icon'])
					$str .= '<span class="social-icon-hover"><i class="'.$social['hover_icon'].'"></i></span>';
			}
			$html .= '<li class="social-list '.strtolower(preg_replace('/\s+/', '_', $social['title']));
			if ($atts['display'] == 'inline') $html .= ' list-inline-item';
			$html .= '"><a href="'.esc_url( $social['link_url'] ).'"';
			if ($social['target'])
				$html .= ' target="_blank"';
			$html .= '>' . $str;
			if ($atts['title']) $html .= '<span class="social-title">' . $social['title'] .'</span>';
			$html .= '</a></li>';
		endif;	
	endforeach;

	$html .= '</ul>';
	return $html;
}
add_shortcode( 'social-menu', 'social_menu_fnc' );

function feature_image_func( $atts = array(), $content = '' ) {
	global $mosacademy_options;
	$html = '';
	$img = '';
	$atts = shortcode_atts( array(
		'wrapper_element' => 'div',
		'wrapper_atts' => '',
		'height' => '',
		'width' => '',
	), $atts, 'feature-image' );

	if (has_post_thumbnail()) $img = get_the_post_thumbnail_url();	
	elseif(@$mosacademy_options['blog-archive-default']['id']) $img = wp_get_attachment_url( $mosacademy_options['blog-archive-default']['id'] ); 
	if ($img){
		if ($atts['wrapper_element']) $html .= '<'. $atts['wrapper_element'];
		if ($atts['wrapper_atts']) $html .= ' ' . $atts['wrapper_atts'];
		if ($atts['wrapper_element']) $html .= '>';
		list($width, $height) = getimagesize($img);
		if ($atts['width'] AND $atts['height']) :
			if ($width > $atts['width'] AND $height > $atts['height']) $img_url = aq_resize($img, $atts['width'], $atts['height'], true);
			else $img_url = $img;
		elseif ($atts['width']) :
			if ($width > $atts['width']) $img_url = aq_resize($img, $atts['width']);
			else $img_url = $img;
		else : 
			$img_url = $img;
		endif;
		list($fwidth, $fheight) = getimagesize($img_url);
		$html .= '<img class="img-responsive img-fluid img-featured" src="'.$img_url.'" alt="'.get_the_title().'" width="'.$fwidth.'" height="'.$fheight.'" />';
		if ($atts['wrapper_element']) $html .= '</'. $atts['wrapper_element'] . '>';
	}
	return $html;
}
add_shortcode( 'feature-image', 'feature_image_func' );

function theme_credit_func( $atts = array(), $content = '' ) {
	$html = "";
	$atts = shortcode_atts( array(
		'name' => 'Md. Mostak Shahid',
		'url' => 'http://mostak.belocal.oday',
	), $atts, 'theme-credit' );

	return $html = '<a href="'.$atts["url"].'" target="_blank" class="theme-credit">'.$atts["name"].'</a>';
}
add_shortcode( 'theme-credit', 'theme_credit_func' );
