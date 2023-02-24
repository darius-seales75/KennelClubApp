<?php

namespace Elgg\Marketplace;

use Elgg\Database\Seeds\Seed;

/**
 * Add marketplace seed
 *
 * @internal
 */
class Seeder extends Seed {

	private $status = [
		'draft',
		'published',
	];

	/**
	 * {@inheritdoc}
	 */
	public function seed() {
		$this->advance($this->getCount());

		$attributes = [
			'subtype' => 'marketplace',
		];

		while ($this->getCount() < $this->limit) {
			$metadata = [
				'status' => $this->getRandomStatus(),
				'comments_on' => $this->faker()->boolean() ? 'On' : 'Off',
				'breed' => $this->faker()->sentence(),
			];

			$marketplace = $this->createObject($attributes, $metadata);
			if (!$marketplace) {
				continue;
			}

			$this->createComments($marketplace);
			$this->createLikes($marketplace);

			if ($marketplace->status === 'draft') {
				$marketplace->future_access = $marketplace->access_id;
				$marketplace->access_id = ACCESS_PRIVATE;
			}

			if ($marketplace->status === 'published') {
				elgg_create_river_item([
					'view' => 'river/object/marketplace/create',
					'action_type' => 'create',
					'subject_guid' => $marketplace->owner_guid,
					'object_guid' => $marketplace->guid,
					'target_guid' => $marketplace->container_guid,
					'posted' => $marketplace->time_created,
				]);

				elgg_trigger_event('publish', 'object', $marketplace);
			}

			if ($this->faker()->boolean()) {
				$marketplace->annotate('marketplace_auto_save', $this->faker()->text(500), ACCESS_PRIVATE, $marketplace->owner_guid);
			}

			if ($this->faker()->boolean()) {
				$marketplace->annotate('marketplace_revision', $marketplace->description, ACCESS_PRIVATE, $marketplace->owner_guid);
				$marketplace->description = $this->faker()->text(500);
			}

			$marketplace->save();

			$this->advance();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function unseed() {

		/* @var $marketplaces \ElggBatch */
		$marketplaces = elgg_get_entities([
			'type' => 'object',
			'subtype' => 'marketplace',
			'metadata_name' => '__faker',
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
		]);

		/* @var $marketplace \ElggMarketplace */
		foreach ($marketplaces as $marketplace) {
			if ($marketplace->delete()) {
				$this->log("Deleted marketplace {$marketplace->guid}");
			} else {
				$this->log("Failed to delete marketplace {$marketplace->guid}");
			}

			$this->advance();
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getType() : string {
		return 'marketplace';
	}

	/**
	 * Returns random marketplace status
	 * @return string
	 */
	public function getRandomStatus() {
		$key = array_rand($this->status, 1);

		return $this->status[$key];
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getCountOptions() : array {
		return [
			'type' => 'object',
			'subtype' => 'marketplace',
		];
	}
}
