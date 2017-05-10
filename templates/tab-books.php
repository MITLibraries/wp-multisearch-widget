<?php
/**
 * The search tab for books and media - which will switch between Barton and
 * Worldcat forms as the user changes the input[name=target] control.
 *
 * @package Multisearch Widget
 * @since 0.2.0
 */

?>
<ul id="books-target" class="select-books-target">
	<li><button class="button-search" data-target="localbooks" data-default="true">at MIT</button></li>
	<li><button class="button-search" data-target="worldcat">libraries worldwide</button></li>
</ul>
<p>Books, ebooks, audio books, music, and videos</p>
<div class="panel"></div>
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
	var btarget = jQuery("#books-target .button-search[data-default='true']").data('target');
	var bpanel = jQuery("#search-books .panel");

	// Load default form (set in markup)
	loadBooksForm( btarget, bpanel );

	// Detect target change, swap forms as needed
	jQuery("#books-target .button-search").on('click',function() {
		loadBooksForm( jQuery(this).data('target'), bpanel );
	});

});
</script>
