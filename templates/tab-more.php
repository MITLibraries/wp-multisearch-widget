<?php
/**
 * The search tab for "more" content - which will search the Google custom engine.
 *
 * @package Multisearch Widget
 * @since 0.2.0
 */

?>

<div class="flex-container">
	<div class="col-1">
		<p>Looking for something else?</p>
		<ul>
			<li><a href="/barton-reserves">Course reserves</a></li>
			<li><a href="/barton-theses">Theses</a></li>
			<li><a href="https://dspace.mit.edu">DSpace@MIT</a></li>
			<li><a href="/search">More search options: images, data, etc.</a></li>
		</ul>
	</div>
	<div class="col-2">
		<p>Other useful tools</p>
		<ul>
			<li><a href="/libx">LibX browser plug-in</a></li>
			<li><a href="http://libguides.mit.edu/google/googlescholar">Google Scholar for MIT</a></li>
			<li><a href="/ask">Ask Us: chat and email</a></li>
		</ul>
	</div>
</div>
<p>Search the library website</p>
<form action="https://www.google.com/cse" method="get" data-target="google">
	<input type="hidden" name="cx" value="016240528703941589557:i7wrbu9cdxu">
	<input type="hidden" name="ie" value="UTF-8">
	<input type="text" name="q" placeholder="Search our site, location, guides, and support">
	<input type="submit" name="sa" value="Search">
</form>
