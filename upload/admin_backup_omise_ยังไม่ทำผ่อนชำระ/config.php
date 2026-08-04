<?php


if($_SERVER['SERVER_NAME'] == 'localhost') {
    // HTTP
    define('HTTP_SERVER', 'http://localhost/landmart/upload/admin/');
    define('HTTP_CATALOG', 'http://localhost/landmart/upload/');

    // HTTPS
    define('HTTPS_SERVER', 'http://localhost/landmart/upload/admin/');
    define('HTTPS_CATALOG', 'http://localhost/landmart/upload/');

    // DIR
    define('DIR_APPLICATION', 'C:/xampp7427/htdocs/landmart/upload/admin/');
    define('DIR_SYSTEM', 'C:/xampp7427/htdocs/landmart/upload/system/');
    define('DIR_IMAGE', 'C:/xampp7427/htdocs/landmart/upload/image/');
    define('DIR_STORAGE', DIR_SYSTEM . 'storage/');
    define('DIR_CATALOG', 'C:/xampp7427/htdocs/landmart/upload/catalog/');
    define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
    define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
    define('DIR_CONFIG', DIR_SYSTEM . 'config/');
    define('DIR_CACHE', DIR_STORAGE . 'cache/');
    define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
    define('DIR_LOGS', DIR_STORAGE . 'logs/');
    define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
    define('DIR_SESSION', DIR_STORAGE . 'session/');
    define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

    // DB
    define('DB_DRIVER', 'mysqli');
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'landmart');
    define('DB_PORT', '3306');
    define('DB_PREFIX', 'oc_');
} elseif($_SERVER['SERVER_NAME'] == 'ford.orangeworkshop.info') {
    // HTTP
    define('HTTP_SERVER', 'http://ford.orangeworkshop.info/landmart/upload/admin/');
    define('HTTP_CATALOG', 'http://ford.orangeworkshop.info/landmart/upload/');

    // HTTPS
    define('HTTPS_SERVER', 'http://ford.orangeworkshop.info/landmart/upload/admin/');
    define('HTTPS_CATALOG', 'http://ford.orangeworkshop.info/landmart/upload/');

    // DIR
    define('DIR_APPLICATION', '/home/zford/domains/ford.orangeworkshop.info/public_html/landmart/upload/admin/');
    define('DIR_SYSTEM', '/home/zford/domains/ford.orangeworkshop.info/public_html/landmart/upload/system/');
    define('DIR_IMAGE', '/home/zford/domains/ford.orangeworkshop.info/public_html/landmart/upload/image/');
    define('DIR_STORAGE', DIR_SYSTEM . 'storage/');
    define('DIR_CATALOG', '/home/zford/domains/ford.orangeworkshop.info/public_html/landmart/upload/catalog/');
    define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
    define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
    define('DIR_CONFIG', DIR_SYSTEM . 'config/');
    define('DIR_CACHE', DIR_STORAGE . 'cache/');
    define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
    define('DIR_LOGS', DIR_STORAGE . 'logs/');
    define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
    define('DIR_SESSION', DIR_STORAGE . 'session/');
    define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

    // DB
    define('DB_DRIVER', 'mysqli');
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'zford_landmart');
    define('DB_PASSWORD', 'qwaszx');
    define('DB_DATABASE', 'zford_landmart');
    define('DB_PORT', '3306');
    define('DB_PREFIX', 'oc_');
} elseif($_SERVER['SERVER_NAME'] == 'landmart.co.th' or $_SERVER['SERVER_NAME'] == 'www.landmart.co.th') {
    // HTTP
    define('HTTP_SERVER', 'http://www.landmart.co.th/admin');
    define('HTTP_CATALOG', 'http://www.landmart.co.th/');

    // HTTPS
    define('HTTPS_SERVER', 'https://www.landmart.co.th/admin/');
    define('HTTPS_CATALOG', 'https://www.landmart.co.th/');

    // DIR
    define('DIR_APPLICATION', '/home/landmartco/domains/landmart.co.th/public_html/admin/');
    define('DIR_SYSTEM', '/home/landmartco/domains/landmart.co.th/public_html/system/');
    define('DIR_IMAGE', '/home/landmartco/domains/landmart.co.th/public_html/image/');
    define('DIR_STORAGE', DIR_SYSTEM . 'storage/');
    define('DIR_CATALOG', '/home/landmartco/domains/landmart.co.th/public_html/catalog/');
    define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
    define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
    define('DIR_CONFIG', DIR_SYSTEM . 'config/');
    define('DIR_CACHE', DIR_STORAGE . 'cache/');
    define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
    define('DIR_LOGS', DIR_STORAGE . 'logs/');
    define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
    define('DIR_SESSION', DIR_STORAGE . 'session/');
    define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

    // DB
    define('DB_DRIVER', 'mysqli');
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'landmartco_new');
    define('DB_PASSWORD', 'YiNHGw3Nzn40G');
    define('DB_DATABASE', 'landmartco_new');
    define('DB_PORT', '3306');
    define('DB_PREFIX', 'oc_');

}

// OpenCart API
define('OPENCART_SERVER', 'https://www.opencart.com/');
