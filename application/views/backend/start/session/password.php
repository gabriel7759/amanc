	<form id="password" action="" method="post" class="login validate">
		<div class="box">
			<div class="box-header clearfix">
				<h2><?=__('Password recovery')?></h2>
			</div>
			<div class="box-body">
				<?php if($error): ?><div class="message error"><?=__('No user found with the entered e-mail address')?>.</div><?php endif; ?>
				<div class="box-login">
					<!--<p>Enter the e-mail account you use to login to receive a message with the instructions to reset your password.</p>-->
					<p><?=__('Enter the e-mail account you use to login to receive a message with your new password')?>.</p>
					<div class="field">
						<label><?=__('E-mail')?></label>
						<input type="text" name="email" value="" class="required email" title="<?=__('Please enter your e-mail')?>" />
					</div>
					<button type="submit" class="button submit"><?=__('Continue')?></button>
				</div>
			</div>
		</div>
		<p><a href="start/session/login">&laquo; <?=__('Go back to login page')?></a></p>
	</form>