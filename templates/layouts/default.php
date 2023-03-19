<?php


use Core\Support\FlashMessage;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->getTitle(); ?></title>
    <link type="text/css" rel="stylesheet" href="<?= assets_path('bootstrap/css/bootstrap.min.css'); ?>">
    <?php $this->content('header') ?>
    <style>
        .sp-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* set a dark background color */
            /*display: flex;*/
            align-items: center;
            justify-content: center;
            display: none;
        }

        .spinner {
            margin: 100px auto;
            width: 40px;
            height: 40px;
            position: relative;
            border-top: 3px solid rgba(0,0,0,0.1);
            border-right: 3px solid rgba(0,0,0,0.1);
            border-bottom: 3px solid rgba(0,0,0,0.1);
            border-left: 3px solid #818a91;
            border-radius: 50%;
            animation: spin 1s ease-in-out infinite;
            display: none; /* hide the spinner by default */
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body style="background: #eee">
<div class="sp-container"><div class="spinner"></div></div>

<div class="container-fluid">
    <?= FlashMessage::bootstrap_alert(); ?>
    <?php $this->content('content'); ?>
</div>

<!--<script>-->
<!--    const spinner = document.querySelector('.spinner');-->
<!---->
<!--    window.addEventListener('load', () => {-->
<!--        spinner.style.display = 'block';-->
<!--    });-->
<!---->
<!--    window.addEventListener('DOMContentLoaded', () => {-->
<!--        spinner.style.display = 'none';-->
<!--    });-->
<!--</script>-->
<script src="<?= assets_path('bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= assets_path('js/jquery-3.6.3.min.js'); ?>"></script>

<?php $this->content('script') ?>

</body>
</html>