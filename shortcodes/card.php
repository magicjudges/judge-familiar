<?php

if (!function_exists('judge_familiar_card')) :

function judge_familiar_card($atts, $content = null, $tag)
{
    $atts = shortcode_atts(array(
        'title' => '',
    ), $atts);

    $title = '';
    if($atts['title']) {
      $title = sprintf(
          '<div class="card-header">%s</div>',
          $atts['title']
      );
    }

    if($content) {
        $content = sprintf(
            '<div class="card-block">%s</div>',
            do_shortcode($content)
        );
    }

    return sprintf(
        '<div class="card">%s%s</div>',
        $title,
        $content
    );
}

endif;
add_shortcode('panel', 'judge_familiar_card');
