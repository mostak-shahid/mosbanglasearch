<?php 
global $mosbanglasearch_options; 
$class = $mosbanglasearch_options['sections-pcategory-class'];
$title = $mosbanglasearch_options['sections-pcategory-title'];
$content = $mosbanglasearch_options['sections-pcategory-content'];
$slides = $mosbanglasearch_options['sections-pcategory-slides'];
$link = $mosbanglasearch_options['sections-pcategory-link'];
$page_details = array( 'id' => get_the_ID(), 'template_file' => basename( get_page_template() ));
do_action( 'action_avobe_pcategory', $page_details ); 
?>
<section id="section-pcategory" class="<?php if(@$mosbanglasearch_options['sections-pcategory-background-type'] == 1) echo @$mosbanglasearch_options['sections-pcategory-background'] . ' ';?><?php if(@$mosbanglasearch_options['sections-pcategory-color-type'] == 1) echo @$mosbanglasearch_options['sections-pcategory-color'];?> <?php echo $class ?>">
	<div class="content-wrap">
		<div class="container">
		<?php do_action( 'action_before_pcategory', $page_details ); ?>
				<?php if ($title) : ?>				
					<div class="title-wrapper wow fadeInDown">
						<h2 class="title"><?php echo do_shortcode( $title ); ?></h2>				
					</div>
				<?php endif; ?>
				<?php if ($content) : ?>				
					<div class="content-wrapper wow fadeInUp"><?php echo do_shortcode( $content ) ?></div>
				<?php endif; ?>
				<?php if ($slides) : ?>				
					<div class="slides-wrapper pcategory-owl-carousel owl-carousel owl-theme">
					    <?php foreach($slides as $id => $slide) : ?>
					        <div class="item item-<?php echo $id ?>">
					            <div class="wrap text-center position-relative">
                                    <?php if ($slide['attachment_id']) : ?>
                                        <img src="<?php echo aq_resize(wp_get_attachment_url( $slide['attachment_id'] ),121,121,true)?>" alt="<?php echo get_post_meta( $slide['attachment_id'], '_wp_attachment_image_alt', true ) ?>" class="img-responsive img-slide" width="121" height="121">
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
					    <?php endforeach ?>
					</div>
				<?php endif; ?>
				<?php if ($link['text_field_1'] && $link['text_field_2']) : ?>				
					<div class="link-wrapper text-center wow fadeInUp"><a href="<?php echo esc_url(do_shortcode($link['text_field_2'])) ?>" class="btn btn-pcategory bg-theme text-white"><?php echo do_shortcode( $link['text_field_1'] ) ?></a></div>
				<?php endif; ?>
		<?php do_action( 'action_after_pcategory', $page_details ); ?>
		</div>	
	</div>
</section>
<?php do_action( 'action_below_pcategory', $page_details  ); ?>