<?php
defined('MYAAC') or die('Direct access not allowed!');

$page = defined('PAGE') ? PAGE : 'home';

$standalone_pages = [
    'account/create'            => 'register.php',
    'account/manage'            => 'manageAcc.php',
    'account/change-email'      => 'manageAcc.php',
    'account/register'          => 'manageAcc.php',
    'account/change-info'       => 'manageAcc.php',
    'account/characters/create' => 'manageAcc.php',
    'account/characters/delete' => 'manageAcc.php',
    'points'                    => 'shop.php',
];

if (isset($standalone_pages[$page])) {
    include __DIR__ . '/standalone/' . $standalone_pages[$page];
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo template_place_holder('head_start'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo config('server_name'); ?> - Home</title>
    <link rel="stylesheet" href="<?php echo $template_path; ?>/css/style.css">
    <?php echo template_place_holder('head_end'); ?>
</head>
<body class="home">

<header class="header">
    <div class="header__wrapper">

        <div class="logo__container">
            <a href="#">
                <img width="80px" src="<?php echo $template_path; ?>/images/logo.png" alt="Logo" class="logo">
            </a>
        </div>

        <nav class="nav">
            <div class="nav__dropdown">
                <button class="nav__item nav__dropdown-toggle" aria-expanded="false">
                    Game Guide
                    <svg class="nav__dropdown-toggle-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </button>

                <div class="nav__dropdown-content">
                    <div class="nav__dropdown-category">
                        <h4>Server</h4>
                        <ul class="nav__link-grid">
                            <li><a href="#">Highscores</a></li>
                            <li><a href="#">Characters</a></li>
                            <li><a href="#">Who is Online?</a></li>
                            <li><a href="#">Last Kills</a></li>
                            <li><a href="#">Houses</a></li>
                            <li><a href="#">Guilds</a></li>
                        </ul>
                    </div>

                    <div class="nav__dropdown-category">
                        <h4>Game</h4>
                        <ul class="nav__link-grid">
                            <li><a href="#">World Map</a></li>
                            <li><a href="#">Shinobi Roster</a></li>
                            <li><a href="#">Bestiary</a></li>
                            <li><a href="#">Shinobi Gear</a></li>
                            <li><a href="#">Tutorials</a></li>
                            <li><a href="#">Systems</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <a class="nav__item" href="<?php echo getLink('downloads'); ?>">Download</a>
            <a class="nav__item" href="<?php echo getLink('points'); ?>">Premium</a>

            <?php if ($logged): ?>
                <a class="nav__item" href="<?php echo getLink('account/manage'); ?>">Manage Account</a>
                <a class="nav__item" href="<?php echo getLink('account/logout'); ?>">Log out</a>
            <?php else: ?>
                <a class="nav__item" href="<?php echo getLink('account/create'); ?>">Create Account</a>
                <a class="nav__item" href="<?php echo getLink('account/manage'); ?>">Log in</a>
            <?php endif; ?>
        </nav>

        <div class="header__server-status">
            <p class="header__server-status-label header__server-status-title">Server Status</p>

            <?php if (!$status['online']): ?>
                <p class="header__server-status-info">
                    Status: <span class="header__server-status-offline">Offline</span>
                </p>
            <?php else: ?>
                <p class="header__server-status-info">
                    Status: <span class="header__server-status-online">Online</span>
                </p>
                <p class="header__server-status-info players_online">
                    <span class="header__server-status-label">Players Online:</span>
                    <?php echo $status['players']; ?> / <?php echo $status['playersMax']; ?>
                </p>
                <p class="header__server-status-info uptime">
                    <span class="header__server-status-label">Uptime:</span>
                    <?php echo $status['uptimeReadable']; ?>
                </p>
            <?php endif; ?>
        </div>

        <button class="hamburger hamburger--elastic" type="button">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>

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

            <div class="buttons-box">
                <a href="<?php echo getLink('account/create'); ?>" class="cta">Begin Shinobi Adventure</a>
                <button class="goto-news-btn">Release notes</button>
            </div>
        </div>
    </section>

    <h2 class="news_title">NEWS</h2>

    <section id="news" class="news_section">
        <div class="news_list"></div>
        <button class="loadMoreBtn">Load more</button>
    </section>
</main>

<?php echo custom_footer(); ?>
<?php echo template_place_holder('body_end'); ?>

<script src="<?php echo $template_path; ?>/js/script.js"></script>
<script type="module" src="<?php echo $template_path; ?>/js/handleNews.js"></script>

</body>
</html>
