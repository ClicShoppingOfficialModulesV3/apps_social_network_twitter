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

  namespace ClicShopping\Apps\SocialNetwork\TwitterSN\Module\ClicShoppingAdmin\Dashboard;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\Classes\TwitterClicShopping;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\TwitterSN as TwitterSNApp;

  class TwitterSN extends \ClicShopping\OM\Modules\AdminDashboardAbstract
  {

    protected $app;

    protected function init()
    {
      if (!Registry::exists('TwitterSN')) {
        Registry::set('TwitterSN', new TwitterSNApp());
      }

      $this->app = Registry::get('TwitterSN');

      Registry::set('TwitterAPI', new TwitterClicShopping());
      $this->TwitterAPI = Registry::get('TwitterAPI');

      $this->app->loadDefinitions('Module/ClicShoppingAdmin/Dashboard/twitter');

      $this->title = $this->app->getDef('module_admin_dashboard_title');
      $this->description = $this->app->getDef('module_admin_dashboard_description');

      if (defined('MODULE_ADMIN_DASHBOARD_TWITTER_APP_SORT_ORDER')) {
        $this->sort_order = MODULE_ADMIN_DASHBOARD_TWITTER_APP_SORT_ORDER;
        $this->enabled = true;
      }
    }

    public function getOutput()
    {
      if ((!defined('CLICSHOPPING_APP_TWITTER_TW_STATUS') || CLICSHOPPING_APP_TWITTER_TW_STATUS == 'False') || (!defined('MODULE_ADMIN_DASHBOARD_TWITTER_APP_STATUS') || MODULE_ADMIN_DASHBOARD_TWITTER_APP_STATUS == 'False')) {
        return false;
      }

      $content_width = 'col-md-' . (int)CLICSHOPPING_APP_TWITTER_TW_CONTENT_WIDTH;

      $output = '<span class="' . $content_width . '">';
      $output .= '<div class="separator"></div>';
      $output .= '<div class="col-md-12 text-center">';
      $output .= '<div class="row">';
      $output .= HTML::form('twitter', CLICSHOPPING::link(), 'post');
      $output .= $this->TwitterAPI->SendTwitter();
      $output .= '
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group row">
                    <label for="InputTwitter" class="col-4 col-form-label">' . $this->app->getDef('text_title_twitter') . '</label>
                    <div class="col-md-8">
                      ' . HTML::textAreaField('twitter_msg', '', '45', '3', 'id="caracter" maxlenght="140" required aria-required="true" id="twitter" placeholder="My day twitt !"') . '
                    <input type="submit" name="button" id="button" value="' . $this->app->getDef('button_submit') . '" class="btn btn-secondary" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="separator"></div>
          ';

      $output .= '</form>';
      $output .= '</div>';
      $output .= '</div>';
      $output .= '</div>';

      $output .= '<script type="text/javascript"> ';
      $output .= '$(document).ready(function(){ ';
      $output .= '$("#caracter").charCount({ ';
      $output .= 'allowed: 140, ';
      $output .= 'warning: 10, ';
      $output .= 'counterText: \'<br /> Max : \' ';
      $output .= '}); ';
      $output .= '}); ';
      $output .= '</script> ';

      return $output;
    }

    public function install()
    {
      $CLICSHOPPING_Db = Registry::get('Db');
//CLICSHOPPING_APP_TWITTER_TW_ACCESS_TOKEN
      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Do you want to enable this Module ?',
          'configuration_key' => 'MODULE_ADMIN_DASHBOARD_TWITTER_APP_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Do you want to enable this Module ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );


      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Sort Order',
          'configuration_key' => 'MODULE_ADMIN_DASHBOARD_TWITTER_APP_SORT_ORDER',
          'configuration_value' => '80',
          'configuration_description' => 'Sort order of display. Lowest is displayed first.',
          'configuration_group_id' => '6',
          'sort_order' => '2',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Select the width to display',
          'configuration_key' => 'MODULE_ADMIN_DASHBOARD_TWITTER_APP_CONTENT_WIDTH',
          'configuration_value' => '12',
          'configuration_description' => 'Select a number between 1 to 12',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_content_module_width_pull_down',
          'date_added' => 'now()'
        ]
      );
    }


    public function keys()
    {
      return [
        'MODULE_ADMIN_DASHBOARD_TWITTER_APP_STATUS',
        'MODULE_ADMIN_DASHBOARD_TWITTER_APP_CONTENT_WIDTH',
        'MODULE_ADMIN_DASHBOARD_TWITTER_APP_SORT_ORDER'
      ];
    }
  }
