<?php
/**
 * The "EDS variant" of the search tab for books and media - which will switch
 * between Barton and Worldcat forms as the user changes the
 * input[name=target] control.
 *
 * @package Multisearch Widget
 * @since 0.2.0
 */

?>
<h3 class="sr">Books and media panel</h3>
<div class="panel">
	<form action="" id="booksearch" method="get" class="form search-bookslocal">
		<div class="hidden"></div>
		<label for="searchinput-bookslocal">Search for books, ebooks, audiobooks, music, and videos</label>
		<div class="wrap-flex">
			<div class="flex-left">
				<div class="flex-left-inner">
					<input
						class="field field-text"
						id="searchinput-bookslocal"
						name="search"
						placeholder="ex. carbon nanotubes, game design"
						type="text">
					<div class="field-wrap-select">
						<label class="sr" for="searchlimit-bookslocal">limit to</label>
						<select class="field field-select" id="searchlimit-bookslocal" name="limit">
							<option value="">Keyword</option>
							<option value="TI">Title</option>
							<option value="AU">Author</option>
						</select>
					</div>
				</div>
				<ul id="books-target" class="select-books-target">
					<li>
						<label>
							<input type="radio" name="books-target" value="localbooks" checked="checked">at MIT
						</label>
					</li>
					<li>
						<label>
							<input type="radio" name="books-target" value="worldcat">libraries worldwide
						</label>
					</li>
				</ul>
			</div>
			<div class="flex-right">
				<input class="button button-search" type="submit" value="Search">
			</div>
		</div>
	</form>
</div>
<p class="also">Also try:
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
		.empty()
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
	form.action = 'https://mit.on.worldcat.org/search';

	// Load hidden fields
	jQuery(form).find(".hidden")
		.empty()
		.append('<input type="hidden" name="queryString">');

	// Transfer search string to actual field
	form.queryString.value = form.search.value.trim();

	// Build search field with title/author syntax
	if ( form.limit.value !== '' ) {
		form.queryString.value = form.limit.value.toLowerCase() + ':(' + form.queryString.value + ')';
	}
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
