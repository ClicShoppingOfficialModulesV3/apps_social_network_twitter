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

  use ClicShopping\OM\HTML;

  class content_width extends \ClicShopping\Apps\SocialNetwork\TwitterSN\Module\ClicShoppingAdmin\Config\ConfigParamAbstract
  {

    public $default = '12';
    public $sort_order = 50;

    protected function init()
    {
      $this->title = $this->app->getDef('cfg_twittersn_content_width_title');
      $this->description = $this->app->getDef('cfg_twittersn_content_width_description');
    }

    public function getInputField()
    {

//      $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
//      $name = $this->default;

      $width = array(array('id' => '12', 'text' => '12'),
        array('id' => '11', 'text' => '11'),
        array('id' => '10', 'text' => '10'),
        array('id' => '9', 'text' => '9'),
        array('id' => '8', 'text' => '8'),
        array('id' => '7', 'text' => '7'),
        array('id' => '6', 'text' => '6'),
        array('id' => '5', 'text' => '5'),
        array('id' => '4', 'text' => '4'),
        array('id' => '3', 'text' => '3'),
        array('id' => '2', 'text' => '2'),
        array('id' => '1', 'text' => '1'),
      );

      $input = HTML::selectMenu($this->key, $width, $this->getInputValue());

      return $input;
    }
  }