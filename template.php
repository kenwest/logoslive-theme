<?php

/**
 * @file
 * template.php
 */

/*
 * When viewing a node in 'full' mode, show contextual links. The navigation
 * tabs are hidden by CSS.
 */
function logoslive_node_view_alter(&$build) {
  if ($build['#view_mode'] == 'full' && $build['#entity_type'] == 'node' && isset($build['#node']) && !empty($build['#node']->nid)) {
    $build['#contextual_links']['node'] = array('node', array($build['#node']->nid));
  }
}

/*
 * An implementation of theme_entity_property()
 */
function logoslive_entity_property($variables) {
  return cbf_entity_property($variables);
}

/*
 * Ensure that all elements that have their font-size set have a height which is a multiple of 20px (@line-height-computed)
 */
function logoslive_preprocess_page(&$variables) {
  $script = '
    jQuery(document).ready( function() {
      function standardiseHeight(elements) {
        elements.each( function() {
          var height = jQuery(this).outerHeight(false);
          var fraction = height % 20;
          if (jQuery(this).css("font-size") !== "14px" && fraction !== 0) {
            jQuery(this).css("min-height",  height - fraction + 20);
          }
          else {
            standardiseHeight(jQuery(this).children().not("iframe, form"));
          }
        });
      };
      standardiseHeight(jQuery(".main-container"));
    });';
  drupal_add_js($script, 'inline');
}
