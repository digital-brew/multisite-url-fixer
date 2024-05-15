<?php

/**
 * Plugin Name: Multisite URL Fixer
 * Plugin URI: https://github.com/digital-brew/multisite-url-fixer/
 * Description: Fixes WordPress issues with home and site URL on multisite when using Themosis
 * Version: 1.0.1
 * Author: DigitalBrew
 * Author URI: https://digitalbrew.io/
 * License: MIT License
 */

class_exists('DigitalBrew\MultisiteURLFixer') || require_once __DIR__.'/vendor/autoload.php';

use DigitalBrew\MultisiteURLFixer\MultisiteURLFixer;

if (is_multisite()) {
    (new MultisiteURLFixer)->addFilters();
}
