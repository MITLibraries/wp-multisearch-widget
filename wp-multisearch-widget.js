function logSearch(element) {
	var search = new Object();

	// What form was submitted?
	search.target = element.dataset.target;

	// What was the search string?
	search.request = jQuery( element ).find( "input[type=text]").val();

	// What was the search type?
	search.type = jQuery( element ).find( "select" ).find(":selected").text();

	// Send search details to analytics
	discovery('send', {
		hitType: 'event',
		eventCategory: 'Wordpress',
		eventAction: 'Search',
		eventLabel: JSON.stringify( search )
	});

};

jQuery( document ).ready(function() {
	var $tabs = $('#multisearch');

	// If javascript is present, we disable the nojs class.
	$tabs.removeClass("nojs");

	// Call Responsive Tabs plugin.
	$tabs.responsiveTabs({
		rotate: false,
		startCollapsed: 'accordion',
		collapsible: false,
		setHash: true
	});

	jQuery( "#multisearch form" ).on( 'submit', function() {
		logSearch( this );
	});
});
