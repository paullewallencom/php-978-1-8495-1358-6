<div class="page-header">
	<h1><?php echo $user->full_name; ?>	
		<?php if ($isCurrentUser) { ?>
			<code>This is you!</code>
		<?php } ?>
	</h1>
</div>

<div class="container">
  <div class="row">
    <div class="span4">
      <div class="well sidebar-nav">
        <ul class="nav nav-list">
          <li><h3>User Information</h3></li>
          <li><b>Username:</b> <?php echo $user->name; ?></li>
          <li><b>Email:</b> <?php echo $user->email; ?></li>
        </ul>
      </div>
    </div>
    <div class="span8">
      <?php if ($isCurrentUser) { ?>
        <h2>Create a new post</h2>
        <form action="<?php echo $this->make_route('/post')?>" method="post">
          <textarea id="content" name="content" class="span8" rows="3"></textarea>	
          <button id="create_post" class="btn btn-primary">Submit</button>
        </form>
      <?php } ?>
      
      <h2>Posts</h2>
    </div>
  </div>
</div>