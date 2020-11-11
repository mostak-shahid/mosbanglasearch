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
<section id="page" class="page-content listing-content listing-archive <?php if(@$mosbanglasearch_options['sections-content-background-type'] == 1) echo @$mosbanglasearch_options['sections-content-background'] . ' ';?><?php if(@$mosbanglasearch_options['sections-content-color-type'] == 1) echo @$mosbanglasearch_options['sections-content-color'];?> <?php echo $class ?>">
	<div class="content-wrap">
		<div class="container">
			<?php do_action( 'action_before_content', $page_details  ); ?>
                <div class="row">
                    <div class="col-lg-6">						
                        <div class="listings-wrapper">
                        <?php
                        $args  = array(
                            'post_type' => 'listing',
                            'posts_per_page' => 10,
                            'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                        );                            
                        if (@$_GET['category']) {
                            $args['meta_query']['relation'] = 'AND';
                            $args['meta_query']['business_category'] = array(
                                'key' => 'business_category',
                                'value' => $_GET['category'],
                                'compare' => 'LIKE',
                            );
                        }                         
                        if (@$_GET['location']) {
                            $args['meta_query']['business_address'] = array(
                                'key' => 'business_address',
                                'value' => $_GET['location'],
                                'compare' => 'LIKE',
                            );
                        }
                        $query = new WP_Query( $args );                        
                        if ( $query->have_posts() ) : ?>
                            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                <div class="wow fadeInLeft mb-30">
                                    <div class="media position-relative">
                                        <img src="<?php echo aq_resize(get_the_post_thumbnail_url(),160,115,true) ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ?>" class="img-fluid img-listing mr-3" width="160" height="115">
                                        <div class="media-body">
                                            <h5 class="mt-0 listing-archive-title text-theme font-weight-700"><?php echo get_the_title() ?></h5>
                                            <div class="listing-archive-desc font-weight-700"><?php echo wp_trim_words( get_the_content(), 5, '...' ) ?></div>
                                            <div class="listing-archive-meta text-theme font-weight-700">Categories: <?php echo get_post_meta(get_the_id(),'business_category',true) ?> | Opened: <?php echo get_field('business_hours')['day'];?> <?php echo get_field('business_hours')['time'];?></div>
                                            <a href="<?php echo get_the_permalink() ?>" class="hidden-link">Read More</a>
                                        </div>
                                    </div>
                                    <div class="listing-archive-contact">
                                        <div class="phone"><a class="text-theme font-weight-700" href="tel:<?php echo str_replace(' ', '', get_post_meta(get_the_id(),'business_phone',true)) ?>"><i class="fa fa-phone"></i> <?php echo get_post_meta(get_the_id(),'business_phone',true) ?></a></div>
                                        <div class="address font-weight-700"><i class="fa fa-map-marker"></i> <?php echo get_post_meta(get_the_id(),'business_address',true) ?></div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                            
                        <?php endif;
                        wp_reset_postdata();    
                        ?>
                        <div class="pagination-wrapper faq-pagination"> 
                            <nav class="navigation pagination" role="navigation">
                                <div class="nav-links"> 
                                <?php 
                                    $big = 999999999; // need an unlikely integer
                                    echo paginate_links( array(
                                        'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
                                        'format' => '?paged=%#%',
                                        'current' => max( 1, get_query_var('paged') ),
                                        'total' => $query->max_num_pages,
                                        'prev_text'          => __('Prev'),
                                        'next_text'          => __('Next')
                                    ) );
                                    ?>
                                </div>
                            </nav>
                        </div>
                        </div>                       
                    </div>
                    <div class="col-lg-6">
                    
                        <div class="listing-search mb-30"><?php echo do_shortcode('[business-search-form]') ?></div>
                        <div class="listing-categories mb-30">                            
                            <h4 class="listimg-title mb-30">Additional Categories</h4>
                            <?php                            
                            global $wpdb;
                            //SELECT DISTINCT `meta_value` FROM `bs_wp_postmeta` WHERE `meta_key`='business_category'
                            $results = $wpdb->get_results( "SELECT DISTINCT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key='business_category'", OBJECT );
                            foreach($results as $row){
                                echo '<a href="?category='.$row->meta_value.'" class="btn btn-listing-archive-category font-weight-700">'.$row->meta_value.'</a>';
                            }
                            ?>
                        </div>
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
<?php if($sections ) { foreach ($sections as $key => $value) { get_template_part( 'template-parts/section', $key );}}?>
<?php get_footer() ?>