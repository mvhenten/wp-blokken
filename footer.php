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

<?php wp_footer(); ?>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script>
(function(){
	var tags = function(){
		var values = $( '#tag-filter input' ).filter(':checked').map(function(i,el){
			return $(el).val();
		});

		return values.toArray().join(',');
	};


	$('#tag-filter label').click(function(){
		$(this).toggleClass('active');
	});

	$('#tag-filter input').change(function(){
		$('#filter-tags').val( tags() );
	});

	$('#filter-tags').val( tags() );
})();
</script>
</body>
</html>