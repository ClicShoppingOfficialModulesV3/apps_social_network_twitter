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

  namespace ClicShopping\Apps\SocialNetwork\TwitterSN\Module\ClicShoppingAdmin\Config\TW;

  class TW extends \ClicShopping\Apps\SocialNetwork\TwitterSN\Module\ClicShoppingAdmin\Config\ConfigAbstract
  {

    protected $pm_code = 'twittersn';

    public $is_uninstallable = true;
    public $sort_order = 400;

    protected function init()
    {
      $this->title = $this->app->getDef('module_tw_title');
      $this->short_title = $this->app->getDef('module_tw_short_title');
      $this->introduction = $this->app->getDef('module_tw_introduction');
      $this->is_installed = defined('CLICSHOPPING_APP_TWITTER_TW_STATUS') && (trim(CLICSHOPPING_APP_TWITTER_TW_STATUS) != '');
    }

    public function install()
    {
      parent::install();

      if (defined('MODULE_MODULES_SOCIAL_NETWORK_INSTALLED')) {
        $installed = explode(';', MODULE_MODULES_SOCIAL_NETWORK_INSTALLED);
      }

      $installed[] = $this->app->vendor . '\\' . $this->app->code . '\\' . $this->code;

      $this->app->saveCfgParam('MODULE_MODULES_SOCIAL_NETWORK_INSTALLED', implode(';', $installed));
    }

    public function uninstall()
    {
      parent::uninstall();

      $installed = explode(';', MODULE_MODULES_SOCIAL_NETWORK_INSTALLED);
      $installed_pos = array_search($this->app->vendor . '\\' . $this->app->code . '\\' . $this->code, $installed);

      if ($installed_pos !== false) {
        unset($installed[$installed_pos]);

        $this->app->saveCfgParam('MODULE_MODULES_SOCIAL_NETWORK_INSTALLED', implode(';', $installed));
      }
    }
  }