<?php get_header(); ?>

<main class="content">


	<?php //display the output of the slider plugin
	if( function_exists('rdr_slider') ):
	rdr_slider();
	endif;
	 ?>	


	<?php //The Loop Begins Here
	if( have_posts() ):
		while( have_posts() ):
			the_post(); 
			?>
			<article class="post">
				<h2 class="entry-title"> 
					<a href="<?php the_permalink(); ?>"> 
						<?php the_title(); ?> 
					</a>
				</h2>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
				
			</article>
			<!-- end .post -->

			<?php 
		endwhile;
	else:
		echo 'Sorry, there are no posts to show';
	endif; 
			//end of The Loop
	?>


	<?php 
	//show me 'featured' piece from the portfolio
	$featured_work = new WP_Query( array(
			'post-type' => 'portfolio_piece',
			'posts_per_page' => 1,
			//example of a tax_query
			'tax_query' => array(
				array(
					'taxonomy' => 'type_of_work',
					'field' => 'slug',
					'terms' => 'portraits',
				),
			),


	) );

	if( $featured_work->have_posts() ):
	?>
	<section class="featured-work">
		<h2>Featured work</h2>
		<?php while( $featured_work->have_posts() ): 
				$featured_work->the_post();
		?>
		<div class="the-work">
			<div class="image-overlay">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('banner'); ?>
				</a>
			<h3>TITLE</h3>
			</div>
			<?php the_excerpt(); ?>
		</div>
	<?php endwhile; ?>
	</section>
<?php else: ?>
	No portfolio Peices to show
<?php endif;
wp_reset_postdata();
?>

<?php //show portfolio pieces from each "work type" (taxonomy terms)
$work_types = get_terms( 'type_of_work' );
// echo '<pre>';
// print_r( $work_types ); 
// echo '</pre>';

foreach( $work_types as $type ):
	//get one post in this term
	$custom_query = new WP_Query( array(
		'post_type' => 'portfolio_piece',
		'posts_per_page' => 2,
		'tax_query' => array(
			array(
				'taxonomy' => 'type_of_work',
				'field' => 'slug',
				'terms' => $type->slug,

			),

		),

	) );
	if( $custom_query->have_posts() ):
?>
<div class="work-type">
	<h2><?php echo $type->name; ?></h2>
	<?php while( $custom_query->have_posts() ): 
	$custom_query->the_post();
	?>
	<div class="portfolio-piece">
		<a href="<?php get_term_link( $type ); ?>">
		<?php the_post_thumbnail( 'big_thumbnail' ); ?>
		</a>
	</div>
<?php endwhile; ?>
</div>


<?php
endif;	
endforeach;	
?>

</main>
<!-- end #content -->

<?php get_sidebar( 'home' ); //include sidebar-home.php ?>		

<?php get_footer(); //include footer.php ?>