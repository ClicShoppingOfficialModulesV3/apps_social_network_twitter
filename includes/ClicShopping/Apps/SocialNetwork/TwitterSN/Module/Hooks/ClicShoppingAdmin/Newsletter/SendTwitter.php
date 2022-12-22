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

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTTP;
  use ClicShopping\OM\HTML;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\Classes\TwitterClicShopping;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\TwitterSN as TwitterSNApp;

  class SendTwitter implements \ClicShopping\OM\Modules\HooksInterface
  {
    protected $app;
    protected $TwitterAPI;
    protected $twitter;
    protected $fileId;

    public function __construct()
    {
      if (isset($_GET['at'])) {
        $this->twitter = HTML::sanitize($_GET['at']);
      }

      if (isset($_GET['nID'])) {
        $this->fileId = $_GET['nID'];
      }
    }

    public function execute()
    {

      if ((!isset($_GET['Update']) || !isset($_GET['Insert'])) && isset($_GET['ConfirmSend'])) {
        if (defined('CLICSHOPPING_APP_TWITTER_TW_STATUS')) {
          if ((CLICSHOPPING_APP_TWITTER_TW_STATUS == 'True' && !empty(CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY))) {
            if (!Registry::exists('TwitterSN')) {
              Registry::set('TwitterSN', new TwitterSNApp());
            }

            $this->app = Registry::get('TwitterSN');

            if (!Registry::exists('TwitterAPI')) {
              Registry::set('TwitterAPI', new TwitterClicShopping());
            }

            $this->TwitterAPI = Registry::get('TwitterAPI', true);
            $this->app->loadDefinitions('Module/Hooks/ClicShoppingAdmin/Newsletter/Send');

            $text_newsletter = HTTP::getShopUrlDomain() . 'sources/public/newsletter/newsletter_' . $this->fileId . '.html';

            $_POST['twitter_msg'] = $this->app->getDef('text_twitter', ['store_name' => STORE_NAME]) . ' ' . $text_newsletter;
            $this->TwitterAPI->SendTwitter();
          }
        }
      }
    }
  }