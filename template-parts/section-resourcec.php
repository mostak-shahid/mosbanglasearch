<?php 
global $mosbanglasearch_options; 
$class = $mosbanglasearch_options['sections-resourcec-class'];
$title = $mosbanglasearch_options['sections-resourcec-title'];
$content = $mosbanglasearch_options['sections-resourcec-content'];
$slides = $mosbanglasearch_options['sections-resourcec-slides'];
$page_details = array( 'id' => get_the_ID(), 'template_file' => basename( get_page_template() ));
do_action( 'action_avobe_resourcec', $page_details ); 
?>
<section id="section-resourcec" class="<?php if(@$mosbanglasearch_options['sections-resourcec-background-type'] == 1) echo @$mosbanglasearch_options['sections-resourcec-background'] . ' ';?><?php if(@$mosbanglasearch_options['sections-resourcec-color-type'] == 1) echo @$mosbanglasearch_options['sections-resourcec-color'];?> <?php echo $class ?>">
	<div class="content-wrap">
		<div class="container">
		<?php do_action( 'action_before_resourcec', $page_details ); ?>
				<?php if ($title) : ?>				
					<div class="title-wrapper wow fadeInDown">
						<h2 class="title"><?php echo do_shortcode( $title ); ?></h2>				
					</div>
				<?php endif; ?>
				<?php if ($content) : ?>				
					<div class="content-wrapper wow fadeInUp"><?php echo do_shortcode( $content ) ?></div>
				<?php endif; ?>
				<?php if ($slides) : ?>				
					<div class="slides-wrapper row">
                        <?php $n = 1;?>
                        <?php foreach($slides as $slide) : ?>
							<?php
							if ($n == 2) $animateClass = 'delay-lg-quarter-s';
							elseif ($n == 3) $animateClass = 'delay-lg-half-s';
							elseif ($n == 4) $animateClass = 'delay-three-quarter-s';
							else  $animateClass = '';
							?>
                            <div class="col-lg-3 col-md-6 mb-30 wow fadeInLeft <?php echo $animateClass ?>">
                                <div class="wrap text-center position-relative bg-white rounded smooth">
                                    <?php if ($slide['attachment_id']) : ?>
                                        <img src="<?php echo aq_resize(wp_get_attachment_url( $slide['attachment_id'] ),80,80,true)?>" alt="<?php echo get_post_meta( $slide['attachment_id'], '_wp_attachment_image_alt', true ) ?>" class="img-responsive img-slide mb-30" width="80" height="80">
                                    <?php endif;?>
					                <h4 class="slide-title"><?php echo do_shortcode($slide['title']) ?></h4>					                
                                    <?php if ($slide['description']) : ?>
					                    <div class="slide-description"><?php echo do_shortcode($slide['description']) ?></div>
                                    <?php endif;?>					                
                                    <?php if ($slide['link_url']) : ?>					                
					                    <a href="<?php echo esc_url(do_shortcode($slide['link_url'])) ?>" class="hidden-link">Read More</a>
                                    <?php endif;?>
                                </div>
                            </div>
                            <?php $n++; if ($n>4) $n=1; ?>
                        <?php endforeach; ?>
                    </div>
				<?php endif; ?>
		<?php do_action( 'action_after_resourcec', $page_details ); ?>
		</div>	
	</div>
</section>
<?php do_action( 'action_below_resourcec', $page_details  ); ?>