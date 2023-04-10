<?php

require_once('path/to/drools-api.jar');

use org.drools.core.command.runtime.rule.*;
use org.drools.core.command.*;
use org.kie.api.*;
use org.kie.api.runtime.*;
use org.kie.api.runtime.rule.*;
// Create a new KnowledgeBase
$kb = KnowledgeBaseFactory::newKnowledgeBase();

// Load the rules from the DRL file
$builder = KnowledgeBuilderFactory::newKnowledgeBuilder();
$builder->add('path/to/rules.drl', ResourceType::DRL);
if ($builder->hasErrors()) {
    throw new Exception("Failed to parse DRL file");
}
$kb->addKnowledgePackages($builder->getKnowledgePackages());

elgg_register_event_handler('init', 'system', 'drool_search_init');

function drool_searchsearch_init() {
    elgg_register_page_handler('search', 'drool_search_page_handler');
}

function drool_search_page_handler($segments) {
    // Check if the search form was submitted
    if (elgg_is_sticky_form('search')) {
        // Get the input from the search form
        $search_input = get_input('search_input');
        
        // Insert the search input into the Drools rules engine
        // Create a new session
		$session = $kb->newStatefulKnowledgeSession();

		// Get input from search bar
		$searchInput = $_GET['searchInput'];

		// Insert input into session as a fact
		$session->insert($searchInput);

		// Fire all rules
		$session->fireAllRules();

		// Dispose the session
		$session->dispose();
	
        // Redirect the user to the search results page
        forward("search/results?search_input=$search_input");
    }
    
    // Generate the search form HTML
    $form_body = elgg_view_form('search', array(
        'action' => 'search',
        'method' => 'GET'
    ), array(
        'search_input' => array(
            '#type' => 'text',
            '#label' => elgg_echo('search_bar:search_label'),
            '#value' => elgg_get_sticky_value('search', 'search_input')
        ),
        'submit' => array(
            '#type' => 'submit',
            '#value' => elgg_echo('search_bar:search_button')
        )
    ));
    
    // Generate the page HTML
    $page_data = array(
        'title' => elgg_echo('search_bar:title'),
        'content' => $form_body,
        'filter' => ''
    );
    
    return elgg_view_page(elgg_echo('search_bar:title'), elgg_view_layout('content', $page_data));
}
