<?php


if (!function_exists('judge_familiar_alert')) :

function judge_familiar_alert($atts, $content = null, $tag)
{
    if (!$content) {
        return '';
    }

    $atts = shortcode_atts(array(
        'color' => 'blue',
        'dismissable' => 'false',
    ), $atts);

    switch ($atts['color']) {
      case 'green':
          $class = 'alert-success';
          break;
      case 'yellow':
          $class = 'alert-warning';
          break;
      case 'red':
          $class = 'alert-danger';
          break;
      case 'grey':
          $class = 'alert-grey';
          break;
      default:
          $class = 'alert-info';
    }

    $button = '';
    if ($atts['dismissable'] === 'true') {
        $class .= ' alert-dismissable fade in';
        $button = sprintf(
          '<button type="button" class="close" data-dismiss="alert" aria-label="%s">'.
          '<span aria-hidden="true">&times;</span>'.
          '<span class="sr-only">%s</span>'.
          '</button>',
          __('Close', 'judge-familiar'),
          __('Close', 'judge-familiar')
      );
    }

    return sprintf(
        '<div class="alert %s" role="alert">%s %s</div>',
        $class,
        $button,
        do_shortcode($content)
    );
}

endif;
add_shortcode('alert', 'judge_familiar_alert');
