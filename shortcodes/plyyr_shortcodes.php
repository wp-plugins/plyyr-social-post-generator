<?php

if (!class_exists('Plyyr_Shortcodes')) {

  class Plyyr_Shortcodes
  {

    const API = 'https://games.gamecloudnetwork.com';

    protected $options = array(
        'colorscheme' => 'standard',
        'display_sharebuttons' => true,
        'display_comments' => true,
        'display_recommendations' => true,
    );
    
    protected $recommendations = array();

    public function __construct()
    {
      // register shortcodes
      add_shortcode('gcn', array(&$this, 'create_gcn_embed_code'));
      add_shortcode('plyyr-item', array(&$this, 'create_gcn_embed_code'));
      add_shortcode('plyyr', array(&$this, 'create_plyyr_embed_code'));
      add_shortcode('plyyr-section', array(&$this, 'create_plyyr_embed_code'));
      $this->setOptions();
    }

    protected function setOptions()
    {
      $portal = $this->getPortalCode();
      if ($portal != "plyyr") {
        $response = file_get_contents(self::API . "/portal/settings?portal=$portal&plyyr");
        if ($response) {
          $content = json_decode($response, true);
          if ($content) {
            $this->options = $content['plyyr'];
          }
        }
      }
    }

    protected function getRecommendations($level_id)
    {
      $portal = $this->getPortalCode();
      $response = file_get_contents(self::API . "/level/" . $level_id . "/suggest?portal=" . $portal);
      if ($response) {
        $content = json_decode($response, true);
        if (is_array($content) && !isset($content['message'])) {
          $this->recommendations = $content;
        }
      }
    }

    public function getPortalCode()
    {
      $portal = trim(get_option('plyyr_setting_portal', 'plyyr'));
      if (!$portal) {
        $portal = 'plyyr';
      }
      return $portal;
    }

    /**
     * Allows to embed a plyyr item script code in wordpress friendly format.
     * Usage: <code>[plyyr-item quiz="trivia_quiz_54cbcf1246a10"]</code>
     */
    public function create_gcn_embed_code($atts, $content = null)
    {
      extract(shortcode_atts(array(
          'quiz' => '',
          'portal' => '',
                      ), $atts));

      $portal = $this->getPortalCode();
      $error = "
		<div style='border: 20px solid red; border-radius: 40px; padding: 40px; margin: 50px 0 70px;'>
			<h3>Ooops!</h3>
			<p style='margin: 0;'>Something is wrong with your plyyr-item shortcode. You need to specify a quiz id
            and check that your portal code \"$portal\" is enabled on plyyr. You can always remove it from the 
              <a href=\"/wp-admin/options-general.php?page=plyyr\">settings</a>. ({BRANCH}).</p>
		</div>";

      if (!$quiz) {
        return str_replace('{BRANCH}', '1', $error);
      } else {
        $response = file_get_contents(self::API . "/game/basic/$quiz?portal=$portal&plugin=wordpress");
        if ($response) {
          $content = json_decode($response, true);
        }

        if ($content) {
          if (isset($content['type']) && $content['type'] == 'error') {
            return str_replace('{BRANCH}', '2', $error);
          }
        } else {
          return str_replace('{BRANCH}', '3', $error);
        }

        $powered_link = '<span class="poweredbyplyr" style="font-color:#999999; font-style:italic;font-size: xx-small;text-decoration: none;">
          <a target="_blank" style="text-decoration: none" href="' . $content['plyyr_link'] . '">powered by <img src="' . 
                plugins_url('img/logo_micro_partners.png', __FILE__) . '"></a><br></span>';
        $hook = '<h2>' . $content['description'] . '</h2><br>' . $content['embed_code'] . '<br>';
        
        if ($this->options['display_sharebuttons']) {
          $hook .= $this->addShareButtons($content);
        }
        
        if ($this->options['display_comments']) {
          $hook .= $this->addComments($content);
        }
        
        if ($this->options['display_recommendations']) {
          $hook .= $this->addRecommendations($content);
        }
        
        $hook .= $powered_link;
        
        return $hook;
      }
    }
    
    protected function addShareButtons($quiz)
    {
      $fb_click = $this->getFbShareLink($quiz);
      $tw_click = $this->getTwShareLink($quiz);
      
      return
       '<p style="width:100%;display:block;"><span style="width:100%;display:block;text-align:center">Please share this with a friend who would like it!</span><br>'
      . '<span style="text-align;center;text-decoration: none;display:inline-block;background-color:#435698;color:white;width: 43%;cursor:pointer;padding-right:2.5%;padding-top:8px;padding-bottom:10px;padding-left:2.5%;margin:1%">'
      . '<a class="plyyr" href="#" ' . $fb_click . '> <img src="' .  plugins_url('img/fb.jpg', __FILE__). '"> <span style="margin-left: 5px;" >  Share on Facebook</span></a>'
      . '</span>'
      . '<span  style="text-align;center;ttext-decoration: none;display:inline-block;background-color:#3fabec;color:white;width: 43%;cursor:pointer;padding-right:2.5%;padding-top:8px;padding-bottom:10px;padding-left:2.5%;margin:1%">'
      . '<a class="plyyr" href="#" ' . $tw_click . '> <img src="' .  plugins_url('img/tw.jpg', __FILE__). '"> <span style="margin-left: 5px;"> Share on Twitter</span></a>'
      . '</span>'
      . '</p>';
    }
    
    protected function getFbShareLink($quiz)
    {      
      $url = "http://share.plyyr.com/share/portal/{portal_id}/level/{level_key}/referer/{referer}";
      $url = str_replace('{portal_id}', $this->getPortalCode(), $url);
      $url = str_replace('{level_key}', $quiz['id'], $url);
      $url = str_replace('{referer}', $this->customUrlEncode(site_url($_SERVER["REQUEST_URI"])), $url);
      $url = 'http://www.facebook.com/sharer.php?u=' . $url;
      return 'onclick="window.open(\'' . $url . '\', \'Facebook\', \'toolbar=0, status=0, width=560, height=360\');return false"';
    }
    
    protected function getTwShareLink($quiz)
    {
          $shareurl = "http://share.plyyr.com/share/portal/{portal_id}/level/{level_key}/referer/{referer}";
          $shareurl = str_replace('{portal_id}', $this->getPortalCode(), $shareurl);
          $shareurl = str_replace('{level_key}', $quiz['id'], $shareurl);
          $shareurl = str_replace('{referer}', $this->customUrlEncode(site_url($_SERVER["REQUEST_URI"])), $shareurl);

      $url = 'http://twitter.com/home?status=' . urlencode($quiz['title']) . ' @_plyyr ' . $shareurl;
      return 'onclick="window.open(\'' . $url . '\', \'Twitter\', \'toolbar=0, status=0, width=560, height=360\');return false"';
    }
    
    protected function customUrlEncode($url)
    {
      return str_replace(array('/', ':', '#', '?', '&'), array('_sl_', '_--', '-sh-', '-qu-', '6_6'), urldecode($url));
    }
    
    protected function addComments($quiz)
    {
      $current_url = site_url($_SERVER["REQUEST_URI"]);
      $script = '<code><script type="text/javascript"> 
              if (typeof FB != "object") {
                (function(d, s, id) {
                    if (d.getElementById(id)) return;
                    script = d.createElement("script");
                    script.type = "text/javascript";
                    script.async = true;
                    script.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.3&appId=1557934751108261";
                    d.getElementsByTagName("head")[0].appendChild(script);
                }(document, "head", "facebook-jssdk"));
              }
              </script></code>';     
 
        return $script . '<div style="display:block;margin-left:1%;width:100%">
                                          <span style="text-decoration: none;font-size:medium">Comments</span>
                                      </div><div class="plyyr" style="display:block;margin-left:1%;width:98%">
                  <div class="fb-comments fb_iframe_widget fb_iframe_widget_fluid" data-href="' . $current_url . '" data-numposts="5" data-colorscheme="light" data-width="100%"></div>
                </div>

                ';

  }
    
    protected function addRecommendations($quiz)
    {
      $this->getRecommendations($quiz['id']);
      
      $block = '';
      $html = '<div style="display:block;margin-left:1%;width:100%">
                <span style="text-decoration: none;font-size:medium">You Might Also Like</span>
            </div>
            <div style="display:block;margin-left:1%;width:100%; top:0%;vertical-align:text-top">';
      
      $block .= '<div class="item-container" style="position: relative;display:inline-block;width:32.5%;background-color:#fff;vertical-align:text-top;">
                    <div class="item" style="padding:1%;">
                        <a class="plyyrgrey" href="/?plyyr={level_slug}">
                          <img src="{level_picture}" class="img" style="display: inline-block;">
                          <span class="plyyr" style="text-decoration: none;font-size:small;" >{level_title}</span>
                        </a>
                    </div>
                </div>';

      $bob = 0;
      foreach ($this->recommendations as $r) {
        if ($bob < 3){
            $html .= str_replace(array('{level_slug}', '{level_picture}', '{level_title}'), array($r['slug'], $r['picture'], $r['title']), $block);
        }
        $bob++;
      }
      
      $html .= '</div>';
      return $html;
    }

    /**
     * Allows to embed the plyyr iframe code in wordpress friendly format.
     * Usage: <code>[plyyr portal="yourportalcode" style="width: 300px; height: 2000px; float: left"]</code>
     * If you are not sure about the style don't include the parameter.
     */
    public function create_plyyr_embed_code($atts, $content = null)
    {
      extract(shortcode_atts(array(
          'style' => ''
                      ), $atts));

      //Do we have a portal code?
      $portal = $this->getPortalCode();

      if (!$portal) {

        $portal = 'plyyr';
      } else {

        if ($style) {
          if (strpos($style, 'width') == false) {
            $style += 'width:795px;';
          }
        }

        $style = !$style ? "width: 795px; height: 2000px; float: left;margin-left:1%;" : $style;

        $hook = '<div class="gcntargets" style="' . $style . '" '
                . 'gcn-portal="' . $portal . '"></div>'
                . '<script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "https://s3.amazonaws.com/gcn-static-assets/jsmodules/plyyr_embedder.js"; fjs.parentNode.insertBefore(js, fjs);}(document, "script", "gameplayer-gcn"));</script>';

        $hook .= '<a target="_blank" href="http://plyyr.com">Powered by Plyyr.com</a>';
        return "$hook";
      }
    }

  }

}
