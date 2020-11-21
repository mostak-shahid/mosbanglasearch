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
                        <div class="listing-category mb-30"><h4 class="job-category"><?php echo get_field('sale_post_type') ?></h4></div>                      
                    </div>
                    <div class="col-lg-6">
                        <div class="listing-search mb-30"><?php echo do_shortcode('[business-search-form]') ?></div>
                    </div>
                </div>
                <div class="content">                    
                    <?php if ( have_posts() ) :?>
                        <h5 class="text-theme font-weight-700"><?php echo get_the_title() ?></h5>
                        <div class="row no-gutters text-white mb-15">
                            <div class="col-lg-3 col-md-6 bg-theme-dark text-center py-3">Only<br/>N/A</div>
                            <div class="col-lg-3 col-md-6 bg-theme text-center py-3">Only<br/>N/A</div>
                            <div class="col-lg-3 col-md-6 bg-theme-dark text-center py-3">Only<br/>N/A</div>
                            <div class="col-lg-3 col-md-6 bg-theme text-center py-3">Only<br/>N/A</div>
                        </div>
                        <div class="sale-owl-carousel owl-carousel owl-theme mb-30">
                        <?php if(get_field('sale_gallery')): ?>
                            <?php $ids = explode(',',get_field('sale_gallery')); ?>
                            <?php foreach($ids as $attachment_id): ?>
                                <img src="<?php echo aq_resize(wp_get_attachment_url( $attachment_id ), 1110, 600, true) ?>" alt="<?php echo get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ?>" width="1110" height="600">
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </div>
                        <h4 class="text-theme font-weight-700">Description</h4>
                        <div class="text-muted"><?php the_content() ?></div>
                        <h4 class="text-theme font-weight-700">Fine Print</h4>
                        <div class="text-muted">
                            <p>Give us a call, email or simply drop at our display site. If you have already ordered or shop from our site, you can always Click &amp; Collect.</p>
                            <?php if (get_field('sale_phone')) : ?>
                                <p><strong>Telephone Number:</strong> <a href="<?php echo str_replace(' ', '', get_field('sale_phone')) ?>" class="text-muted"><?php echo get_field('sale_phone') ?></a></p>
                            <?php endif;?>
                            <?php if (get_field('sale_email')) : ?>
                                <p><strong>Email:</strong> <a href="mailto:<?php echo get_field('sale_email') ?>" class="text-muted"><?php echo get_field('sale_email') ?></a></p>
                            <?php endif;?>
                            <?php if (get_field('sale_address')) : ?>
                                <p><strong>Address:</strong> <?php echo get_field('sale_address') ?></p>
                            <?php endif;?>
                            <?php if (get_field('sale_date')) : ?>
                                <p><strong>Last Date:</strong> <?php echo get_field('sale_date') ?></p>
                            <?php endif;?>
                            <?php if (get_field('sale_opening_hours')) : ?>
                                <p><strong>Our Opening Hours:</strong></p>                                
                                <?php echo get_field('sale_opening_hours') ?>
                            <?php endif;?>
                            <?php if (get_field('sale_notes')) : ?>
                                <p><strong>Note:</strong> <?php echo get_field('sale_notes') ?></p> 
                            <?php endif;?>                          
                        </div>
                        <?php if (get_field('sale_notes')) : ?>
                            <div class="embed-responsive embed-responsive-21by9">
                                <iframe class="embed-responsive-item" src="<?php echo get_field('sale_embedded_map') ?>"></iframe>
                            </div>
                        <?php endif?>
                        <h4 class="text-theme font-weight-700">Contact the Owner!</h4>
                        <?php echo do_shortcode('[formidable id=2]')?>
                    <?php endif;?> 
                </div>
			<?php do_action( 'action_after_content', $page_details  ); ?>
		</div>	
	</div>
</section>
<hr>
<?php do_action( 'action_below_content', $page_details  ); ?>
<?php if($sections ) { foreach ($sections as $key => $value) { get_template_part( 'template-parts/section', $key );}}?>
<?php get_footer() ?>