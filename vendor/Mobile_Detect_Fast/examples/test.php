<?php


    /*
     * Result:
     *
     *   Mobile_Detect native version detection for common UA:
     *   4.4974 seconds native version for common UA
     *
     *   Mobile_Detect_Fast fast version detection for common UA:
     *   0.5429 seconds fast version for common UA
     *
     *   Mobile_Detect native version detection for not mobile:
     *   0 fails
     *   Mobile_Detect native version detection for mobile:
     *   29 fails
     *   4.1812 seconds native version
     *
     *   Mobile_Detect_Fast fast version detection for not mobile:
     *   0 fails
     *   Mobile_Detect_Fast fast version detection for mobile:
     *   28 fails
     *   1.7568 seconds fast version
     */

    $commonUA  = file('common.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $browserUA = file('browser.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $mobileUA  = file('mobile.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $start = microtime(true);
    echo "Mobile_Detect native version detection for common UA:\n";
    for ($i=0; $i<20; $i++) {
        foreach($commonUA as $ua) {
            $detect = new Mobile_Detect(null, $ua);
            $detect->isMobile();
        }
    }
    $end = microtime(true);
    $elapsed = number_format($end - $start, 4);
    echo "$elapsed seconds native version for common UA\n\n";

    echo "Mobile_Detect_Fast fast version detection for common UA:\n";
    $fails = 0;
    $start = microtime(true);
    for ($i=0; $i<20; $i++) {
        foreach($commonUA as $ua) {
            $detect = new Mobile_Detect_Fast(null, $ua);
            $detect->isMobileFast();
        }
    }
    $end = microtime(true);
    $elapsed = number_format($end - $start, 4);
    echo "$elapsed seconds fast version for common UA\n\n";

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
