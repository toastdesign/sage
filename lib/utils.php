<?php

namespace Roots\Sage\Utils;

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function get_search_form() {
  $form = '';
  locate_template('/templates/searchform.php', true, false);
  return $form;
}
add_filter('get_search_form', __NAMESPACE__ . '\\get_search_form');

/**
 * Takes an array of booleans and returns `true` if *any* of them are `true`.
 *
 * @link http://codex.wordpress.org/Conditional_Tags list of WordPress Conditional Tags
 *
 * @param array list of booleans or callbacks that return booleans
 *
 * @return boolean
 */
function conditional_reduction(array $conditionals = []) {
  $results = array_reduce($conditionals, function ($result, $conditional) {
    $args = (array) $conditional;
    $fn = array_shift($args);
    return $result || (is_bool($conditional) && $conditional) || (is_callable($fn) && call_user_func_array($fn, (array) $args));
  }, false);

  return apply_filters('sage/conditional_reduction', $results, $conditionals);
}
