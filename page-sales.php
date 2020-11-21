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
                        <div class="listing-category mb-30"><h4 class="sale-category"><?php echo (@$_GET['post_type'])?$_GET['post_type']:'All Posts' ?></h4></div>                       
                    </div>
                    <div class="col-lg-6">                    
                        <div class="listing-search mb-30"><?php echo do_shortcode('[business-search-form]') ?></div>
                    </div>
                </div>
                 					
                <div class="listings-wrapper">
                <?php
                $args  = array(
                    'post_type' => 'sale',
                    'posts_per_page' => 10,
                    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                );                            
                if (@$_GET['category']) {
                    $args['meta_query']['relation'] = 'AND';
                    $args['meta_query']['sale_category'] = array(
                        'key' => 'sale_category',
                        'value' => $_GET['category'],
                        'compare' => 'LIKE',
                    );
                }                         
                if (@$_GET['post_type']) {
                    $args['meta_query']['post_type'] = array(
                        'key' => 'sale_post_type',
                        'value' => $_GET['post_type'],
                        'compare' => 'LIKE',
                    );
                }
                $query = new WP_Query( $args );                        
                if ( $query->have_posts() ) : ?>
                    <div class="row">
                    <?php $n = 1?>
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <?php
                        if ($n == 2) $animateClass = 'delay-lg-quarter-s';
                        elseif ($n == 3) $animateClass = 'delay-lg-half-s';
                        else  $animateClass = '';
                        ?>
                        <div class="col-lg-4 mb-30">
                            <div class="border p-2 sale-unit position-relative mb-30 wow fadeInLeft <?php echo $animateClass ?>">
                                <h6 class="text-theme font-weight-700 mb-15"><?php echo get_the_title() ?></h6>
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php echo aq_resize(get_the_post_thumbnail_url(),332,220,true) ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ?>" class="img-fluid img-sale mb-15" width="332" height="220">
                                <?php endif?>
                                <div class="sale-meta text-muted"><?php echo wp_trim_words( get_the_content(), 20, '' )?></div>
                                <a href="<?php echo get_the_permalink() ?>" class="hidden-link">View Details</a>
                            </div>
                        </div>
                        <?php $n++; if ($n>3) $n=1; ?>
                    <?php endwhile; ?>
                    </div>
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
			<?php do_action( 'action_after_content', $page_details  ); ?>
		</div>	
	</div>
</section>
<?php do_action( 'action_below_content', $page_details  ); ?>
<?php if($sections ) { foreach ($sections as $key => $value) { get_template_part( 'template-parts/section', $key );}}?>
<?php get_footer() ?>