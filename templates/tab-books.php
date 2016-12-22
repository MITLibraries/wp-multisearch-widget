<?php
/**
 * The search tab for books and media - which will switch between Barton and
 * Worldcat forms as the user changes the input[name=target] control.
 *
 * @package Multisearch Widget
 * @since 0.2.0
 */

?>

<div class="panel"></div>
<ul id="books-target">
	<li><label><input type="radio" name="books-target" value="barton">Barton</label></li>
	<li><label><input type="radio" name="books-target" value="worldcat" checked="checked">Worldcat</label></li>
</ul>
<p>Also try:
	<a href="/bartonplus">BartonPlus</a>,
	<a href="/barton-reserves">Course reserves</a>,
	<a href="/barton-theses">Thesis</a>, or
	<a href="#search-more">view more search options</a>
</p>
<script type="text/javascript">
function loadBooksForm(choice,panel) {
	if ( 'barton' === choice ) {
		jQuery(panel).load("<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>form_barton.html");
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
