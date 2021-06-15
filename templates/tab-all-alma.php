<?php
/**
 * The "Alma variant" of the search tab for all content - which will search the Bento app.
 *
 * @package Multisearch Widget
 * @since 1.5.0
 */

?>
<h3 class="sr">All panel</h3>
<form
	class="form search-bento"
	action="<?php echo esc_url( $instance['bento_url'] ); ?>search/bento"
	method="get"
	data-target="bento">
	<label for="searchinput-bento">Search the libraries</label>
	<div class="wrap-flex">
		<div class="flex-left">
			<input
				class="field field-text"
				type="text"
				id="searchinput-bento"
				name="q"
				placeholder="ex. artificial intelligence, journal of heat transfer, jstor, dresselhaus">
		</div>
		<div class="flex-right">
			<input class="button button-search" type="submit" value="Search">
		</div>
	</div>
</form>
<p class="also search-all">
	<a href="/search-advanced/">Advanced search</a>
</p>
