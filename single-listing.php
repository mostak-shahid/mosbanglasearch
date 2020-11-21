<?php 
global $mosbanglasearch_options;
$from_theme_option = $mosbanglasearch_options['general-page-sections'];
$from_page_option = get_post_meta( get_the_ID(), '_mosbanglasearch_page_section_layout', true );
$sections = (@$from_page_option['Enabled'])?$from_page_option['Enabled']:$from_theme_option['Enabled'];
unset($sections['content']);
?><?php get_header() ?>
<?php 
$class = $mosbanglasearch_options['sections-content-class'];
$page_details = array( 'id' => get_the_ID(), 'template_file' => basename( get_page_template() ));
do_action( 'action_avobe_content', $page_details ); 
?>
<section id="page" class="page-content listing-content <?php if(@$mosbanglasearch_options['sections-content-background-type'] == 1) echo @$mosbanglasearch_options['sections-content-background'] . ' ';?><?php if(@$mosbanglasearch_options['sections-content-color-type'] == 1) echo @$mosbanglasearch_options['sections-content-color'];?> <?php echo $class ?>">
	<div class="content-wrap">
		<div class="container">
			<?php do_action( 'action_before_content', $page_details  ); ?>
                <div class="row">
                    <div class="col-lg-6">
                        <?php if ( have_posts() ) :?>                         
                            <h2><?php echo get_the_title() ?></h2>              
                            <?php the_content() ?>
                            <?php 
                            $business_gallery = get_post_meta(get_the_id(),'business_gallery',true);
                            $embed_map_location = get_post_meta(get_the_id(),'embed_map_location',true);
                            $business_address = get_post_meta(get_the_id(),'business_address',true);
                            $business_email = get_post_meta(get_the_id(),'business_email',true);
                            $business_phone = get_post_meta(get_the_id(),'business_phone',true);
                            $business_website = get_post_meta(get_the_id(),'business_website',true);
                            $business_category = get_post_meta(get_the_id(),'business_category',true);
                            if ($business_gallery): ?>
                                <div class="listing-gallery-owl-carousel owl-carousel owl-theme">
                                <?php $ids = explode(',',$business_gallery);
                                foreach($ids as $attachment_id) : ?>
                                    <div class="item item-<?php echo $attachment_id ?>"><a href="<?php echo wp_get_attachment_url( $attachment_id )?>" data-fancybox="gallery" data-caption="<?php echo get_the_title($attachment_id) ?>"><img src="<?php echo aq_resize(wp_get_attachment_url( $attachment_id ),125,108,true) ?>" alt="<?php echo get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ); ?>" class="img-fluid img-listing-gallery" width="125" height="108"></a></div>
                                <?php endforeach?>
                                </div>
                            <?php endif;?>
                            <?php echo do_shortcode('[WPCR_SHOW POSTID="'.get_the_id().'" NUM="5" PAGINATE="1" PERPAGE="5" SHOWFORM="1" HIDEREVIEWS="0" HIDERESPONSE="0" SNIPPET="" MORE="" HIDECUSTOM="0" ]') ?>
                        <?php endif;?>                        
                    </div>
                    <div class="col-lg-6">
                        <div class="listing-contact-us mb-30"><a href="<?php echo home_url('/') ?>" class="btn btn-block btn-listing-contact text-theme">Contact Us</a></div>
                        <?php if ($embed_map_location) : ?>
                            <div class="embed-responsive embed-responsive-16by9 listing-map mb-30">
                                <iframe class="embed-responsive-item" src="<?php echo $embed_map_location ?>" allowfullscreen></iframe>
                            </div>
                        <?php endif?>
                        <div class="listing-contact mb-30">
                            <h4 class="listimg-title mb-30">Business Address</h4>
                            <?php if ($business_address) : ?>
                                <div class="listing-address mb-3"><i class="fa fa-map-marker text-theme"></i> <?php echo $business_address ?></div>
                            <?php endif; ?>
                            <?php if ($business_email) : ?>
                                <div class="listing-email mb-3"><i class="fa fa-envelope text-theme"></i> <a href="mailto:<?php echo $business_email ?>"><?php echo $business_email ?></a></div>
                            <?php endif; ?>
                            <?php if ($business_phone) : ?>
                                <div class="listing-phone mb-3"><i class="fa fa-phone text-theme"></i> <a class="text-theme font-weight-900" href="tel:<?php echo $business_phone ?>"><?php echo $business_phone ?></a></div>
                            <?php endif; ?>
                            <?php if ($business_website) : ?>
                                <div class="listing-website mb-3"><i class="fa fa-globe text-theme"></i> <a href="<?php echo $business_website ?>" target="_blank"><?php echo $business_website ?></a></div>
                            <?php endif; ?>
                        </div>
                        <div class="listing-search mb-30"><?php echo do_shortcode('[business-search-form]') ?></div>
                        <div class="listing-social mb-30">                            
                            <h4 class="listimg-title mb-30">Follow Us</h4>
                            <?php echo do_shortcode("[social-menu display='inline' title=0]") ?>
                        </div>
                    </div>
                </div>
			<?php do_action( 'action_after_content', $page_details  ); ?>
		</div>	
	</div>
