<?php
  /**
  * homepage
  */

  $default_config = array("time_to_refresh_bg" => 20000, "hover_color" => "#999"); // Make sure that we at least always have a value for these
  $config_file    = json_decode(file_get_contents("config.json"), true);
  $config         = array_merge($default_config, $config_file);
  unset($config['protected']); // Make sure we don't expose any protected fields to the front end

  function get_current_url() {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['SERVER_NAME'];
    return $protocol . $domainName;
  }

?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
      <title><?= $config['title']; ?></title>

      <meta name="viewport" content="width=device-width, initial-scale=1">

      <link rel="stylesheet" type="text/css" href="hp_assets/css/font-awesome.min.css" />
      <link rel="stylesheet" type="text/css" href="hp_assets/css/bootstrap.min.css" />
      <link rel="stylesheet" type="text/css" href="hp_assets/css/main.css" />
      <style type="text/css">
        #links-wrap a:hover {color: <?= $config['hover_color']; ?>;}
      </style>
      <link rel="shortcut icon" href="/jawa.ico">
  </head>

  <body id="homepage">
    <div id="bg-overlay">&nbsp;</div>
    <!-- Line below is to preload the font when the page loads -->
    <span class="fa fa-asterisk" style="opacity: 0;">&nbsp;</span>

    <div id="mobile-menu-wrap" class="hidden-lg">
      <a href="#" class="bg "><span class="fa fa-bars">&nbsp;</span></a>
    </div>

    <div id="clock-wrap" class="menu-item bg">
      <span id="clock"></span>
    </div>

    <div id="links-wrap" class="menu-item bg">
      <?php
        foreach ($config['items'] as $i => $item) {
          $icon = $item['icon'];
          $link = str_replace("{{cur}}", get_current_url(), $item['link']);

          echo '<div class="link col-md-4 col-xs-12"><a href="' . $link . '" title="' . $item['alt'] . '"><i class="fa fa-' . $icon . '"></i></a></div>';
        }
      ?>
    </div>

    <div id="search-wrap" class="menu-item bg">
      <div id="searchBar" class='searchContainer'>
          <input type="text" id='searchInput' placeholder="ex. !g searches Google" onfocus="showSearchHelp()" onblur="hideSearchHelp()" onkeydown="handleQuery(event,this.value)">
      </div>
      <div id="searchHelp">
        <ul>
          <li><span>!g</span> →   Google</li>
          <li><span>!d</span> →   DuckDuckGo</li>
          <li><span>!r</span> →   Reddit</li>
          <li><span>!so</span> → Stack Overflow</li>
          <li><span>!sh</span> → Shodan</li>
          <li><span>!av</span> → Audio/Video</li>
          <li><span>!sa</span> → Software Archive</li>
        </ul>
      </div>
    </div>

    <script type="text/javascript" src="hp_assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="hp_assets/js/mousetrap.min.js"></script>
    <script type="text/javascript">
      $.config = <?= json_encode($config); ?>;
    </script>
    <script type="text/javascript" src="hp_assets/js/main.js"></script>
    <script type="text/javascript" src="hp_assets/js/searchHandler.js"></script>
  </body>
</html>
