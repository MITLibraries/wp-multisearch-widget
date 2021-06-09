<?php
/**
 * The "Alma variant" of the search tab for books and media - which will
 * switch between Primo and Worldcat forms as the user changes the
 * input[name=target] control.
 *
 * @package Multisearch Widget
 * @since 1.5.0
 */

?>
<h3 class="sr">Books and media panel</h3>
<form
	action=""
	id="booksearch"
	method="get"
	class="form search-bookslocal">
	<div class="hidden"></div>
	<label for="searchinput-bookslocal">Search for books, ebooks, journals, databases, music, and videos</label>
	<div class="wrap-flex">
		<div class="flex-left">
			<div class="flex-left-inner">
				<input
					class="field field-text"
					id="searchinput-bookslocal"
					name="search"
					placeholder="ex. artificial intelligence, journal of heat transfer, jstor, dresselhaus"
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
						<input type="radio" name="books-target" value="worldcat">libraries worldwide (WorldCat)
					</label>
				</li>
			</ul>
		</div>
		<div class="flex-right">
			<input class="button button-search" type="submit" value="Search">
		</div>
	</div>
</form>
<p class="also">Also search for:
	<a href="/search-mit-theses/">MIT theses</a> or
	<a href="/search-reserves/">Course reserves</a>
</p>
<script type="text/javascript">
function setPrimoSearch(form) {
	// Set action
	form.action = 'https://mit.primo.exlibrisgroup.com/discovery/search';

	// Load hidden fields
	jQuery(form).find(".hidden")
		.empty()
		.append('<input name="vid" value="01MIT_INST:MIT" type="hidden">')
		.append('<input name="tab" value="all" type="hidden">')
		.append('<input name="search_scope" value="catalog" type="hidden">')
		.append('<input name="lang" value="en" type="hidden">')
		.append('<input name="query" type="hidden">');

	// Build search field
	var searchtype = 'any';
	if ( form.limit.value == 'TI' ) {
		searchtype = 'title';
	} else if ( form.limit.value == 'AU' ) {
		searchtype = 'creator';
	}
	form.query.value = searchtype + ",contains," + form.search.value.replace(/[,]/g, " ");
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
			setPrimoSearch(this);
		}
	});
});
</script>
