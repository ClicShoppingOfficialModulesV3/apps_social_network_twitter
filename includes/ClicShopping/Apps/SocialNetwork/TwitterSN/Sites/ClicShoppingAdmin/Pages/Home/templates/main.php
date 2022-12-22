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
  use ClicShopping\OM\HTTP;

  $CLICSHOPPING_MessageStack = Registry::get('MessageStack');
  $CLICSHOPPING_TwitterSN = Registry::get('TwitterSN');

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
            class="col-md-1 logoHeading"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'categories/configuration_42.gif', $CLICSHOPPING_TwitterSN->getDef('heading_title'), '40', '40'); ?></span>
          <span
            class="col-md-4 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_TwitterSN->getDef('heading_title'); ?></span>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>
  <div class="col-md-12 mainTitle"><strong><?php echo $CLICSHOPPING_TwitterSN->getDef('text_twitter'); ?></strong></div>
  <div class="adminformTitle">
    <div class="row">
      <div class="separator"></div>

      <div class="col-md-12">
        <div class="form-group">
          <div class="col-md-12">
            <?php echo $CLICSHOPPING_TwitterSN->getDef('text_intro'); ?>
          </div>
        </div>
        <div class="separator"></div
        <div class="col-md-12">
          <div class="form-group">
            <div class="col-md-12 text-center">
              <?php
                echo HTML::form('configure', CLICSHOPPING::link(null, 'A&SocialNetwork\TwitterSN&Configure'));
                echo HTML::button($CLICSHOPPING_TwitterSN->getDef('button_configure'), null, null, 'primary');
                echo '</form>';
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
