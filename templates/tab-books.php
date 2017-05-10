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
<div class="panel">
	<form action="" id="booksearch" method="get">
		<div class="hidden"></div>
		<input type="text" name="search" placeholder="Search books, films, music scores...">
		<ul id="books-target" class="select-books-target">
			<li><label><input type="radio" name="books-target" value="localbooks" checked="checked">at MIT</label></li>
			<li><label><input type="radio" name="books-target" value="worldcat">libraries worldwide</label></li>
		</ul>
		<select name="limit">
			<option value="">Keyword</option>
			<option value="TI">Title</option>
			<option value="AU">Author</option>
		</select>
		<input type="submit" value="Search">
	</form>
</div>
<p>Also try:
	<a href="/barton">Barton Classic</a>,
	<a href="/barton-theses">Theses</a>, or
	<a href="/barton-reserves">Course reserves</a>
</p>
<script type="text/javascript">
function setBartonSearch(form) {
	// Set action
	form.action = 'https://widgets.ebscohost.com/prod/search/';

	// Load hidden fields
	jQuery(form).find(".hidden")
		.append('<input name="direct" value="true" type="hidden">')
		.append('<input name="authtype" value="ip,guest" type="hidden">')
		.append('<input name="type" value="0" type="hidden">')
		.append('<input name="groupid" value="main" type="hidden">')
		.append('<input name="site" value="eds-live" type="hidden">')
		.append('<input name="profile" value="eds" type="hidden">')
		.append('<input name="custid" value="s8978330" type="hidden">')
		.append('<input name="bquery" type="hidden">')
		.append('<input name="facet" ' +
			'           value="Books,eBooks,Audiobooks,Dissertations,MusicScores,Audio,Videos" ' +
			'           type="hidden">');

	// Build search field
	form.bquery.value = (form.limit.value + ' ' + form.search.value).trim();
}

function setWorldcatSearch(form) {
	// Set action
	form.action = 'https://mit.worldcat.org/search';

	// Load hidden fields
	jQuery(form).find(".hidden")
		.append('<input type="hidden" name="qt" value="wc_org_mit">')
		.append('<input type="hidden" name="qt" value="affiliate">')
		.append('<input type="hidden" name="q">');

	// Build search field
	var limit = '';
	if ( form.limit.value !== '' ) {
		limit = form.limit.value.toLowerCase() + ':';
	}
	form.q.value = (limit + form.search.value).trim();
}

jQuery( document ).ready( function() {
	// Watch for form submissions
	jQuery( 'form#booksearch' ).on( 'submit', function(event) {
		// Read state of target
		var target = jQuery("#books-target input[name=books-target]:checked").val();

		if ( 'worldcat' === target ) {
			setWorldcatSearch(this);
		} else {
			setBartonSearch(this);
		}

		// Log search details
		logSearch( this );
	});
});
</script>
