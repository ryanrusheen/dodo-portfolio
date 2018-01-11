<?php get_header(); ?>

<main class="content">	

	<?php //The Loop Begins Here
	if( have_posts() ):
		while( have_posts() ):
			the_post(); 
			?>
			<article <?php post_class('clearfix'); ?>>

				<?php the_post_thumbnail( 'large' ); ?>

				<h2 class="entry-title"> 
					<a href="<?php the_permalink(); ?>"> 
						<?php the_title(); ?> 
					</a>
				</h2>

				<h3>
					<?php the_terms( $post->ID, 'type_of_work'); ?>
				</h3>
				<h3>
					Client: <?php echo get_post_meta( $post->ID, 'client', true); ?>
					|
					Year: <?php echo get_post_meta( $post->ID, 'year', true); ?>
						
				</h3>


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
	
	<div class="pagination">
		<?php dodo_pagination(); ?>
	</div>

</main>
<!-- end #content -->

<?php get_sidebar(); //include sidebar.php ?>		

<?php get_footer(); //include footer.php ?>