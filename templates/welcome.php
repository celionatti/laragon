<?php

?>

<?php $this->start('content') ?>
<h1 class="text-center fw-bold text-decoration-underline text-danger">Welcome Page</h1>
<div>
    <?php foreach ($users as $user): ?>
        <h2><?= $user->name; ?></h2>
    <?php endforeach; ?>
</div>
<?php $this->end(); ?>
