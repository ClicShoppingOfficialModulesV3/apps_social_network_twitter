<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @licence MIT - Portion of osCommerce 2.4
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  require_once '../src/twitter.class.php';

  // ENTER HERE YOUR CREDENTIALS (see readme.txt)
  $twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

  // See https://dev.twitter.com/docs/api/1.1
  $statuses = $twitter->request('statuses/retweets_of_me', 'GET');

?>
<!doctype html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Twitter retweets of me</title>

<ul>
  <?php foreach ($statuses as $status): ?>
    <li><a href="https://twitter.com/<?php echo $status->user->screen_name ?>"><img
          src="<?php echo htmlspecialchars($status->user->profile_image_url) ?>">
        <?php echo htmlspecialchars($status->user->name) ?></a>:
      <?php echo Twitter::clickable($status) ?>
      <small>at <?php echo date("j.n.Y H:i", strtotime($status->created_at)) ?></small>
    </li>
  <?php endforeach ?>
</ul>
