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

  namespace ClicShopping\Apps\SocialNetwork\TwitterSN\Module\Hooks\ClicShoppingAdmin\DiscountCoupon;

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\TwitterSN as TwitterSNApp;

  class PageContentTwitter implements \ClicShopping\OM\Modules\HooksInterface
  {
    protected $app;

    public function __construct()
    {
      if (!Registry::exists('TwitterSN')) {
        Registry::set('TwitterSN', new TwitterSNApp());
      }

      $this->app = Registry::get('TwitterSN');
    }

    public function display()
    {
      global $cInfo;

      if (!defined('CLICSHOPPING_APP_TWITTER_TW_STATUS') || CLICSHOPPING_APP_TWITTER_TW_STATUS == 'False') {
        return false;
      }

      $this->app->loadDefinitions('Module/Hooks/ClicShoppingAdmin/DiscountCoupon/PageContentTwitter');

      if (defined('CLICSHOPPING_APP_TWITTER_TW_STATUS') && CLICSHOPPING_APP_TWITTER_TW_STATUS == 'True' && !empty(CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY)) {

        $content = '<div class="adminformTitle">';
        $content .= '<div class="row">';
        $content .= '<div class="col-md-5">';
        $content .= '<div class="form-group row">';
        $content .= '<label for="' . $this->app->getDef('text_discount_twitter') . '" class="col-5 col-form-label">' . $this->app->getDef('text_discount_twitter') . '</label>';
        $content .= '<div class="col-md-5">';
        $content .= HTML::checkboxField('coupons_twitter', '1', $cInfo->in_accept_twitter);
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';

        $title = '<div class="separator"></div>';
        $title .= '<div class="mainTitle">';
        $title .= '<span class="col-md-10">';
        $title .= $this->app->getDef('text_twitter');
        $title .= '</span>';
        $title .= '</div>';

        if (CLICSHOPPING_APP_TWITTER_TW_STATUS == 'True' && !empty(CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY)) {
          $output = <<<EOD
<!-- ######################## -->
<!--  Start TwitterApp      -->
<!-- ######################## -->
           {$title}
           {$content}
<!-- ######################## -->
<!--  End TwitterApp      -->
<!-- ######################## -->
EOD;
          return $output;

        }
      }
    }
  }
