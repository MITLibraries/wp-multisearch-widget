<?php
/**
 * The search tab for "more" content - which will search the Google custom engine.
 *
 * @package Multisearch Widget
 * @since 0.2.0
 */

?>

<p>Search the library website</p>
<form action="https://www.google.com/cse" method="get" data-target="google">
	<input type="hidden" name="cx" value="016240528703941589557:i7wrbu9cdxu">
	<input type="hidden" name="ie" value="UTF-8">
	<input type="text" name="q" placeholder="Search our site, location, guides, and support">
	<input type="submit" name="sa" value="Search">
</form>
<div class="row">
	<div>
		<p>Looking for something else?</p>
		<ul>
			<li><a href="/barton-reserves">Course reserves</a></li>
			<li><a href="/barton-theses">Theses</a></li>
			<li><a href="https://dspace.mit.edu">DSpace@MIT</a></li>
			<li><a href="https://dome.mit.edu">Image collections, including Dome</a></li>
			<li><a href="/search">Even more...</a></li>
		</ul>
	</div>
	<div>
		<p>Other useful tools</p>
		<ul>
			<li><a href="/libx">LibX browser plug-in</a></li>
			<li><a href="/ask">Ask Us chat</a></li>
		</ul>
	</div>
</div>
