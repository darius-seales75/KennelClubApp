<?php

use Elgg\Marketplace\GroupToolContainerLogicCheck;
use Elgg\Marketplace\Notifications\PublishMarketplaceEventHandler;

require_once(__DIR__ . '/lib/functions.php');

return [
	'plugin' => [
		'name' => 'Marketplace',
		'activate_on_install' => true,
	],
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'marketplace',
			'class' => 'ElggMarketplace',
			'capabilities' => [
				'commentable' => true,
				'searchable' => true,
				'likable' => true,
			],
		],
	],
	'actions' => [
		'marketplace/save' => [],
		'marketplace/auto_save_revision' => [],
	],
	'routes' => [
		'collection:object:marketplace:owner' => [
			'path' => '/marketplace/owner/{username?}/{lower?}/{upper?}',
			'resource' => 'marketplace/owner',
			'requirements' => [
				'lower' => '\d+',
				'upper' => '\d+',
			],
		],
		'collection:object:marketplace:friends' => [
			'path' => '/marketplace/friends/{username?}/{lower?}/{upper?}',
			'resource' => 'marketplace/friends',
			'requirements' => [
				'lower' => '\d+',
				'upper' => '\d+',
			],
			'required_plugins' => [
				'friends',
			],
		],
		'collection:object:marketplace:archive' => [
			'path' => '/marketplace/archive/{username?}/{lower?}/{upper?}',
			'resource' => 'marketplace/owner',
			'requirements' => [
				'lower' => '\d+',
				'upper' => '\d+',
			],
		],
		'view:object:marketplace' => [
			'path' => '/marketplace/view/{guid}/{title?}',
			'resource' => 'marketplace/view',
		],
		'add:object:marketplace' => [
			'path' => '/marketplace/add/{guid?}',
			'resource' => 'marketplace/add',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'edit:object:marketplace' => [
			'path' => '/marketplace/edit/{guid}/{revision?}',
			'resource' => 'marketplace/edit',
			'requirements' => [
				'revision' => '\d+',
			],
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'collection:object:marketplace:group' => [
			'path' => '/marketplace/group/{guid}/{subpage?}/{lower?}/{upper?}',
			'resource' => 'marketplace/group',
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
		'collection:object:marketplace:all' => [
			'path' => '/marketplace/all/{lower?}/{upper?}',
			'resource' => 'marketplace/all',
			'requirements' => [
				'lower' => '\d+',
				'upper' => '\d+',
			],
		],
		'default:object:marketplace' => [
			'path' => '/marketplace',
			'resource' => 'marketplace/all',
		],
	],
	'hooks' => [
		'container_logic_check' => [
			'object' => [
				GroupToolContainerLogicCheck::class => [],
			],
		],
		'register' => [
			'menu:marketplace_archive' => [
				'Elgg\Marketplace\Menus\MarketplaceArchive::register' => [],
			],
			'menu:owner_block' => [
				'Elgg\Marketplace\Menus\OwnerBlock::registerUserItem' => [],
				'Elgg\Marketplace\Menus\OwnerBlock::registerGroupItem' => [],
			],
			'menu:site' => [
				'Elgg\Marketplace\Menus\Site::register' => [],
			],
			'menu:title:object:marketplace' => [
				\Elgg\Notifications\RegisterSubscriptionMenuItemsHandler::class => [],
			],
		],
		'seeds' => [
			'database' => [
				'Elgg\Marketplace\Seeder::register' => [],
			],
		],
	],
	'widgets' => [
		'marketplace' => [
			'context' => ['profile', 'dashboard'],
		],
	],
	'group_tools' => [
		'marketplace' => [],
	],
	'notifications' => [
		'object' => [
			'marketplace' => [
				'publish' => PublishMarketplaceEventHandler::class,
			],
		],
	],
];
