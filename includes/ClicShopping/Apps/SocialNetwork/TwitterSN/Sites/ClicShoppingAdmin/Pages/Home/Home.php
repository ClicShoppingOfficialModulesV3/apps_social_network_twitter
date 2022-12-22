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

  namespace ClicShopping\Apps\SocialNetwork\TwitterSN\Sites\ClicShoppingAdmin\Pages\Home;

  use ClicShopping\OM\Registry;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\TwitterSN;

  class Home extends \ClicShopping\OM\PagesAbstract
  {
    public mixed $app;

    protected function init()
    {
      $CLICSHOPPING_TwitterSN = new TwitterSN();
      Registry::set('TwitterSN', $CLICSHOPPING_TwitterSN);

      $this->app = $CLICSHOPPING_TwitterSN;

      $this->app->loadDefinitions('Sites/ClicShoppingAdmin/main');
      /*
            if (!$this->isActionRequest()) {
      
              $twitter_menu_check = [
                                    'CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY',
                                    'CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_SECRET',
                                    'CLICSHOPPING_APP_TWITTER_TW_ACCESS_TOKEN',
                                    'CLICSHOPPING_APP_TWITTER_TW_ACCESS_TOKEN_SECRET'
                                  ];
      
              foreach ($twitter_menu_check as $value) {
                if (defined($value) && !empty(constant($value))) {
                  $this->runAction('Configure');
                  break;
                }
              }
            }
      */
    }
  }
