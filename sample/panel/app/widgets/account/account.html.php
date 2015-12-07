<div class="dashboard-box">
  <a class="dashboard-item" href="<?php __($user->url()) ?>">
    <figure>
      <img class="dashboard-item-icon" src="<?php echo $user->avatar()->url() ?>" alt="<?php __($user->username()) ?>">
      <figcaption class="dashboard-item-text">
        <?php __($user->username()) ?>
      </figcaption>
    </figure>
  </a>
</div>