<?php

namespace Elgg\Listing;

use Elgg\Database\Seeds\Seed;

/**
 * Add listing seed
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
			'subtype' => 'listing',
		];

		while ($this->getCount() < $this->limit) {
			$metadata = [
				'status' => $this->getRandomStatus(),
				'comments_on' => $this->faker()->boolean() ? 'On' : 'Off',
				'excerpt' => $this->faker()->sentence(),
			];

			$listing = $this->createObject($attributes, $metadata);
			if (!$listing) {
				continue;
			}

			$this->createComments($listing);
			$this->createLikes($listing);

			if ($listing->status === 'draft') {
				$listing->future_access = $listing->access_id;
				$listing->access_id = ACCESS_PRIVATE;
			}

			if ($listing->status === 'published') {
				elgg_create_river_item([
					'view' => 'river/object/blog/create',
					'action_type' => 'create',
					'subject_guid' => $listing->owner_guid,
					'object_guid' => $listing->guid,
					'target_guid' => $listing->container_guid,
					'posted' => $listing->time_created,
				]);

				elgg_trigger_event('publish', 'object', $listing);
			}

			if ($this->faker()->boolean()) {
				$listing->annotate('blog_auto_save', $this->faker()->text(500), ACCESS_PRIVATE, $listing->owner_guid);
			}

			if ($this->faker()->boolean()) {
				$listing->annotate('blog_revision', $listing->description, ACCESS_PRIVATE, $listing->owner_guid);
				$listing->description = $this->faker()->text(500);
			}

			$listing->save();

			$this->advance();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function unseed() {

		/* @var $listings \ElggBatch */
		$listings = elgg_get_entities([
			'type' => 'object',
			'subtype' => 'listing',
			'metadata_name' => '__faker',
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
		]);

		/* @var $listing \ElggBlog */
		foreach ($listings as $listing) {
			if ($listing->delete()) {
				$this->log("Deleted blog {$listing->guid}");
			} else {
				$this->log("Failed to delete blog {$listing->guid}");
			}

			$this->advance();
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getType() : string {
		return 'listing';
	}

	/**
	 * Returns random blog status
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
			'subtype' => 'listing',
		];
	}
}