<?php
/*
Plugin Name: WP AMP Helper
Plugin URI: https://github.com/apricoton/wp-amp-helper
Description: Helper script for AMP single page.
Version: 1.0
Author: apricoton
Author https://develop.apricoton.jp/
License: MIT
*/

class wpAmpHelper
{
    const DS = DIRECTORY_SEPARATOR;
    
    public static function ampFilter($content)
    {
        if (is_single() && isset($_GET['amp'])) {
            $content = preg_replace('!<img(.+?)>!i', '<div class="amp_img"><amp-img layout="responsive" \1></div>', $content);
        }
        
        return $content;
    }
    
    public static function ampPage()
    {
        if (is_single() && isset($_GET['amp'])) {
            $single_amp_tmpl = TEMPLATEPATH . self::DS . 'amp' . self::DS . 'single.php';
            if (!file_exists($single_amp_tmpl)) return;
            include $single_amp_tmpl;
            exit;
        }
    }
    
    public static function header()
    {
        if (is_single() && !isset($_GET['amp'])) {
            $permalink  = get_permalink();
            $permalink .= (strpos($permalink, '?') !== false) ? '&' : '?';
            $permalink .= 'amp';
            echo '<link rel="amphtml" href="' . htmlspecialchars($permalink) . '">';
        }
    }
}

add_action('template_redirect', ['WpAmpHelper', 'ampPage']);
add_action('wp_head', ['WpAmpHelper', 'header']);
add_filter('the_content', ['WpAmpHelper', 'ampFilter']);