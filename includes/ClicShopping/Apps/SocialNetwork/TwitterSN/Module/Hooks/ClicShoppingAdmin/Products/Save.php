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

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\Classes\TwitterClicShopping;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\TwitterSN as TwitterSNApp;

  class Save implements \ClicShopping\OM\Modules\HooksInterface
  {
    protected $app;

    public function __construct()
    {
      if (!Registry::exists('TwitterSN')) {
        Registry::set('TwitterSN', new TwitterSNApp());
      }

      $this->app = Registry::get('TwitterSN');

      $this->app->loadDefinitions('Module/Hooks/ClicShoppingAdmin/Products/Save');

      Registry::set('TwitterAPI', new TwitterClicShopping());
      $this->TwitterAPI = Registry::get('TwitterAPI');
    }

    /**
     * getTwitter : send information in Twitter
     *
     * @param string $id products_id, $text twitter text, $$price :price of the product
     * @return string $image, the image value
     * @access public
     */
    public function SendTwitter($id, $text)
    {
      if (defined('CLICSHOPPING_APP_TWITTER_TW_STATUS')) {
        if (CLICSHOPPING_APP_TWITTER_TW_STATUS == 'True' && !empty(CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY)) {
          $this->TwitterAPI->CreateTwitter($text, $id);
        }
      }
    }


    public function execute()
    {
      if (isset($_GET['pID']) && isset($_POST['products_twitter'])) {
        $id = HTML::sanitize($_GET['pID']);

        if (defined('CLICSHOPPING_APP_TWITTER_TW_STATUS')) {
          if (CLICSHOPPING_APP_TWITTER_TW_STATUS == 'True' && !empty(CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY)) {
            if (isset($_POST['products_twitter'])) {
              $this->SendTwitter($id, $this->app->getDef('text_twitter_product'));
            }
          }
        }
      }
    }
  }