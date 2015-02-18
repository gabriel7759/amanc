
<?php if($total_pages>1): ?>
<div class="paginador">
		<form>
          <input type="text" id="num_text" placeholder="Ir a"/>
          <input type="submit" id="go_to" value=""/>
        </form>

	<ul>
		<li <?=!$first_page?'style="display:none;"':''?>><a class="first" href="<?=str_replace('/index.php','',HTML::chars($page->url($first_page)))?>"><i class="fa fa-angle-double-left"></i></a></li>
		<li <?=!$first_page?'style="display:none;"':''?>><a class="prev" href="<?=str_replace('/index.php','',HTML::chars($page->url($previous_page)))?>"><i class="fa fa-angle-left"></i></a></li>
			<?php $o = $total_pages>3?3:$total_pages; $x = !$last_page?2:1; $init = $current_page<=3?1:$current_page - $x; $limit = $last_page?$init+$o:$current_page+1;
				for($i=$init; $i<$limit; $i++){ $active = ($current_page == $i)?'active':''; print '<li><a class="num '.$active.'" href='.str_replace('/index.php','',HTML::chars($page->url($i))).'>'.$i.'</a></li>'; }	?>
		<li <?=!$last_page?'style="display:none;"':''?>><a class="next" href="<?=str_replace('/index.php','',HTML::chars($page->url($next_page)))?>"><i class="fa fa-angle-right"></i></a></li>	
		<li <?=!$last_page?'style="display:none;"':''?>><a class="last" href="<?=str_replace('/index.php','',HTML::chars($page->url($last_page)))?>"><i class="fa fa-angle-double-right"></i></a></li>
	</ul>
</div>

<?php endif; ?>
<input type="hidden" id="total_pages" value="<?=$total_pages?>">
