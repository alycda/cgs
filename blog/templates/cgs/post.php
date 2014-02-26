<article class="single">
  <div class="row">
<?php if (strpos($post_category,'Specials') < 1) { ?>
    <div class="one-quarter meta">
      <div class="thumbnail">
        <img src="<?php echo($template_dir_url); ?>/images/profile.png" alt="profile" />
      </div>

      <ul>
        <li>Written by <?php echo($post_author); ?></li>
        <li><?php echo($published_date); ?></li>
        <!-- <li>About <a href="<?php echo($post_category_link); ?>"><?php echo($post_category); ?></a></li> -->
        <li></li>
      </ul>
    </div>
  <?php } ?>


<?php if (strpos($post_category,'Specials') < 1) { ?>
    <div class="three-quarters post">
      <?php echo($post); ?>
<?php } else { // "Specials" post page only ?>
    <div>
      <div class="jumbotron">
        <h1 style="color:#0066a8"><?php echo($post_title);?></h1>
        <br/>
        <img src="<?php echo($post_image); ?>" style="width:100%;margin:0 auto;"/>
        <p class="small pull-left"><br/><?php echo($post_intro); ?></p>
        <span class="pull-right">
          <button class="btn btn-primary btn-lg" onclick="$('#add2Cart').submit()">Add To Cart</button>
          <button class="btn btn-primary btn-lg" onclick="$('#viewCart').submit()">View Cart</button>
        </span>
      </div>

      <?php echo($post_body); ?>

<?php } ?>

      <ul class="actions">
<?php if (strpos($post_category,'Specials') < 1) { ?>
        <li><a class="button" href="<?php echo($blog_url); ?>">More Articles</a></li>
<?php } ?>
      </ul>

      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div>
  </div>
</article>
