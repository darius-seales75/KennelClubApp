<?php

use Elgg\Listing\GroupToolContainerLogicCheck;
use Elgg\Listing\Notifications\PublishListingEventHandler;

require_once(__DIR__ . '/lib/functions.php');

return [
	'plugin' => [
		'name' => 'Marketplace',
		'activate_on_install' => true,
	],
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'listing',
			'class' => 'ElggListing',
			'capabilities' => [
				'commentable' => true,
				'searchable' => true,
				'likable' => true,
			],
		],
	],
	'actions' => [
		'listing/save' => [],
		'listing/auto_save_revision' => [],
	],
	'routes' => [
		'collection:object:listing:owner' => [
			'path' => '/listing/owner/{username?}/{lower?}/{upper?}',
			'resource' => 'listing/owner',
			'requirements' => [
				'lower' => '\d+',
				'upper' => '\d+',
			],
		],
		'collection:object:listing:friends' => [
			'path' => '/listing/friends/{username?}/{lower?}/{upper?}',
			'resource' => 'listing/friends',
			'requirements' => [
				'lower' => '\d+',
				'upper' => '\d+',
			],
			'required_plugins' => [
				'friends',
			],
		],
		'collection:object:listing:archive' => [
			'path' => '/listing/archive/{username?}/{lower?}/{upper?}',
			'resource' => 'listing/owner',
			'requirements' => [
				'lower' => '\d+',
				'upper' => '\d+',
			],
		],
		'view:object:listing' => [
			'path' => '/listing/view/{guid}/{title?}',
			'resource' => 'listing/view',
		],
		'add:object:listing' => [
			'path' => '/listing/add/{guid?}',
			'resource' => 'listing/add',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'edit:object:listing' => [
			'path' => '/listing/edit/{guid}/{revision?}',
			'resource' => 'listing/edit',
			'requirements' => [
				'revision' => '\d+',
			],
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'collection:object:listing:group' => [
			'path' => '/listing/group/{guid}/{subpage?}/{lower?}/{upper?}',
			'resource' => 'listing/group',
			'defaults' => [
				'subpage' => 'all',
			],
			'requirements' => [
				'subpage' => 'all|archive',
				'lower' => '\d+',
				'upper' => '\d+',
			],
			'required_plugins' => [
				'groups',
			],
		],
		'collection:object:listing:all' => [
			'path' => '/listing/all/{lower?}/{upper?}',
			'resource' => 'listing/all',
			'requirements' => [
				'lower' => '\d+',
				'upper' => '\d+',
			],
		],
		'default:object:listing' => [
			'path' => '/listing',
			'resource' => 'listing/all',
		],
	],
	'hooks' => [
		'container_logic_check' => [
			'object' => [
				GroupToolContainerLogicCheck::class => [],
			],
		],
		'register' => [
			'menu:listing_archive' => [
				'Elgg\Listing\Menus\ListingArchive::register' => [],
			],
			'menu:owner_block' => [
				'Elgg\Listing\Menus\OwnerBlock::registerUserItem' => [],
				'Elgg\Listing\Menus\OwnerBlock::registerGroupItem' => [],
			],
			'menu:site' => [
				'Elgg\Listing\Menus\Site::register' => [],
			],
			'menu:title:object:listing' => [
				\Elgg\Notifications\RegisterSubscriptionMenuItemsHandler::class => [],
			],
		],
		'seeds' => [
			'database' => [
				'Elgg\Listing\Seeder::register' => [],
			],
		],
	],
	'widgets' => [
		'listing' => [
			'context' => ['profile', 'dashboard'],
		],
	],
	'group_tools' => [
		'listing' => [],
	],
	'notifications' => [
		'object' => [
			'listing' => [
				'publish' => PublishListingEventHandler::class,
			],
		],
	],
];
