/**
 * Save draft through ajax
 */
define(['jquery', 'elgg/Ajax', 'elgg/i18n'], function($, Ajax, i18n) {
	
	// get a copy of the body to compare for auto save
	var oldbreed = $('form.elgg-form-marketplace-save').find('textarea[name=breed]').val();

	var saveDraftCallback = function(data) {
		var $form = $('form.elgg-form-marketplace-save');
		
		if (data.success == true) {
			// update the guid input element for new listings that now have a guid
			$form.find('input[name=guid]').val(data.guid);
			
			oldbreed = $form.find('textarea[name=breed]').val();
			
			var d = new Date();
			var mins = d.getMinutes() + '';
			if (mins.length == 1) {
				mins = '0' + mins;
			}
			$form.find('.marketplace-save-status-time').html(d.toLocaleDateString() + " @ " + d.getHours() + ":" + mins);
		} else {
			$form.find('.marketplace-save-status-time').html(i18n.echo('error'));
		}
	};

	var saveDraft = function() {
		var ajax = new Ajax(false);
		
		var formData = ajax.objectify('form.elgg-form-marketplace-save');
		
		formData.set('status', 'draft');
		
		// only save on changed content
		var breed = formData.get('breed');
		var dog_name = formData.get('dog_name');
		if (!(breed && dog_name) || (breed == oldbreed)) {
			return false;
		}
		
		ajax.action('marketplace/auto_save_revision', {
			data: formData,
			success: saveDraftCallback
		});
	};

	// preview button clicked
	$(document).on('click', '.elgg-form-marketplace-save button[name="preview"]', function(event) {
		event.preventDefault();
		
		var ajax = new Ajax();
		var formData = ajax.objectify('form.elgg-form-marketplace-save');
		
		if (!(formData.get('breed') && formData.get('dog_name'))) {
			return false;
		}
		
		// open preview in blank window
		ajax.action('marketplace/save', {
			data: formData,
			success: function(data) {
				$('form.elgg-form-marketplace-save').find('input[name=guid]').val(data.guid);
				window.open(data.url, '_blank').focus();
			}
		});
	});

	// start auto save interval
	setInterval(saveDraft, 60000);

	return {
		saveDraft: saveDraft
	};
});
