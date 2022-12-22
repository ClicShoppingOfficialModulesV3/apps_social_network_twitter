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

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;

  $CLICSHOPPING_TwitterSN = Registry::get('TwitterSN');
  $CLICSHOPPING_Page = Registry::get('Site')->getPage();

  if ($CLICSHOPPING_MessageStack->exists('TwitterSN')) {
    echo $CLICSHOPPING_MessageStack->get('TwitterSN');
  }
?>

<div class="contentBody">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-block headerCard">
        <div class="row">
          <span
            class="col-md-1 logoHeading"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'categories/products_twittersn.png', $CLICSHOPPING_TwitterSN->getDef('heading_title'), '40', '40'); ?></span>
          <span
            class="col-md-4 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_TwitterSN->getDef('heading_title'); ?></span>
          <span
            class="col-md-7 text-end"><?php echo HTML::button($CLICSHOPPING_TwitterSN->getDef('button_back'), null, $CLICSHOPPING_TwitterSN->link(null, 'A&SocialNetwork\TwitterSN'), 'primary'); ?>
        </div>
      </div>
    </div>
  </div>

