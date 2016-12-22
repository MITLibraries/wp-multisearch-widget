<?php
/**
 * The search tab for journals and articles - which will switch between EDS
 * and Vera forms as the user changes the input[name=target] control.
 *
 * @package Multisearch Widget
 * @since 0.2.0
 */

?>

<div class="panel"></div>
<ul id="articles-target">
	<li><label><input type="radio" name="articles-target" value="eds" checked="checked">EDS</label></li>
	<li><label><input type="radio" name="articles-target" value="vera">Vera</label></li>
</ul>
<p>Also try: Browse journals by title, View article databases</p>
<script type="text/javascript">
function loadArticlesForm(choice,panel) {
	if ( 'vera' === choice ) {
		jQuery(panel).load("<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>form_vera.html");
	} else {
		jQuery(panel).load("<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>form_eds.html");
	}
}

jQuery( document ).ready( function() {
	// Set default form to Worldcat
	var atarget = jQuery("#articles-target input[name=articles-target]:checked").val();
	var apanel = jQuery("#search-articles .panel");

	// Load default form (set in markup)
	loadArticlesForm( atarget, apanel );

	// Detect target change, swap forms as needed
	jQuery("#articles-target input[name=articles-target]").on('change',function() {
		loadArticlesForm( this.value, apanel );
	});
});


</script>
