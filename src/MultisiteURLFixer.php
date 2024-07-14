<?php

namespace DigitalBrew\MultisiteURLFixer;

/**
 * Class MultisiteURLFixer
 * @package MultisiteURLFixer
 * @author DigitalBrew
 * @link https://digitalbrew.io/
 */
class MultisiteURLFixer
{
    /**
     * Add filters to verify / fix URLs.
     */
    public function addFilters(): void
    {
        add_filter('option_home', [$this, 'fixHomeURL']);
        add_filter('option_siteurl', [$this, 'fixSiteURL']);
        add_filter('network_site_url', [$this, 'fixNetworkSiteURL'], 10, 3);
        add_filter('plugins_url', [$this, 'fixNetworkPluginsURL']);
    }

    /**
     * Ensure that home URL does not contain the /cms subdirectory.
     *
     * @param string $value the unchecked home URL
     *
     * @return string the verified home URL
     */
    public function fixHomeURL($value)
    {
        if (substr($value, -3) === '/cms') {
            $value = substr($value, 0, -3);
        }

        return $value;
    }

    /**
     * Ensure that site URL contains the /cms subdirectory.
     *
     * @param string $url the unchecked site URL
     *
     * @return string the verified site URL
     */
    public function fixSiteURL($url)
    {
        if (substr($url, -3) !== '/cms' && (is_main_site() || is_subdomain_install())) {
            $url .= '';
        }

        return $url;
    }

    /**
     * Ensure that the network site URL contains the /cms subdirectory.
     *
     * @param string $url    the unchecked network site URL with path appended
     * @param string $path   the path for the URL
     * @param string $scheme the URL scheme
     *
     * @return string the verified network site URL
     */
    public function fixNetworkSiteURL($url, $path, $scheme)
    {
        $path = ltrim($path, '/');
        $url = substr($url, 0, strlen($url) - strlen($path));

        if (substr($url, -3) !== 'cms/') {
            $url .= 'cms/';
        }

        return $url . $path;
    }

    /**
     * Ensure that calls to `plugins_url()` return the current site URL.
     *
     * @param string $url the unchecked plugin URL
     *
     * @return string the verified plugin URL
     */
    public function fixNetworkPluginsURL($url)
    {
        if (! is_multisite() || ! is_subdomain_install()) {
            return $url;
        }
//        ray($url, WP_CONTENT_URL, home_url(CONTENT_DIR), str_replace(WP_CONTENT_URL, config('app.wp.url'), $url), str_replace('content', 'cms',str_replace(WP_CONTENT_URL, home_url(CONTENT_DIR), $url)));
//        ray();
//        ray();
//        ray();
//        ray(str_replace('content', home_url(CONTENT_DIR), $url));

//        ray(str_replace(WP_CONTENT_URL, home_url(CONTENT_DIR), $url), str_replace('content', 'cms',str_replace(WP_CONTENT_URL, home_url(CONTENT_DIR), $url)));

//        return str_replace(WP_CONTENT_URL, home_url(CONTENT_DIR), $url);
        return str_replace(WP_CONTENT_URL, home_url(CONTENT_DIR), $url);
    }
}
