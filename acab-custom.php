<?php
/*
Plugin Name: A Certain Anime Blog Custom Tweaks
Plugin URI: https://anime.jacenboy.com/
Description: Custom add-ins and functions for A Certain Anime Blog
Version: 1.1
Author: JacenBoy
Author URI: https://jacenboy.com/
License: AGPLv3 or later
License URL: https://www.gnu.org/licenses/agpl-3.0.html

Copyright (C) 2019  JacenBoy

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published
by the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

defined("ABSPATH") or exit;

class acab_custom {
  // Load custom frontend CSS
  // Kinda pointless since the Customizer exists
  public function load_styles() {
    $css = scandir(plugin_dir_path( __FILE__ ) . "/css");
    foreach ($css as $c) {
      if (!in_array($c, array(".", "..", "index.html"))) {
        wp_enqueue_style(explode(".", $c)[0], plugin_dir_url( __FILE__ ) . "css/{$c}");
      }
    }
  }

  // Load custom backend CSS
  public function load_admin_styles() {
    $css = scandir(plugin_dir_path( __FILE__ ) . "/admincss");
    foreach ($css as $c) {
      if (!in_array($c, array(".", "..", "index.html"))) {
        wp_enqueue_style(explode(".", $c)[0], plugin_dir_url( __FILE__ ) . "admincss/{$c}");
      }
    }
  }

  // Load custom frontend JavaScript
  public function load_scripts() {
    $js = scandir(plugin_dir_path( __FILE__ ) . "/js");
    foreach ($js as $j) {
      if (!in_array($j, array(".", "..", "index.html"))) {
        ?>
        <script src="<?php echo plugin_dir_url( __FILE__ ) . "js/{$j}"; ?>"></script>
        <?php
      }
    }
  }

  // Load custom backend JavaScript
  public function load_admin_scripts() {
    $js = scandir(plugin_dir_path( __FILE__ ) . "/adminjs");
    foreach ($js as $j) {
      if (!in_array($j, array(".", "..", "index.html"))) {
        ?>
        <script src="<?php echo plugin_dir_url( __FILE__ ) . "adminjs/{$j}"; ?>"></script>
        <?php
      }
    }
  }

  // Custom shortcode for generating Kitsu links
  public function kitsu_shortcode($atts, $content = "kitsu.io") {
    if (!$atts['slug'] || !$atts['medium']) return $content;
    $atts['slug'] = strtolower($atts['slug']);
    $atts['medium'] = strtolower($atts['medium']);
    if ($atts['medium'] != "anime" && $atts['medium'] != "manga") return $content;
    return "<a href=\"https://kitsu.io/{$atts['medium']}/{$atts['slug']}/\" target=\"_blank\" rel=\"nofollow\">{$content}</a>";
  }
}

// Load the custom CSS and JavaScript on the frontend
add_action("wp_enqueue_scripts", "acab_custom::load_styles");
add_action("wp_footer", "acab_custom::load_scripts");
// Load the custom CSS and JavaScript on the admin page
add_action("admin_enqueue_scripts", "acab_custom::load_admin_styles");
add_action("admin_footer", "acab_custom::load_admin_scripts");

// Add the custom shortcodes
add_shortcode("kitsu", "acab_custom::kitsu_shortcode");