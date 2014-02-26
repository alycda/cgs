<article class="<?php echo($post_status); ?>">
    <div class="row">
        <div class="one-quarter meta">
            <div class="thumbnail">
                <img src="<?php echo($template_dir_url); ?>/images/profile.png" alt="profile" />
            </div>

            <ul>
                <li>Written by <?php echo($post_author); ?></li>
                <li><?php echo($published_date); ?></li>
                <li>Filed under:<a href="<?php echo($post_category_link); ?>"><?php echo($post_category); ?></a></li>
                <li></li>
            </ul>
        </div>

        <div class="three-quarters post">
            <h2><a href="<?php echo($post_link); ?>"><?php echo($post_title); ?></a></h2>

            <?php echo($post_intro); ?>

            <ul class="actions">
                <li><a class="button" href="<?php echo($post_link); ?>">Continue Reading</a></li>
                <?php if ($category) { ?>
                <li><a class="button" href="<?php echo($blog_url); ?>">More Articles</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</article>
