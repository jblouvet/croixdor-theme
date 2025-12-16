<?php
add_filter('embed_oembed_html', 'wrap_embed_with_div', 10, 3);
function wrap_embed_with_div($html, $url, $attr) {
  return '<div class="video-container">' . $html . '</div>';
}