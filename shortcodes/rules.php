<?php


if (!function_exists('judge_familiar_rules')) :

function judge_familiar_rules($atts, $content = null, $tag)
{
    if (empty($content)) {
        return shortcode_error($tag, 'must have non-empty content');
    }

    $re = '/<p>([0-9]+\\.[0-9a-z]+) (.*)<\\/p>/';
    $items = preg_match_all($re, $content, $matches);
    if (!$items) {
        return shortcode_error($tag, 'must have at least one paragraph.');
    }

    $result = '<ul>';
    $subrule = false;

    for ($item = 0; $item < $items; ++$item) {
        $rule = $matches[1][$item];
        if (preg_match('/^[0-9]+\.([0-9])+$/', $rule, $id)) {
            if ($subrule) {
                $result .= '</li></ul>';
                $subrule = false;
            }
            $result .= sprintf(
              '<li id="%s"><strong>%s</strong> %s</li>',
              $id[1],
              $matches[1][$item],
              do_shortcode($matches[2][$item])
            );
        } elseif (preg_match('/^[0-9]+\.([0-9]+[a-z])$/', $rule, $id)) {
            if (!$subrule) {
                $result .= '<li><ul>';
                $subrule = true;
            }
            $result .= sprintf(
              '<li id="%s"><strong>%s</strong> %s</li>',
              $id[1],
              $matches[1][$item],
              do_shortcode($matches[2][$item])
            );
        } else {
            return shortcode_error($tag, 'has a invalid CR number (XXX.YZ).');
        }
    }
    if ($subrule) {
        $result .= '</ul>';
    }
    $result .= '</ul>';

    return sprintf('<div class="cr-rules">%s</div>', $result);
}

endif;
add_shortcode('rules', 'judge_familiar_rules');

if (!function_exists('judge_familiar_rules_enqueue')) :

function judge_familiar_rules_enqueue($posts)
{
    global $post;

    if (has_shortcode($post->post_content, 'rules')) {
        wp_enqueue_style(
          'judge-familiar-rules',
          get_template_directory_uri().'/css/rules.css'
        );
        wp_enqueue_script(
          'judge-familiar-rules',
          get_template_directory_uri().'/js/rules.js',
          array(''),
          '20120206',
          true
        );
    }
}
endif;
add_action('wp_enqueue_scripts', 'judge_familiar_rules_enqueue');