</section>
<?php do_action( 'action_below_content', $page_details  ); ?>
<?php
$sbusinessclass = $mosbanglasearch_options['sections-sbusiness-class'];
$sbusinesstitle = $mosbanglasearch_options['sections-sbusiness-title'];
$sbusinesscontent = $mosbanglasearch_options['sections-sbusiness-content'];
?>
<section id="section-sbusiness" class="related-listing-content section-business <?php if(@$mosbanglasearch_options['sections-sbusiness-background-type'] == 1) echo @$mosbanglasearch_options['sections-sbusiness-background'] . ' ';?><?php if(@$mosbanglasearch_options['sections-sbusiness-color-type'] == 1) echo @$mosbanglasearch_options['sections-sbusiness-color'];?> <?php echo $sbusinessclass ?>">
    <div class="content-wrap">
        <div class="container">            
            <?php if ($sbusinesstitle) : ?>				
                <div class="title-wrapper wow fadeInDown">
                    <h2 class="title"><?php echo do_shortcode( $sbusinesstitle ); ?></h2>				
                </div>
            <?php endif; ?>
            <?php if ($sbusinesscontent) : ?>				
                <div class="content-wrapper wow fadeInUp"><?php echo do_shortcode( $sbusinesscontent ) ?></div>
            <?php endif; ?>
            <div class="listings-wrapper">
            <?php
            $args = array(
                'post_type' => 'listing',
                'posts_per_page' => 4,
                'post__not_in' =>array(get_the_id()),
                'meta_query' => array(
                    array(
                        'key'     => 'business_category',
                        'value'   => $business_category,
                    ),
                ),
            );
            $query = new WP_Query( $args );                
            if ( $query->have_posts() ) :
                $n = 1;?>
                <div class="row">
                <?php while ( $query->have_posts() ) : $query->the_post();
                    if ($n == 2) $animateClass = 'delay-lg-quarter-s';
                    elseif ($n == 3) $animateClass = 'delay-lg-half-s';
                    elseif ($n == 4) $animateClass = 'delay-three-quarter-s';
                    else  $animateClass = '';?>  
                    <?php $business_logo = get_field('business_logo');?>                
                    <div class="col-lg-3 mb-30 wow fadeInLeft <?php echo $animateClass ?>">
                        <div class="wrap position-relative">
                            <?php if(has_post_thumbnail()) : ?>
                                <div class="img-listing-wrapper"><img src="<?php echo aq_resize(wp_get_attachment_url($business_logo),350,250,true) ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ?>" class="img-fluid img-listing" width="350" height="250"></div>
                            <?php endif; ?>
                            <h4 class="title-listing text-theme"><?php echo get_the_title() ?></h4>
                            <div class="address-listing"><?php echo get_field('business_address')?></div>
                            <div class="category-listing"><span class="name">Category : </span> <span class="value text-theme-2"><?php echo get_field('business_category')?></span></div>
                            <div class="time-listing">Opened <span class="days"><?php echo get_field('business_hours')['day'];?></span> <span class="text-theme"><?php echo get_field('business_hours')['time']; ?></span></div>
                            <a href="<?php echo get_the_permalink() ?>" class="hidden-link">Read More</a>
                        </div>
                    </div>
                    <?php $n++; if ($n>4) $n=1;?>
                <?php endwhile; ?>
                </div>
            <?php endif ?>
            <?php wp_reset_postdata();?>
            </div>
        </div>
    </div>
</section>
<?php if($sections ) { foreach ($sections as $key => $value) { get_template_part( 'template-parts/section', $key );}}?>
<?php get_footer() ?>