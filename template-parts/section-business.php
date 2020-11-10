<?php 
global $mosbanglasearch_options; 
$class = $mosbanglasearch_options['sections-business-class'];
$title = $mosbanglasearch_options['sections-business-title'];
$content = $mosbanglasearch_options['sections-business-content'];
$slider = $mosbanglasearch_options['sections-business-slider'];
$link = $mosbanglasearch_options['sections-business-link'];
$page_details = array( 'id' => get_the_ID(), 'template_file' => basename( get_page_template() ));
do_action( 'action_avobe_business', $page_details ); 
?>
<section id="section-business" class="section-business <?php if(@$mosbanglasearch_options['sections-business-background-type'] == 1) echo @$mosbanglasearch_options['sections-business-background'] . ' ';?><?php if(@$mosbanglasearch_options['sections-business-color-type'] == 1) echo @$mosbanglasearch_options['sections-business-color'];?> <?php echo $class ?>">
	<div class="content-wrap">
		<div class="container">
		<?php do_action( 'action_before_business', $page_details ); ?>
				<?php if ($title) : ?>				
					<div class="title-wrapper wow fadeInDown">
						<h2 class="title"><?php echo do_shortcode( $title ); ?></h2>				
					</div>
				<?php endif; ?>
				<?php if ($content) : ?>				
					<div class="content-wrapper wow fadeInUp"><?php echo do_shortcode( $content ) ?></div>
				<?php endif; ?>
						
					<div class="listings-wrapper">
                    <?php
                    $args  = array(
                        'post_type' => 'listing',
                        'posts_per_page' => $slider
                    );
                    $query = new WP_Query( $args );                        
                    if ( $query->have_posts() ) : ?>
                        <div class="row">                        
                        <?php $n = 1;?>
                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
							<?php
							if ($n == 2) $animateClass = 'delay-lg-quarter-s';
							elseif ($n == 3) $animateClass = 'delay-lg-half-s';
							else  $animateClass = '';
							?>
                            <div class="col-lg-4 mb-30 wow fadeInLeft <?php echo $animateClass ?>">
                                <div class="wrap position-relative">
                                    <?php if(has_post_thumbnail()) : ?>
                                        <div class="img-listing-wrapper"><img src="<?php echo aq_resize(get_the_post_thumbnail_url(),350,250,true) ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ?>" class="img-fluid img-listing" width="350" height="250"></div>
                                    <?php endif; ?>
                                    <h4 class="title-listing text-theme"><?php echo get_the_title() ?></h4>
                                    <div class="address-listing"><?php echo get_field('business_address')?></div>
                                    <div class="category-listing"><span class="name">Category : </span> <span class="value text-theme-2"><?php echo get_field('business_category')?></span></div>
                                    <div class="time-listing">Opened <span class="days"><?php echo get_field('business_hours')['day'];?></span> <span class="text-theme"><?php echo get_field('business_hours')['time']; ?></span></div>
                                    <a href="<?php echo get_the_permalink() ?>" class="hidden-link">Read More</a>
                                </div>
                            </div>
                            <?php $n++; if ($n>3) $n=1; ?>
                        <?php endwhile; ?>
                        </div>
                    <?php endif;
                    wp_reset_postdata();    
                    ?>
                    <?php if ($link['text_field_1'] && $link['text_field_2']) : ?>
                    <div class="text-center"><a href="<?php echo esc_url(do_shortcode($link['text_field_2'])) ?>" class="btn bg-theme text-white"><?php echo do_shortcode($link['text_field_1']) ?></a></div>
                    <?php endif ?>
                    </div>
		<?php do_action( 'action_after_business', $page_details ); ?>
		</div>	
	</div>
</section>
<?php do_action( 'action_below_business', $page_details  ); ?>