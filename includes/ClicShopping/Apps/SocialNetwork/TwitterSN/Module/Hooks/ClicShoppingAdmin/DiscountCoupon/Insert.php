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

  namespace ClicShopping\Apps\SocialNetwork\TwitterSN\Module\Hooks\ClicShoppingAdmin\DiscountCoupon;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;
  use ClicShopping\OM\HTTP;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\Classes\TwitterClicShopping;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\TwitterSN as TwitterSNApp;

  class Insert implements \ClicShopping\OM\Modules\HooksInterface
  {
    protected $app;

    public function __construct()
    {
      if (!Registry::exists('TwitterSN')) {
        Registry::set('TwitterSN', new TwitterSNApp());
      }

      $this->app = Registry::get('TwitterSN');

      $this->app->loadDefinitions('Module/Hooks/ClicShoppingAdmin/DiscountCoupon/Insert');

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

      $CLICSHOPPING_Currencies = Registry::get('Currencies');

      if (isset($_POST['coupons_id']) && isset($_GET['cID'])) {
        $coupons_id = (!empty($_POST['coupons_id']) ? $_POST['coupons_id'] : (!empty($_GET['cID']) ? $_GET['cID'] : DiscountCouponsAdmin::CreateRandomDiscountCoupons()));
      } else {
        $coupons_id = '';
      }

      if (isset($_POST['coupons_date_end'])) {
        $coupons_date_end = HTML::sanitize($_POST['coupons_date_end']);
      }

      if (isset($_POST['coupons_discount_amount'])) {
        $coupons_discount_amount = HTML::sanitize($_POST['coupons_discount_amount']);
      }

      if (isset($_POST['coupons_twitter'])) {
        $coupons_twitter = 1;
      } else {
        $coupons_twitter = 0;
      }

// Definir la position 0 ou 1 pour --> coupons_twitter : Code coupon envoye sur twitter
      $this->app->db->save('discount_coupons', ['coupons_twitter' => (int)$coupons_twitter],
        ['coupons_id' => HTML::outputProtected($coupons_id)]
      );

// send email to twitter
      if (defined('CLICSHOPPING_APP_TWITTER_TW_STATUS') && CLICSHOPPING_APP_TWITTER_TW_STATUS == 'True' && !empty(CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY)) {
        if (isset($_POST['products_twitter'])) {
          if (!empty($coupons_date_end)) $date_coupon_twitter_end = $this->app->getDef('text_discount_date_end') . $coupons_date_end;
          $text_discount = $this->app->getDef('text_new_discount_twitter', ['store_name' => STORE_NAME]) . ' ' . HTML::outputProtected($coupons_id) . ' : ' . $date_coupon_twitter_end . $this->app->getDef('text_twitter_amount') . ' ' . html_entity_decode($CLICSHOPPING_Currencies->format($coupons_discount_amount)) . ' : ' . HTTP::getShopUrlDomain();
          $_POST['twitter_msg'] = $text_discount;
          echo $this->SendTwitter();
        }
      }
    }
  }