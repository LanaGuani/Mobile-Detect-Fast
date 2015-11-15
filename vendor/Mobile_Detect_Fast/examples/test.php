<?php

    /*
     * Result:
     *
     *   Mobile_Detect native version detection for not mobile:
     *   33 fails
     *   Mobile_Detect native version detection for mobile:
     *   36 fails
     *   3.2852 seconds native version
     *
     *   Mobile_Detect_Fast fast version detection for not mobile:
     *   33 fails
     *   Mobile_Detect_Fast fast version detection for mobile:
     *   35 fails
     *   1.6445 seconds fast version
     *
     */

    $browserUA = file('browser.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);  // http://www.zytrax.com/tech/web/browser_ids.htm
    $mobileUA  = file('mobile.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);   // http://www.zytrax.com/tech/web/mobile_ids.html

    echo "Mobile_Detect native version detection for not mobile:\n";
    $fails = 0;
    $start = microtime(true);

    foreach($browserUA as $ua) {
        $detect = new Mobile_Detect(null, $ua);
        if ($detect->isMobile()) {
//             echo "Fail on: $ua\n";
            $fails++;
        }
    }
    echo "$fails fails\n";

    echo "Mobile_Detect native version detection for mobile:\n";
    $fails = 0;
    foreach($mobileUA as $ua) {
        $detect = new Mobile_Detect(null, $ua);
        if (!$detect->isMobile()) {
//             echo "Fail on: $ua\n";
            $fails++;
        }
    }
    echo "$fails fails\n";

    $end = microtime(true);
    $elapsed = number_format($end - $start, 4);
    echo "$elapsed seconds native version\n\n";

    echo "Mobile_Detect_Fast fast version detection for not mobile:\n";
    $fails = 0;
    $start = microtime(true);

    foreach($browserUA as $ua) {
        $detect = new Mobile_Detect_Fast(null, $ua);
        if ($detect->isMobileFast()) {
//             echo "Fail on: $ua\n";
            $fails++;
        }
    }
    echo "$fails fails\n";

    echo "Mobile_Detect_Fast fast version detection for mobile:\n";
    $fails = 0;
    foreach($mobileUA as $ua) {
        $detect = new Mobile_Detect_Fast(null, $ua);
        if (!$detect->isMobileFast()) {
//             echo "Fail on: $ua\n";
            $fails++;
        }
    }
    echo "$fails fails\n";

    $end = microtime(true);
    $elapsed = number_format($end - $start, 4);
    echo "$elapsed seconds fast version\n\n";
