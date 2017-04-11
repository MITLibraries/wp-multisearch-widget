<?php
/**
 * The search tab for books and media - which will switch between Barton and
 * Worldcat forms as the user changes the input[name=target] control.
 *
 * @package Multisearch Widget
 * @since 0.2.0
 */

?>
<p>Books, ebooks, audio books, music, and videos</p>
<div class="panel"></div>
<ul id="books-target">
	<li><label><input type="radio" name="books-target" value="localbooks">at MIT</label></li>
	<li>
		<label><input type="radio" name="books-target" value="worldcat" checked="checked">libraries worldwide</label>
	</li>
</ul>
<p>Also try:
	<a href="/barton">Barton Classic</a>,
	<a href="/barton-theses">Theses</a>, or
	<a href="/barton-reserves">Course reserves</a>
</p>
<script type="text/javascript">
function loadBooksForm(choice,panel) {
	if ( 'localbooks' === choice ) {
		jQuery(panel).load("<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>form_localbooks.html");
	} else {
		jQuery(panel).load("<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>form_worldcat.html");
	}
}

jQuery( document ).ready( function() {
	// Set default form to Worldcat
	var btarget = jQuery("#books-target input[name=books-target]:checked").val();
	var bpanel = jQuery("#search-books .panel");

	// Load default form (set in markup)
	loadBooksForm( btarget, bpanel );

	// Detect target change, swap forms as needed
	jQuery("#books-target input[name=books-target]").on('change',function() {
		loadBooksForm( this.value, bpanel );
	});

});
</script>
