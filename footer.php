<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Blokken 1.0
 */
?>

<script>
(function(){
	var selector = '#tag-filter label';

	$(selector).click(function(){ 
		$(selector).removeClass('active'); 
		$(this).addClass('active'); 
	});
})();


</script>

	<?php wp_footer(); ?>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
</body>
</html>