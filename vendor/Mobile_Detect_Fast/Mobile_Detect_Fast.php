<?php

/*
 *
 * The MIT License
 *
 * Copyright 2015 Enrique FCB.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */


/**
 * Mobile Detect Fast
 * =====================
 *
 * Class to increase the performance of Mobile Detect lib.
 *
 * Requires Mobile Detect: https://github.com/serbanghita/Mobile-Detect
 *
 * Compatible whith 2.8.x of Mobile Detect
 *
 * @link        gi repo:     https://bitbucket.org/lanaguani/mobile-detect-fast
 *
 * @version     2.8.2-dev
 */
class Mobile_Detect_Fast extends Mobile_Detect
{
    protected $isMobile   = null;
    protected $isTablet   = null;
    protected $isPhone    = null;
    protected $UAforMobile;
    protected $UAforTablet;

    /**
     *  Words to exclude in regex for mobile and tablet.
     */
    protected $irrelevant = array(
        'forMobile' => array(
            'Safari.[\d\.]*',
            'Firefox.[\d\.]*',
            'Chrome.[\d\.]*',
            'Chromium.[\d\.]*',
            'MSIE.[\d\.]*',
            'Opera\/[\d\.]*',
            'Mozilla.[\d\.]*',
            'AppleWebKit.[\d\.]*',
            'Trident.[\d\.]*',
            'Windows NT.[\d\.]*',
            'Macintosh.',
            'Ubuntu',
            'Linux',
            'Intel',
            'Mac OS X',
            'Gecko.[\d\.]*',
            'KHTML',
            'like Gecko',
            'compatible',
            'x86_..',
            'i686',
            'x64',
            'X11',
            'rv:[\d\.]*',
            'Version.[\d\.]*',
            'WOW64',
            'Win64',
            '\.NET CLR [\d\.]*',
            'Presto.[\d\.]*',
            'http:\/\/[^ ]+',
            'https:\/\/[^ ]+',
            'Googlebot',
            'msnbot',
            'YandexBot',
            'Media Center PC',
            'facebookexternalhit',
        ),
        'forTablet' => array(
            'Safari.[\d\.]*',
            'Firefox.[\d\.]*',
            'Chrome.[\d\.]*',
            'Chromium.[\d\.]*',
            'MSIE.[\d\.]*',
            'Opera\/[\d\.]*',
            'Mozilla.[\d\.]*',
            'AppleWebKit.[\d\.]*',
            'Trident.[\d\.]*',
            'Windows NT.[\d\.]*',
            'Macintosh.',
            'Ubuntu',
            'Linux',
            'Intel',
            'Mac OS X',
            'Gecko.[\d\.]*',
            'KHTML',
            'like Gecko',
            'compatible',
            'x86_..',
            'i686',
            'x64',
            'X11',
            'rv:[\d\.]*',
            'Version.[\d\.]*',
            'WOW64',
            'Win64',
            '\.NET CLR [\d\.]*',
            'Presto.[\d\.]*',
            'http:\/\/[^ ]+',
            'https:\/\/[^ ]+',
            'Googlebot',
            'msnbot',
            'YandexBot',
            'Media Center PC',
            'facebookexternalhit',
        ),
    );
    protected $mobileSure = array(
        'Mobile',
        'mobile',
        'iPhone',
        'iPod',
        'BlackBerry',
        'IEMobile',
        'Kindle',
        'NetFront',
        'Silk-Accelerated',
        'hpwOS',
        'webOS',
        'Minimo',
        'Opera Mobi',
        'Opera Mini',
        'Blazer',
        'Dolfin',
        'Fennec',
    );
    protected $tabletSure = array(
        'Tablet',
        'tablet',
        'iPad',
    );
    protected $phoneSure = array(
        'iPhone',
        'Phone',
        'phone',
    );


    /**
     * Construct.
     *
     * @param array  $headers   Specify the headers as injection. Should be PHP _SERVER flavored.
     *                          If left empty, will use the global _SERVER['HTTP_*'] vars instead.
     * @param string $userAgent Inject the User-Agent header. If null, will use HTTP_USER_AGENT
     *                          from the $headers array instead.
     */
    public function __construct(array $headers = null, $userAgent = null)
    {
        parent::__construct($headers, $userAgent);
        $regexForMobile    = '/'.implode('|', $this->irrelevant['forMobile']).'/';
        $regexForTablet    = '/'.implode('|', $this->irrelevant['forTablet']).'/';
        $this->UAforMobile = preg_replace($regexForMobile, '', $this->userAgent);
        $this->UAforTablet = preg_replace($regexForTablet, '', $this->userAgent);
        // sometimes the user agent is something like "( ; , 2.1 )" in that case it is not necessary check
        if (!preg_match('/\w/', $this->UAforMobile)) {
            $this->isMobile = false;
            $this->isPhone  = false;
        }
        if (!preg_match('/\w/', $this->UAforTablet)) {
            $this->isTablet = false;
        }
        foreach ($this->mobileSure as $str) {
            if (strpos($this->userAgent, $str) !== false) {
                $this->isMobile = true;
            }
        }
        foreach ($this->tabletSure as $str) {
            if (strpos($this->userAgent, $str) !== false) {
                $this->isTablet = true;
            }
        }
        foreach ($this->phoneSure as $str) {
            if (strpos($this->userAgent, $str) !== false) {
                $this->isPhone = true;
            }
        }
    }

    /**
     * Check if the device is mobile.
     *
     * @param  null $httpHeaders
     * @return bool
     */
    public function isMobileFast($httpHeaders = null)
    {
        if ($this->isMobile === null) {
            $this->isMobile = $this->isMobile($this->UAforMobile, $httpHeaders);
        }
        return $this->isMobile;
    }

    /**
     * Check if the device is tablet.
     *
     * @param  null $httpHeaders
     * @return bool
     */
    public function isTabletFast($httpHeaders = null)
    {
        if ($this->isTablet === null) {
            $this->isTablet = $this->isTablet($this->UAforTablet, $httpHeaders);
        }
        return $this->isTablet;
    }

    /**
     * Check if the device is phone, is mobile and not tablet.
     *
     * @param  null $httpHeaders
     * @return bool
     */
    public function isPhoneFast($httpHeaders = null)
    {
        if ($this->isPhone === null) {
            if ($this->isMobileFast($httpHeaders) && !$this->isTabletFast($httpHeaders)) {
                $this->isPhone = true;
            } else {
                $this->isPhone = false;
            }
        }
        return $this->isPhone;
    }

}
