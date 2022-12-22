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

  namespace ClicShopping\Apps\SocialNetwork\TwitterSN\Module\Hooks\ClicShoppingAdmin\Products;

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
      global $pInfo;

      if (!defined('CLICSHOPPING_APP_TWITTER_TW_STATUS') || CLICSHOPPING_APP_TWITTER_TW_STATUS == 'False') {
        return false;
      }

      $this->app->loadDefinitions('Module/Hooks/ClicShoppingAdmin/Products/PageContent');

      if (CLICSHOPPING_APP_TWITTER_TW_STATUS == 'True' && !empty(CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY)) {
        $content = '<div class="row">';
        $content .= '<div class="col-md-9">';
        $content .= '<div class="form-group row">';
        $content .= '<label for="' . $this->app->getDef('text_twitter') . '" class="col-5 col-form-label">' . $this->app->getDef('text_twitter') . '</label>';
        $content .= '<div class="col-md-5">';
        $content .= HTML::radioField('products_twitter', '1', $pInfo->in_accept_twitter) . '&nbsp;' . $this->app->getDef('text_yes') . '&nbsp;' . HTML::radioField('products_twitter', '0', $pInfo->out_accept_twitter) . '&nbsp;' . $this->app->getDef('text_no');
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';

        $output = <<<EOD
<!-- ######################## -->
<!--  Start TwitterApp      -->
<!-- ######################## -->
<script>
$('#tab9Content').prepend(
    '{$content}'
);
</script>
<!-- ######################## -->
<!--  End TwitterApp      -->
<!-- ######################## -->

EOD;
        return $output;
      }
    }
  }
