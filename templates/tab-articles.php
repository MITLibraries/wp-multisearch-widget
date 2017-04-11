<?php
/**
 * The search tab for journals and articles - which will switch between EDS
 * and Vera forms as the user changes the input[name=target] control.
 *
 * @package Multisearch Widget
 * @since 0.2.0
 */

?>
<p>Search journals and articles</p>
<form action="https://widgets.ebscohost.com/prod/search/" id="edssearch" method="get" data-target="eds">
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
	<input type="text" name="uquery" placeholder="Search journals and articles...">
	<select name="limit">
		<option value="">Keyword</option>
		<option value="TI ">Title</option>
		<option value="AU ">Author</option>
	</select>
	<input type="submit" value="Search">
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
<p>Also try: <a href="/vera">Vera: journals and databases</a></p>
