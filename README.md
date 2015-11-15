# Mobile Detect Fast

Class to increase the performance of Mobile Detect lib.

## Requires Mobile Detect

https://github.com/serbanghita/Mobile-Detect

### Performance
```
    $uaList = array(
        'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)',
        'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31',
        'Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.15',
        'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0',
        'Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0',
        'Mozilla/5.0 (X11; Linux i686; rv:20.0) Gecko/20100101 Firefox/20.0',
        'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31',
        'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31',
        'Mozilla/5.0 (X11; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0',
        'msnbot-media/1.1 ( http://search.msn.com/msnbot.htm)',
        'Opera/9.80 (Windows NT 6.2; WOW64; MRA 6.0 (build 6011)) Presto/2.12.388 Version/12.15',
        'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)',
        'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; InfoPath.1)',
        'Mozilla/5.0 (compatible; Googlebot/2.1;  http://www.google.com/bot.html)',
        'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.94 Safari/537.36',
        'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31',
        'Opera/9.80 (Windows NT 6.1; Win64; x64) Presto/2.12.388 Version/12.15',
        'Mozilla/5.0 (compatible; YandexImages/3.0;  http://yandex.com/bots)',
        'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1106.241 YaBrowser/1.5.1106.241 Safari/537.4',
        'Opera/9.80 (X11; Linux i686) Presto/2.12.388 Version/12.15',
        'Mozilla/5.0 (compatible; bingbot/2.0;  http://www.bing.com/bingbot.htm)',
        'Opera/9.80 (Windows NT 6.2; WOW64) Presto/2.12.388 Version/12.15',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:19.0) Gecko/20100101 Firefox/19.0',
        'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_1 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8B117 Safari/6531.22.7 (compatible; Googlebot-Mobile/2.1;  http://www.google.com/bot.html)',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:14.0) Gecko/20100101 Firefox/14.0.1',
        'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)',
        'Opera/9.80 (Windows NT 6.1) Presto/2.12.388 Version/12.15',
        'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0',
        'Mozilla/5.0 (Windows NT 5.1; rv:20.0) Gecko/20100101 Firefox/20.0',
    );

    $start = microtime(true);
    for ($i=0; $i<25; $i++) {
        foreach($uaList as $ua) {
            $detect = new Mobile_Detect(null, $ua);
            $detect->isMobile();
        }
    }
    $end = microtime(true);
    $elapsed = number_format($end - $start, 4);
    echo "$elapsed seconds native version\n";

    $start = microtime(true);
    for ($i=0; $i<25; $i++) {
        foreach($uaList as $ua) {
            $detect = new Mobile_Detect_Fast(null, $ua);
            $detect->isMobileFast();
        }
    }
    $end = microtime(true);
    $elapsed = number_format($end - $start, 4);
    echo "$elapsed seconds fast version\n";

```
### Result:
```
2.9710 seconds native version
0.4411 seconds fast version
```

### How

Mobile Detect uses a loop with regular expressions to determine the device, and PHP is very slow on this. By reducing the size of the string in the regular expression we get increased performance.

The information theory says that the most frequent words provide less information. Then if it appears in 100% of cases the word "Mozilla" can exclude it from the regular expression as it will be irrelevant in determining the device in the User Agent.

What we do is create an array ($irrelevant) with the list of "irrelevant words" to exclude of User Agent.

### Help

No method is overwritten, you can create an Mobile_Detect_Fast instance and continue using the native methods of the class.

Added 3 new methods: isMobileFast, isTabletFast and isPhoneFast.

```
    $detect = new Mobile_Detect_Fast();
    $detect->isMobileFast(); // equivalent to $detect->isMobile();
    $detect->isTabletFast(); // equivalent to $detect->isTablet();
    $detect->isPhoneFast();  // equivalent to $detect->isMobile() && !$detect->isTablet()
```
