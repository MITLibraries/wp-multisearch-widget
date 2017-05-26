<?php
/**
 * The search tab for "more" content - which will search the Google custom engine.
 *
 * @package Multisearch Widget
 * @since 0.2.0
 */

?>

<div class="wrap-3cols">
	<div class="col col-1">
		<h3 class="header-col">Looking for something else?</h3>
		<ul>
			<li><a href="/barton-reserves">Course reserves</a></li>
			<li><a href="/barton-theses">Theses</a></li>
			<li><a href="https://dspace.mit.edu">DSpace@MIT</a></li>
			<li><a href="http://libraries.mit.edu/experts/">Subject guides</a></li>
			<li><a href="/search">More search options: images, data, etc.</a></li>
		</ul>
	</div>
	<div class="col col-2">
		<h3 class="header-col">Other useful tools</h3>
		<ul>
			<li><a href="/libx">LibX browser plug-in</a></li>
			<li><a href="http://libguides.mit.edu/google/googlescholar">Google Scholar for MIT</a></li>
		</ul>
	</div>
	<div class="col col-3">
		<h3 class="sr">Get help from a librarian</h3>
		<p class="wrap-askus">
			<a class="askus-link" href="https://libraries.mit.edu/ask">
				<span class="askus-name">Ask Us</span> 
				<span class="askus-desc">chat and email</span>
			</a>
		</p>
	</div>
</div>
<form class="form search-site" action="https://www.google.com/cse" method="get" data-target="google">
	<input type="hidden" name="cx" value="016240528703941589557:i7wrbu9cdxu">
	<input type="hidden" name="ie" value="UTF-8">
	<h3><label for="searchinput-site">Search the library website</label></h3>
	<div class="wrap-flex">
		<div class="flex-left">
			<input id="searchinput-site" class="field field-text" type="text" name="q" placeholder="Search our site, location, guides, and support">
		</div>
		<div class="flex-right">
			<input type="submit" class="button button-search" name="sa" value="Search">
		</div>
	</div>
</form>
