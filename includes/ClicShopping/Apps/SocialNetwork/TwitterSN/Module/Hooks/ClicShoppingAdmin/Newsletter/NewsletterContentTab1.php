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

  namespace ClicShopping\Apps\SocialNetwork\TwitterSN\Module\Hooks\ClicShoppingAdmin\Newsletter;

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\ObjectInfo;
  use ClicShopping\Apps\SocialNetwork\TwitterSN\TwitterSN as TwitterSNApp;

  class NewsletterContentTab1 implements \ClicShopping\OM\Modules\HooksInterface
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
      global $nInfo;

      if (!defined('CLICSHOPPING_APP_TWITTER_TW_STATUS') || CLICSHOPPING_APP_TWITTER_TW_STATUS == 'False') {
        return false;
      }

      $this->app->loadDefinitions('Module/Hooks/ClicShoppingAdmin/Newsletter/PageContentTwitter');

      if (isset($_GET['nID'])) {
        $nID = HTML::sanitize($_GET['nID']);

        $Qnewsletter = $this->app->db->get('newsletters', ['newsletters_twitter'], ['newsletters_id' => (int)$nID]);

        $nInfo->ObjectInfo($Qnewsletter->toArray());

        if (!isset($nInfo->newsletters_twitter)) $nInfo->newsletters_twitter = '1';

        if (isset($_GET['in_accept_twitter'])) {
          $in_accept_twitter = HTML::sanitize($_GET['in_accept_twitter']);
        } else {
          $in_accept_twitter = 0;
        }

        if (isset($_GET['out_accept_twitter'])) {
          $out_accept_twitter = HTML::sanitize($_GET['out_accept_twitter']);
        } else {
          $out_accept_twitter = 0;
        }
        /*
                switch ($nInfo->newsletters_twitter) {
                  case '0':
                    $in_accept_twitter = false;
                    $out_accept_twitter = true;
                    break;
                  case '1':
                    $in_accept_twitter = true;
                    $out_accept_twitter = false;
                    break;
                  default:
                    $in_accept_twitter = true;
                    $out_accept_twitter = false;
                    break;
                }
                */
      }

      if (CLICSHOPPING_APP_TWITTER_TW_STATUS == 'True' && !empty(CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY)) {
        $content = '<div class="row">';
        $content .= '<div class="col-md-5">';
        $content .= '<div class="form-group row">';
        $content .= '<label for="' . $this->app->getDef('text_twitter') . '" class="col-5 col-form-label">' . $this->app->getDef('text_twitter') . '</label>';
        $content .= '<div class="col-md-5">';
        $content .= HTML::radioField('newsletters_twitter', '1', $in_accept_twitter) . '&nbsp;' . $this->app->getDef('text_yes') . '&nbsp;' . HTML::radioField('newsletters_twitter', '0', $out_accept_twitter) . '&nbsp;' . $this->app->getDef('text_no');
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';

        $title = $this->app->getDef('text_twitter');

        $output = <<<EOD
<!-- ######################## -->
<!--  Start TwitterApp      -->
<!-- ######################## -->
<script>
$('#newsletterFile').append(
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
