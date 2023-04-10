<?php

/**
 * Performs a search for the given query.
 *
 * @param string $query The search query.
 * @return array An array of search results.
 */
function drool_search_search($query) {
    // Create a new KieServices instance
    $kieServices = KieServices_Factory::get();

    // Load the rules from the classpath
    $kContainer = $kieServices->getKieClasspathContainer();

    // Get a session from the container
    $kSession = $kContainer->newKieSession();

    // Insert the query into the session
    $queryFact = new QueryFact($query);
    $kSession->insert($queryFact);

    // Fire the rules
    $kSession->fireAllRules();

    // Retrieve the search results from the session
    $searchResults = $kSession->getObjects(new ClassObjectFilter(SearchResult::class));

    // Convert the search results to a format suitable for display
    $results = [];
    foreach ($searchResults as $result) {
        $entity = new ElggObject();
        $entity->subtype = 'search_result';
        $entity->title = $result->getTitle();
        $entity->description = $result->getDescription();
        $entity->setURL($result->getURL());

        $results[] = $entity;
    }

    return $results;
}

