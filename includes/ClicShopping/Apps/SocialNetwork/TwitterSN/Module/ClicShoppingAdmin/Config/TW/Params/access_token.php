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

  namespace ClicShopping\Apps\SocialNetwork\TwitterSN\Module\ClicShoppingAdmin\Config\TW\Params;

  class access_token extends \ClicShopping\Apps\SocialNetwork\TwitterSN\Module\ClicShoppingAdmin\Config\ConfigParamAbstract
  {

    public $default = '';
    public $sort_order = 40;
    public $app_configured = true;

    protected function init()
    {
      $this->title = $this->app->getDef('cfg_twittersn_access_token_title');
      $this->description = $this->app->getDef('cfg_twittersn_access_token_description');
    }
  }
