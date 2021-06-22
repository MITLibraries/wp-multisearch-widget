<?php
/**
 * The "Alma variant" of the search tab for articles and chapters. All
 * searches are sent to Primo, with the querystring updated based on user
 * choices.
 *
 * @package Multisearch Widget
 * @since 1.5.0
 */

?>
<h3 class="sr">Articles and chapters panel</h3>
<form
	class="form search-articles"
	action="https://mit.primo.exlibrisgroup.com/discovery/search"
	enctype="application/x-www-form-urlencoded; charset=utf-8"
	id="primosearch"
	method="get"
	data-target="eds">
	<div class="hidden">
		<input type="hidden" name="vid" value="01MIT_INST:MIT">
		<input type="hidden" name="tab" value="all">
		<input type="hidden" name="search_scope" value="cdi">
		<input type="hidden" name="lang" value="en">
		<input type="hidden" name="query" id="primoQuery">
	</div>
	<label for="searchinput-article">
		Search articles, book chapters, and more from scholarly journals, newspapers, and online collections
	</label>
	<div class="wrap-flex">
		<div class="flex-left">
			<div class="flex-left-inner">
				<input 
					class="field field-text" 
					type="text" 
					id="searchinput-article" 
					name="search" 
					placeholder="ex. game theory for control of optical networks, artificial intelligence, dresselhaus">
				<div class="field-wrap-select">
					<label class="sr" for="searchlimit-articles">limit to</label>
					<select class="field field-select" name="limit" id="searchlimit-articles">
						<option value="">Keyword</option>
						<option value="TI ">Title</option>
						<option value="AU ">Author</option>
					</select>
				</div>
			</div>
		</div>
		<div class="flex-right">
			<input class="button button-search" type="submit" value="Search">
		</div>
	</div>
</form>
<script type="text/javascript">
	jQuery( document ).ready( function() {
		jQuery( 'form#primosearch' ).on( 'submit', function() {
			// Primo uses comma-separated-values to influence search behavior for
			// keyword, title, and author searching. So we assemble the search 
			// string on submit.
			var searchtype = 'any';
			if ( this.limit.value.trim() == 'TI' ) {
				searchtype = 'title';
			} else if ( this.limit.value.trim() == 'AU' ) {
				searchtype = 'creator';
			}
			this.query.value = searchtype + ",contains," + this.search.value.replace(/[,]/g, " ");

			return true;
		});
	});
</script>
<p class="also">Also search for:
	<a href="/search-journals/">Journals</a> or
	<a href="/search-databases/">Databases</a>
</p>
