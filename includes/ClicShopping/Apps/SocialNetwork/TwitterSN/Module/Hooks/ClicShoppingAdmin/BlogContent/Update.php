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

  namespace ClicShopping\Apps\SocialNetwork\TwitterSN\Module\Hooks\ClicShoppingAdmin\BlogContent;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;
  use ClicShopping\OM\HTTP;
  use ClicShopping\OM\CLICSHOPPING;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\Classes\TwitterClicShopping;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\TwitterSN as TwitterSNApp;

  class Update implements \ClicShopping\OM\Modules\HooksInterface
  {
    protected $app;

    public function __construct()
    {
      if (!Registry::exists('TwitterSN')) {
        Registry::set('TwitterSN', new TwitterSNApp());
      }

      $this->app = Registry::get('TwitterSN');

      $this->app->loadDefinitions('Module/Hooks/ClicShoppingAdmin/BlogContent/Update');

      if (!Registry::exists('TwitterAPI')) {
        Registry::set('TwitterAPI', new TwitterClicShopping());
      }

      $this->TwitterAPI = Registry::get('TwitterAPI');
    }

    public function execute()
    {
      $CLICSHOPPING_Language = Registry::get('Language');

      if (isset($_GET['blog_content_id'])) {
        $id = HTML::sanitize($_GET['blog_content_id']);

        if (isset($_GET['customers_group_id'])) {
          $customers_group_id = HTML::sanitize($_POST['customers_group_id']);
        }

        $QblogContentTwitter = $this->app->db->prepare('select  pd.blog_content_name,
                                                                 p.blog_content_id,
                                                                 p.blog_content_status
                                                         from :table_blog_content p,
                                                              :table_blog_content_description pd
                                                         where p.blog_content_id = :blog_content_id
                                                         and p.blog_content_id = pd.blog_content_id
                                                         and pd.language_id = :language_id
                                                        ');
        $QblogContentTwitter->bindInt(':blog_content_id', (int)$id);
        $QblogContentTwitter->bindInt(':language_id', (int)$CLICSHOPPING_Language->getId());
        $QblogContentTwitter->execute();

        $blog_content_name = $QblogContentTwitter->value('blog_content_name');
        $blog_content_id = $QblogContentTwitter->valueInt('blog_content_id');

        if (isset($_POST['products_twitter']) && isset($_GET['Update'])) {
          if (defined('CLICSHOPPING_APP_TWITTER_TW_STATUS')) {
            if (CLICSHOPPING_APP_TWITTER_TW_STATUS == 'True' && !empty(CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY)) {
              if ($customers_group_id === 0) {
                $_POST['twitter_msg'] = $this->app->getDef('text_blog_twitter') . ' ' . $blog_content_name . ' ' . HTTP::getShopUrlDomain() . CLICSHOPPING::getConfig('bootstrap_file') . '?&Blog&Content&blog_content_id=' . $blog_content_id;
                $this->TwitterAPI->SendTwitter();
              }
            }
          }
        }
      }
    }
  }