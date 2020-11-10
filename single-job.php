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
                            <?php the_content() ?>
                        <?php endif;?>                        
                    </div>
                    <div class="col-lg-6">
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
                    <div class="col-lg-3 mb-30 wow fadeInLeft <?php echo $animateClass ?>">
                        <div class="wrap position-relative">
                            <?php if(has_post_thumbnail()) : ?>
                                <div class="img-listing-wrapper"><img src="<?php echo aq_resize(get_the_post_thumbnail_url(),255,130,true) ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ?>" class="img-fluid img-listing" width="350" height="250"></div>
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