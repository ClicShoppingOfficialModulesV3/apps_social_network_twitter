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

  namespace ClicShopping\Apps\SocialNetwork\TwitterSN\Module\Hooks\ClicShoppingAdmin\Index;

  use ClicShopping\OM\Registry;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\Classes\TwitterClicShopping;

  use ClicShopping\Apps\SocialNetwork\TwitterSN\TwitterSN as TwitterSNApp;

  class PageTabTwitter implements \ClicShopping\OM\Modules\HooksInterface
  {
    protected $app;

    public function __construct()
    {

      if (!Registry::exists('TwitterSN')) {
        Registry::set('TwitterSN', new TwitterSNApp());
      }

      $this->app = Registry::get('TwitterSN');

      if (!Registry::exists('TwitterAPI')) {
        Registry::set('TwitterAPI', new TwitterClicShopping());
      }

      $this->TwitterAPI = Registry::get('TwitterAPI');
    }

    public function display()
    {

      if ((!defined('CLICSHOPPING_APP_TWITTER_TW_STATUS') || CLICSHOPPING_APP_TWITTER_TW_STATUS == 'False')) {
        return false;
      }

      $this->app->loadDefinitions('Module/Hooks/ClicShoppingAdmin/Index/PageTab');

      if (CLICSHOPPING_APP_TWITTER_TW_STATUS == 'True' && !empty(CLICSHOPPING_APP_TWITTER_TW_CONSUMMER_KEY)) {

        $statuses = $this->TwitterAPI->loadMe();

        $content = '';
        $output = '';

        foreach ($statuses as $status) {
          $content .= '<table width="100%" border="0" cellspacing="0" cellpadding="5" class="adminformTitle">';
          $content .= '<tr>';
          $content .= '<td width="60"><a href="https://twitter.com/' . $status->user->screen_name . '"><img border ="0"  src="' . htmlspecialchars($status->user->profile_image_url_https) . '"></a></td>';
          $content .= '<td class="mainTable" valign="top">';
          $content .= '<p class="main">' . date("j/n/Y H:i", strtotime($status->created_at)) . '</p>';
          $content .= '<span><a href="https://twitter.com/' . $status->user->screen_name . '" target="_blank" rel="noopener">' . htmlspecialchars($status->user->name) . '</a></span> :';
          $content .= $this->TwitterAPI->clickableLink($status);

          $output .= '</td>';
          $content .= '</tr>';
          $content .= '</table>';
        }

        $tab_title = $this->app->getDef('text_twitter');

        $output = <<<EOD
<!-- ######################## -->
<!--  Start TwitterSNApp      -->
<!-- ######################## -->
<div class="tab-pane" id="section_IndexTwitter_content">
  <div class="mainTitle">
  </div>
  {$content}
</div>
<script>
$('#section_IndexTwitter_content').appendTo('#indexTabs .tab-content');
$('#indexTabs .nav-tabs').append('    <li class="nav-item"><a data-target="#section_IndexTwitter_content" role="tab" data-toggle="tab" class="nav-link">{$tab_title}</a></li>');
</script>

<!-- ######################## -->
<!--  End TwitterSNApp      -->
<!-- ######################## -->

EOD;
        return $output;
      }
    }
  }
