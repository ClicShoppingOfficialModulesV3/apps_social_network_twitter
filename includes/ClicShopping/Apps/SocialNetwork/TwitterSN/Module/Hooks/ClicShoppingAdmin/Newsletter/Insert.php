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
  use ClicShopping\OM\HTML;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\TwitterSN as TwitterSNApp;

  class Insert implements \ClicShopping\OM\Modules\HooksInterface
  {

    public function execute()
    {
      global $newsletters_id, $newsletter_error;

      $CLICSHOPPING_Db = Registry::get('Db');

      if (isset($_POST['newsletters_twitter']) && $_GET['Insert']) {
        if (isset($_POST['newsletters_twitter'])) {
          $newsletters_twitter = 1;
        } else {
          $newsletters_twitter = 0;
        }

        if ($newsletter_error === false) {
          $sql_data_array = ['newsletters_twitter' => (int)$newsletters_twitter];

          $CLICSHOPPING_Db->save('newsletters', $sql_data_array, ['newsletters_id' => (int)$newsletters_id]);
        }
      }
    }
  }