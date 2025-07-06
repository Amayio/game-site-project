<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo template_place_holder('head_start'); ?>
    <meta charset="UTF-8">
    <title>Manage Account - <?php echo config('server_name'); ?></title>
    <link rel="stylesheet" href="<?php echo $template_path; ?>/css/style.css">
    <?php echo template_place_holder('head_end'); ?>
</head>
<body>
<?php echo myacc_header(); ?>

    <main class="register_main">
       <section class="container">
         <?php echo $content; ?>
</section>
    </main>
    
    <?php echo custom_footer(); ?>
<?php echo template_place_holder('body_end'); ?>
    <script src="<?php echo $template_path; ?>/js/script.js"></script>
</body>
</html>