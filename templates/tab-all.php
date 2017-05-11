<?php
/**
 * The search tab for all content - which will search the Bento app.
 *
 * @package Multisearch Widget
 * @since 0.2.0
 */

?>

<form class="form search-bento" action="https://lib.mit.edu/search/bento" method="get" data-target="bento">
	<label for="searchinput-bento">Search the libraries</label>
	<input class="field field-text" type="text" id="searchinput-bento" name="q" placeholder="Search books, journal articles, films...">
	<input class="button button-search" type="submit" value="Search">
</form>
