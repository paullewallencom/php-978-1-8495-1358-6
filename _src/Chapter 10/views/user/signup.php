<div class="page-header">
  <h1>Signup</h1>
</div>

<div class="row">
  <div class="span12">
    <form action="<?php echo $this->make_route('/signup') ?>" method="post">
      <fieldset>
          <?php Bootstrap::make_input('full_name', 'Full Name', 'text'); ?>
          <?php Bootstrap::make_input('email', 'Email', 'text'); ?>
          <?php Bootstrap::make_input('username', 'Username', 'text'); ?>
        	<?php Bootstrap::make_input('password', 'Password', 'password'); ?>
        
          <div class="form-actions">
            <button class="btn btn-primary">Sign Up!</button>
          </div>
      </fieldset>
    </form>
  </div>
</div>
