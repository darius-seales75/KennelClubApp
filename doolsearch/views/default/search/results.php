<h2><?php echo elgg_echo('drool_search:title'); ?></h2>

<?php
    // Retrieve the search input from the URL parameter
	    $search_input = get_input('search_input');
    
    // Display the search input on the page
    echo '<p>'.elgg_echo('search_bar:search_results', array($search_input)).'</p>';
?>
