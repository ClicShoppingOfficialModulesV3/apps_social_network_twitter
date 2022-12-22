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

  try {
    $tweet = $twitter->send('I am fine'); // you can add $imagePath as second argument

  } catch (TwitterException $e) {
    echo 'Error: ' . $e->getMessage();
  }
