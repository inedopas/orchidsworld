<?php

/**
 * @category   OpenCart
 * @package    SEO Tags Generator
 * @copyright  © Serge Tkach, 2017, https://opencartforum.com/profile/717101-sergetkach/
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
	include DIR_SYSTEM . '/library/seo_tags_generator/admin/controller/seo_tags_generator_7.php';
} elseif (version_compare(PHP_VERSION, '5.4.0') >= 0) {
  include DIR_SYSTEM . '/library/seo_tags_generator/admin/controller/seo_tags_generator_54_56.php';
} else {
  echo "Sorry! Version for PHP 5.3 Not Supported!<br>Please contact to author!";
	exit;
}