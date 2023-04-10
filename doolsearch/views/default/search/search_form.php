<div class="droolsearch">
    <form action="<?php echo elgg_get_site_url(); ?>search" method="get">
        <label for="search_input"><?php echo elgg_echo('search_bar:search_label'); ?></label>
        <input type="text" name="search_input" id="search_input" value="">
        <input type="submit" value="<?php echo elgg_echo('search_bar:search_button'); ?>">
    </form>
</div>
