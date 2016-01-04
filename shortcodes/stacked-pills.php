<?php

if (!function_exists('judge_familiar_stacked_pills')) :

/**
 * Usage: [stacked-pills]
 *          [stacked-pills-item name="Name in Nav"]Content[/stacked-pills-item]
 *        [/stacked-pills].
 */
function judge_familiar_stacked_pills($atts, $content, $tag)
{
    if (empty($content)) {
        return shortcode_error($tag, 'must have non-empty content');
    }

    // Regex magic! https://xkcd.com/1171/
    $pattern = '\[stacked-pills-item( name="([^"]*)")?( active="([^"]*)")?\](.*)\[\/stacked-pills-item\]';
    $items = preg_match_all('/'.$pattern.'/sU', $content, $matches);
    if (!$items) {
        return shortcode_error($tag, 'must have at least one <code>stacked-pills-item</code>');
    }

    $nav_items = array();

    for ($item = 0; $item < $items; ++$item) {
        if ($matches[2][$item]) {
            $name = $matches[2][$item];
        } else {
            $name = substr(wp_strip_all_tags($matches[5][$item]), 0, 20).'...';
        }

        array_push($nav_items, array(
          'name' => $name,
          'active' => ($matches[4][$item] === 'true'),
          'content' => ltrim(do_shortcode($matches[5][$item]), '</p>'),
        ));
    }

    return sprintf(
      '<div class="row judge-familiar-stacked-pills">'.
      '<ul class="nav nav-pills nav-stacked col-lg-2" role="tablist">%s</ul>'.
      '<div class="tab-content col-lg-10">%s</div>'.
      '</div>',
      implode(array_map(function ($nav_item) {
        return sprintf(
          '<li class="nav-item"><a href="#%s" class="nav-link %s" role="tab" data-toggle="tab">%s</a></li>',
          sanitize_title($nav_item['name']),
          $nav_item['active'] ? 'active' : '',
          $nav_item['name']
        );
      }, $nav_items)),
      implode(array_map(function ($nav_item) {
        return sprintf(
          '<div role="tabpanel" class="tab-pane fade %s" id="%s">%s</div>',
          $nav_item['active'] ? 'in active' : '',
          sanitize_title($nav_item['name']),
          $nav_item['content']
        );
      }, $nav_items))
    );
}
endif;
add_shortcode('stacked-pills', 'judge_familiar_stacked_pills');

if (!function_exists('judge_familiar_stacked_pills_item')) :

/**
 * Always throws an error, is registered to make wordpress omit stripping it.
 */
function judge_familiar_stacked_pills_item($atts, $content)
{
    return shortcode_error($tag, 'must be used within <code>stacked-pills</code>');
}
endif;
add_shortcode('stacked-pills-item', 'judge_familiar_stacked_pills_item');

if (!function_exists('judge_familiar_stacked_pills_enqueue')) :

function judge_familiar_stacked_pills_enqueue($posts)
{
    global $post;

    if (has_shortcode($post->post_content, 'stacked-pills')) {
        wp_enqueue_style(
          'judge-familiar-stacked-pills',
          get_template_directory_uri().'/css/stacked-pills.css'
        );
        wp_enqueue_script(
          'judge-familiar-stacked-pills',
          get_template_directory_uri().'/js/stacked-pills.js',
          array('bootstrap-v4'),
          '20120206',
          true
        );
    }
}
endif;
add_action('wp_enqueue_scripts', 'judge_familiar_stacked_pills_enqueue');
