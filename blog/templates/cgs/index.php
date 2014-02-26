<!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo($page_title); ?></title>
    <?php //echo($page_meta); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Specializing in Corporate and General Aviation">
    <meta name="author" content="hello@alyda.me">

    <link rel="stylesheet" href="<?php echo($template_dir_url); ?>blog.css">
    <link rel="stylesheet" href="<?php echo($template_dir_url); ?>subdiv.css">

    <?php get_header(); ?>
</head>
<body>
<div class="container">
    <header class="row">
        <div class="col-xs-4">

        <h1 hidden>Compressed Gas Systems</h1>
        <a class="logo" href="/"><img src="/images/logo.svg" alt="Compressed Gas Systems" title="Return to homepage"></a>
        </div>
        <div class="col-xs-8">
            <address class="shadow">
                <span class="phone">(855) 875-2226</span> <span>|</span>
              <span class="address">13829 Artesia Blvd.
                                                        Cerritos, CA 90703</span>
            </address>
            <nav class="navbar">
                <h1 hidden>Main Navigation</h1>
                <ul id="main-nav" class="nav navbar-nav">
                    <li><a href="/">Home</a></li>
                    <li><a href="/services.php">Our Services</a></li>
                    <li><a href="/quotes.php">Request a Quote</a></li>
                    <!-- this link should go to /blog/category/"specials" but the link from that page is not working  -->
                    <li<?php if (strpos($post_category,'Specials') !== false) { ?> class="active"<?php } ?>><a href="/blog/2-5-amerex">Specials</a></li>
                    <li<?php if (strpos($post_category,'Specials') < 1) { ?> class="active"<?php } ?>><a href="/blog">Blog</a></li>
                </ul>
            </nav>
            <div class="navbar visible-lg">
              <ul id="secondary-nav" class="nav navbar-nav">
                <li<?= ($_SERVER['REQUEST_URI']=="/certificates.php")?' class="active"':'';?>><a href="/certificates.php">Certificates</a></li>
                    <li<?= ($_SERVER['REQUEST_URI']=="/capabilities.php")?' class="active"':'';?>><a href="/capabilities.php">Capabilities</a></li>
                    <li<?= ($_SERVER['REQUEST_URI']=="/about-us.php")?' class="active"':'';?>><a href="/about-us.php">About Us</a></li>
                    <li<?= ($_SERVER['REQUEST_URI']=="/contact-us.php")?' class="active"':'';?>><a href="/contact-us.php">Contact Us</a></li>
                    <li><a href="https://ipn.intuit.com/payNow/start?eId=ea1b387017b052bd&uuId=a4ed49bc-0cf1-40ef-be6b-35c00f2be224" target="_blank" title="Payment will be made via Intuit Payment Network, a trusted 3rd party company. You do not need an account with intuit and CGS will not have access nor record the information you provide here. We honor your privacy!">Online Bill Payment</a></li>
              </ul>
            </div><!--/.navbar-->
        </div><!--/.right-->
    </header>

    <ul class="breadcrumb">
        <li><a href="/">home</a></li>

<?php if (strpos($post_category,'Specials') !== false) { ?>
        <li><a href='/blog/category/specials'>specials</a></li>
<?php } else { ?>
        <li><a href="/blog">blog</a></li>
<?php } ?>

        <li><?php echo($page_title); ?></li>
        <?php // ?>
    </ul>
    <section class="content">
    <h1 hidden>Blog</h1>

    <?php if($is_home) { ?>
    <article style="background:#fff; border-radius: 6px;">
        <div class="row">
            <div class="one-quarter meta">
                <div class="thumbnail">
                    <img src="<?php echo($template_dir_url); ?>/images/profile.png" alt="profile" />
                </div>

                <ul>
                    <li><?php echo($blog_title); ?></li>
                    <li><a href="mailto:<?php echo($blog_email); ?>?subject=Hello"><?php echo($blog_email); ?></a></li>
                    <li></li>
                </ul>
            </div>

            <div class="three-quarters post">
                <h2><?php echo($intro_title); ?></h2>
                <p><?php echo($intro_text); ?></p>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>
        </div>
    </article>
    <?php }  ?>

    <?php echo($content); ?>
    </section>

    <?php get_footer(); ?>

</div><!--/.container-->
</body>
</html>