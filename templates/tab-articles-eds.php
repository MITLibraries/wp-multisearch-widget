<?php
/**
 * The "EDS variant" of the search tab for journals and articles - which will
 * switch between EDS and Vera forms as the user changes the
 * input[name=target] control.
 *
 * @package Multisearch Widget
 * @since 0.2.0
 */

?>
<h3 class="sr">Journals and Articles panel</h3>
<form
	class="form search-articles"
	action="https://widgets.ebscohost.com/prod/search/"
	id="edssearch"
	method="get"
	data-target="eds">
	<div class="hidden">
		<input name="direct" value="true" type="hidden">
		<input name="authtype" value="ip,guest" type="hidden">
		<input name="type" value="0" type="hidden">
		<input name="groupid" value="main" type="hidden">
		<input name="site" value="eds-live" type="hidden">
		<input name="profile" value="eds" type="hidden">
		<input name="custid" value="s8978330" type="hidden">
		<input name="bquery" value="" type="hidden">
		<input name="facet" value="AcademicJournals,Magazines" type="hidden">
	</div>
	<label for="searchinput-article">Search journals and articles</label>
	<div class="wrap-flex">
		<div class="flex-left">
			<div class="flex-left-inner">
				<input 
					class="field field-text" 
					type="text" 
					id="searchinput-article" 
					name="uquery" 
					placeholder="ex. journal of the american medical association, nuclear engineering">
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
		jQuery( 'form#edssearch' ).on( 'submit', function() {
			// EDS prepends a code to the search string to enable title
			// or author searching, so we assemble the search string on
			// submit.
			this.bquery.value = (this.limit.value + this.uquery.value);

			// Log search details
			logSearch( this );

			return true;
		});
	});
</script>
<p class="also">Also try: <a href="/vera">Vera: journals and databases</a></p>
