<?php if($total_items): ?>
<div class="pagination">
	<strong><?=$current_first_item?></strong> - <strong><?=$current_last_item?></strong> <?=__('of')?> <strong><?=$total_items?></strong>
	<?php if($total_pages>1): ?>
	<a href="#" class="prev<?php if(!$previous_page): ?> disabled<?php endif; ?>" data-page="<?=$previous_page?>" data-tooltip="<?=__('Previous')?>"><?=__('Previous')?></a>
	<a href="#" class="next<?php if(!$next_page): ?> disabled<?php endif; ?>" data-page="<?=$next_page?>" data-tooltip="<?=__('Next')?>"><?=__('Next')?></a>
	<?php endif; ?>
</div>
<?php endif; ?>