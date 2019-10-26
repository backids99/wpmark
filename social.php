<center>
<?php
$url_share = get_option('home');
$count = get_social_count($url_share, 'twitter,gplus,facebook'); ?>
<a class="btn-group" title="Share on Facebook" href="http://www.facebook.com/sharer.php?u=<?php echo get_option('home'); ?>">
<button class="btn btn-small btn-primary" type="button">F</button>
<button class="btn btn-small"><i class="icon-share"></i> <?php echo "{$count->facebook}";?></button>
</a>
<a class="btn-group" title="Share on Twitter" href="http://twitter.com/home?status=<?php echo bloginfo('name'); ?> - <?php echo get_option('home'); ?>">
<button class="btn btn-small btn-info" type="button">T</button>
<button class="btn btn-small"><i class="icon-share"></i> <?php echo "{$count->twitter}";?></button>
</a>
<a class="btn-group" title="Share on Gplus" href="https://plus.google.com/share?url=<?php echo get_option('home'); ?>">
<button class="btn btn-small btn-danger" type="button">G</button>
<button class="btn btn-small"><i class="icon-share"></i> <?php echo "{$count->gplus}";?></button>
</a>
</center>
<li class="divider"></li>
