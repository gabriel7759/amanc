	<form id="login" action="" method="post" class="login validate">
		<div class="box">
			<div class="box-header clearfix">
				<h2><?=__('Login')?></h2>
			</div>
			<div class="box-body">
				<?php if($error): ?><div class="message error"><?=__('The login credentials provided are invalid')?>.</div><?php endif; ?>
				<div class="box-login">
					<div class="field">
						<label><?=__('E-mail')?></label>
						<input type="text" name="username" value="<?=$username?>" class="required email" title="<?=__('Please enter your e-mail')?>" />
					</div>
					<div class="field">
						<label><?=__('Password')?></label>
						<input type="password" name="password" class="required" title="<?=__('Please enter your password')?>" />
					</div>
					<button type="submit" class="button submit"><?=__('Continue')?></button>
					<label class="option"><input type="checkbox" name="remember" value="1" /> <?=__('Remember me in this computer')?></label>
				</div>
			</div>
		</div>
		<p><a href="start/session/password"><?=__('Forgot your password?')?></a></p>
	</form>