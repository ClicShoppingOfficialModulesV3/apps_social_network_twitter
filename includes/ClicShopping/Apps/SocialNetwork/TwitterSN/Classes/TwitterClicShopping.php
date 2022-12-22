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

  namespace ClicShopping\Apps\SocialNetwork\TwitterSN\Classes;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTTP;
  use ClicShopping\OM\CLICSHOPPING;

  require_once(CLICSHOPPING_BASE_DIR . 'Apps/SocialNetwork/TwitterSN/API/vendor/autoload.php');

  use DG\Twitter\Twitter;

  class TwitterClicShopping
  {

    public function __construct()
    {

      if (defined('CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY')) {
        $this->consumerKey = CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY;
        $this->consumerSecret = CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_SECRET;
        $this->accessToken = CLICSHOPPING_APP_TWITTER_TW_ACCESS_TOKEN;
        $this->accessTokenSecret = CLICSHOPPING_APP_TWITTER_TW_ACCESS_TOKEN_SECRET;
      }
    }

    /**
     * Load ClicShopping Information and authentification on twitter
     * Read only the tweet
     * @param string $twitter_authentificate
     * @return string twitter_authentificate_clicshopping
     * @access public
     * osc_twitter_authentificate_clicshopping
     */
    public function TwitterAuthentificateClicshopping()
    {
// lecture dela classe twitter
      $twitter_authentificate_clicshopping = new \Twitter($this->consumerKey, $this->consumerSecret, $this->accessToken, $this->accessTokenSecret);

      if (!is_dir(CLICSHOPPING::BASE_DIR . 'Work/Cache/Twitter')) {
        mkdir(CLICSHOPPING::BASE_DIR . 'Work/Cache/Twitter', 0777, true);
      }

// enables caching (path must exists and must be writable!)
      $twitter_authentificate_clicshopping::$cacheDir = CLICSHOPPING::BASE_DIR . 'Work/Cache/Twitter';

      return $twitter_authentificate_clicshopping;
    }


    /**
     * Send a message on Twitter concerning the clicshopping administrator
     *
     * @param string $twitter_authentificate_administrator
     * @return string $data, $parse
     * @access public
     * osc_send_twitter
     */

    public function SendTwitter()
    {
      if (isset($_POST['twitter_msg'])) {
        $twitter_message = $_POST['twitter_msg'];
        if (strlen($twitter_message) < 1) {
          $error = 1;
        } else {
          $this->TwitterAuthentificateClicshopping()->send($_POST['twitter_msg'], $_POST['twitter_media']);
        }
      }

      if (isset($_POST['twitter_msg']) && !isset($error)) {
      } else if (isset($error)) {
        echo CLICSHOPPING::getDef('text_error_twitter');
        return -1;
      }
      return;
    }

    public function CreateTwitter($text = null, $products_id = null)
    {

      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Language = Registry::get('Language');
      $CLICSHOPPING_Template = Registry::get('TemplateAdmin');

      if (CLICSHOPPING_APP_TWITTER_TW_STATUS == 'True' && !empty(CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY)) {
        if (!is_null($products_id)) {

          $Qproducts = $CLICSHOPPING_Db->prepare('select distinct p.products_image,
                                                                   p.products_status,
                                                                   pd.products_name,
                                                                   pd.products_description_summary
                                                   from :table_products p,
                                                        :table_products_description pd
                                                    where p.products_id = :products_id
                                                    and p.products_id = pd.products_id
                                                    and pd.language_id = :language_id
                                                    and p.products_status = 1
                                                    and p.products_archive = 0
                                                   ');
          $Qproducts->bindInt(':products_id', $products_id);
          $Qproducts->bindInt(':language_id', $CLICSHOPPING_Language->getId());
          $Qproducts->execute();

          if ($Qproducts->fetch() !== false) {

            if (MODULE_HEADER_TAGS_PRODUCT_TWITTER_CARD_TYPE == 'twitter_clicshopping' && !empty($Qproducts->value('products_image'))) {
              $twitter_image = $CLICSHOPPING_Template->getDirectoryPathTemplateShopImages() . $Qproducts->value('products_image');
            } else {
              $twitter_image = '';
            }

            $twitter_link = ' : ' . HTTP::getShopUrlDomain() . CLICSHOPPING::getConfig('bootstrap_file') . '?Products&Description&products_id=' . $products_id;
            $twitter_products_summary = $Qproducts->value('products_description_summary');
            $twitter_products_name = $Qproducts->value('products_name');
            $twitter_text = $text;

            $text_twitter_products = $twitter_text . ' ' . $twitter_products_name . ' ' . $twitter_link;

            $_POST['twitter_msg'] = $text_twitter_products;

            if (MODULE_HEADER_TAGS_PRODUCT_TWITTER_CARD_TYPE == 'twitter_clicshopping' && $Qproducts->valueInt('products_status') == 1) {
              $_POST['twitter_media'] = $twitter_image;
            }
          }
        }

        return static::SendTwitter();
      }
    }


    public function cacheFiles()
    {

      require_once(CLICSHOPPING::BASE_DIR . 'Apps/SocialNetwork/TwitterSN/API/Twitter.php');
      $twitter = new \Twitter();

      if (!is_dir(CLICSHOPPING::BASE_DIR . 'Work/Cache/Twitter')) {
        mkdir(CLICSHOPPING::BASE_DIR . 'Work/Cache/Twitter', 0777, true);
      }

// enables caching (path must exists and must be writable!)
//      $twitter::$cacheDir = CLICSHOPPING::BASE_DIR . 'Work/Cache/Twitter';

    }


    public function loadMe($number = 10)
    {
      $me = $this->TwitterAuthentificateClicshopping()->load(\Twitter::ME, $number);
      return $me;
    }

    public function clickableLink($status)
    {
      $link = \Twitter::clickable($status);
      return $link;
    }

    public function loadMeAndFriend($number = 10)
    {
      $me_and_friend = $this->TwitterAuthentificateClicshopping()->load(\Twitter::ME_AND_FRIENDS, $number);
      return $me_and_friend;
    }

    public function replies()
    {
      $replies = $this->TwitterAuthentificateClicshopping()->load(\Twitter::REPLIES);
      return $replies;
    }

    public function search($text)
    {
      $text = TwitterAuthentificateClicshopping()->search($text);
      return $text;
    }
  }