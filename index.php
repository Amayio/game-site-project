<?php
defined('MYAAC') or die('Direct access not allowed!');
define('PAGE', $_GET['page'] ?? 'home');

$standalone_pages = [
    'account/create' => 'register.php',
];

if (isset($standalone_pages[PAGE])) {
    include __DIR__ . '/standalone/' . $standalone_pages[PAGE];
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo template_place_holder('head_start'); ?>
    <meta charset="UTF-8">
    <title><?php echo config('server_name'); ?> - Home</title>
    <link rel="stylesheet" href="<?php echo $template_path; ?>/css/style.css">
    <?php echo template_place_holder('head_end'); ?>
</head>
<body>
    <header class="header">
        <div class="header_wrapper">
            <div class="logo_container">
             <a href="#">
                <img width="80px" src="<?php echo $template_path; ?>/images/logo.png" alt="Logo" class="logo">
            </a>
        </div>

        <nav class="nav">
            <a class="nav_item" href="<?php echo getLink('downloads'); ?>">Game Guide</a>
            <a class="nav_item" href="<?php echo getLink('downloads'); ?>">Download</a>
            <a class="nav_item" href="<?php echo getLink('highscores'); ?>">Premium</a>
            <a class="nav_item" href="<?php echo getLink('account/create'); ?>">Create Account</a>
            <a class="nav_item" href="<?php echo getLink('account/create'); ?>">Log in</a>
        </nav>

        <div class="server_status">
            <p class="status_title">Server Status</p>
            <?php if (!$status['online']): ?>
                <p class="offline_status">Status: <span class="offline">Offline</span></p>
            <?php else: ?>
                <p class="online_status">Status: <span class="online">Online</span></p>
                <p class="players_online"><span>Players Online:</span> <?php echo $status['players']; ?> / <?php echo $status['playersMax']; ?></p>
                <p class="uptime"><span>Uptime:</span> <?php echo $status['uptimeReadable']; ?></p>
            <?php endif; ?>
        </div>
        </div>
    </header>

    <main>

<section id="home" class="hero">
 <video autoplay muted loop playsinline class="background-video">
    <source src="<?php echo $template_path; ?>/images/hero_background.mp4" type="video/mp4">
  </video>

   <div class="hero-content">
    <h1>Shinobi Chronicles</h1>
    <p>Forge alliances or wage war — the ninja world is yours to shape.</p>
    <a href="<?php echo getLink('account/create'); ?>" class="cta-button">Begin Your Shinobi Journey</a>
  </div>
</section>

<section class="news_section">
    <h2>NEWS</h2>
    <div class="news_list">

    </div>
<button class="loadMoreBtn">Load more</button>
</section>

         
    </main>

    <footer>
        <?php echo template_footer(); ?><br/>
        <p>Template by Amai</p>
    </footer>

    <?php echo template_place_holder('body_end'); ?>
    <script src="<?php echo $template_path; ?>/js/script.js"></script>
    <script type="module" src="<?php echo $template_path; ?>/js/news.js"></script>
</body>
</html>