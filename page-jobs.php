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
                        <div class="listing-category mb-30"><h4 class="job-category"><?php echo (@$_GET['post_type'])?$_GET['post_type']:'All Jobs' ?></h4></div> 					
                        <div class="listings-wrapper">
                        <?php
                        $args  = array(
                            'post_type' => 'job',
                            'posts_per_page' => 10,
                            'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                        );                            
                        if (@$_GET['category']) {
                            $args['meta_query']['relation'] = 'AND';
                            $args['meta_query']['job_category'] = array(
                                'key' => 'job_category',
                                'value' => $_GET['category'],
                                'compare' => 'LIKE',
                            );
                        }                         
                        if (@$_GET['post_type']) {
                            $args['meta_query']['post_type'] = array(
                                'key' => 'post_type',
                                'value' => $_GET['location'],
                                'compare' => 'LIKE',
                            );
                        }
                        $query = new WP_Query( $args );                        
                        if ( $query->have_posts() ) : ?>
                            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                <div class="wow fadeInLeft mb-30">
                                    <h4 class="listing-title mb-30"><a href="<?php echo get_the_permalink() ?>" class="text-theme"><?php echo get_the_title() ?></a></h4>
                                    <div class="job-meta text-muted mb-30">Experienced Contact : <?php echo get_field('job_experience')?></div>
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
                            $results = $wpdb->get_results( "SELECT DISTINCT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key='job_category'", OBJECT );
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