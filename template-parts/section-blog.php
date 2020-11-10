<?php 
global $mosbanglasearch_options; 
$class = $mosbanglasearch_options['sections-blog-class'];
$title = $mosbanglasearch_options['sections-blog-title'];
$content = $mosbanglasearch_options['sections-blog-content'];
$slider = $mosbanglasearch_options['sections-blog-slider'];
$page_details = array( 'id' => get_the_ID(), 'template_file' => basename( get_page_template() ));
do_action( 'action_avobe_blog', $page_details ); 
?>
<section id="section-blog" class="<?php if(@$mosbanglasearch_options['sections-blog-background-type'] == 1) echo @$mosbanglasearch_options['sections-blog-background'] . ' ';?><?php if(@$mosbanglasearch_options['sections-blog-color-type'] == 1) echo @$mosbanglasearch_options['sections-blog-color'];?> <?php echo $class ?>">
	<div class="content-wrap">
		<div class="container">
		<?php do_action( 'action_before_blog', $page_details ); ?>
				<?php if ($title) : ?>				
					<div class="title-wrapper wow fadeInDown">
						<h2 class="title"><?php echo do_shortcode( $title ); ?></h2>				
					</div>
				<?php endif; ?>
				<?php if ($content) : ?>				
					<div class="content-wrapper wow fadeInUp"><?php echo do_shortcode( $content ) ?></div>
				<?php endif; ?>
				<?php if ($slider) : ?>				
					<div class="blogs-wrapper">
                    <?php
                    $args  = array(
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
                                <div class="wrap">
                                    <?php if(has_post_thumbnail()) : ?>
                                        <div class="img-blog-wrapper"><img src="<?php echo aq_resize(get_the_post_thumbnail_url(),350,250,true) ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ?>" class="img-fluid img-blog" width="350" height="250"></div>
                                    <?php endif; ?>
                                    <div class="date-blog"><?php echo get_the_date('F j Y')?></div>
                                    <h4 class="title-blog"><?php echo get_the_title() ?></h4>
                                    <div class="desc-blog"><?php echo wp_trim_words( get_the_content(), 20, '...' ) ?></div>
                                    <div class="link-blog"><a href="<?php echo get_the_permalink() ?>" class="btn btn-blog">Read More</a></div>
                                </div>
                            </div>
                            <?php $n++; if ($n>3) $n=1; ?>
                        <?php endwhile; ?>
                        </div>
                    <?php endif;
                    wp_reset_postdata();    
                    ?>
                    </div>
				<?php endif; ?>
		<?php do_action( 'action_after_blog', $page_details ); ?>
		</div>	
	</div>
</section>
<?php do_action( 'action_below_blog', $page_details  ); ?>