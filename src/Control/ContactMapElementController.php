<?php

namespace BiffBangPow\Element\Control;

use DNADesign\Elemental\Controllers\ElementController;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;

class ContactMapElementController extends ElementController
{
    protected function init()
    {
        parent::init();
        $provider = SiteConfig::current_site_config()->MapsProvider;
        if ($provider === 'google') {
            $mapsKey = SiteConfig::current_site_config()->GoogleKey;
            if ($mapsKey != "") {
                Requirements::javascriptTemplate('biffbangpow/silverstripe-contactmap-element:client/dist/javascript/gmaps.js', ['KEY' => $mapsKey]);
                $themeCSS = ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/elements/gmap.css');
                if ($themeCSS) {
                    Requirements::css($themeCSS);
                } else {
                    Requirements::css('biffbangpow/silverstripe-contactmap-element:client/dist/css/gmap.css', '', ['defer' => true]);
                }
            }
        } else {
            Requirements::javascript('biffbangpow/silverstripe-contactmap-element:client/dist/javascript/osm.js', ['type' => false]);
            $themeCSS = ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/elements/gmap.css');
            if ($themeCSS) {
                Requirements::css($themeCSS);
            } else {
                Requirements::css('biffbangpow/silverstripe-contactmap-element:client/dist/css/osm.css', '', ['defer' => true]);
            }
        }

        $themeCSS = ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/elements/contactmap.css');
        if ($themeCSS) {
            Requirements::css($themeCSS, '', ['defer' => true]);
        }
    }
}
