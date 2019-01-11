<?php

/**
 * @category   OpenCart
 * @package    SEO Tags Generator
 * @copyright  © Serge Tkach, 2017, https://opencartforum.com/profile/717101-sergetkach/
 */

if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
	include 'seo_tags_generator_7.php';
} elseif (version_compare(PHP_VERSION, '5.4.0') >= 0) {
  include 'seo_tags_generator_54_56.php';
}