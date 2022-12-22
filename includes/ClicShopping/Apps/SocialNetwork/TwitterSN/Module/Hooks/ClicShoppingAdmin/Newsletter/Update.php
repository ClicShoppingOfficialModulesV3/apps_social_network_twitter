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

  class Update implements \ClicShopping\OM\Modules\HooksInterface
  {

    public function execute()
    {
      if (isset($_POST['newsletter_id']) && $_GET['Update']) {
        $newsletter_id = HTML::sanitize($_POST['newsletter_id']);

        $CLICSHOPPING_Db = Registry::get('Db');

        if (isset($_POST['newsletters_twitter'])) {
          $newsletters_twitter = 0;
        } else {
          $newsletters_twitter = 1;
        }

        $sql_data_array = ['newsletters_twitter' => (int)$newsletters_twitter];

        $CLICSHOPPING_Db->save('newsletters', $sql_data_array, ['newsletters_id' => (int)$newsletter_id]);

      }
    }
  }