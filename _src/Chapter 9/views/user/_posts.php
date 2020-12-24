<?php foreach ($posts as $post): ?>
	<div class="post-item row">
			<div class="span7">
			  <div class="span1">
			    <img src="<?php echo $user->gravatar('50'); ?>" />
			  </div>
			  <div class="span5">
  				<strong><?php echo $user->name; ?></strong>
  				<p>
  				<?php echo $post->content; ?>
  				</p>
  				<?php echo $post->date_created; ?>
  			</div>
			</div>
      <div class="span1">
      	<?php if ($is_current_user) { ?>
      		<a href="<?php echo $this->make_route('/post/delete/' . $post->_id . '/' . $post->_rev)?>" class="deletes">(Delete)</a>
      	<?php } ?>
      </div>
			<div class="span8"></div>
	</div>
<?php endforeach; ?>