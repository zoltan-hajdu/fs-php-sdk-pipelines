# Browser emulation for PHP SDK

---

1. Include the Emulate.php in InitiateCheckoutAPI.php
    * require_once \_\_DIR\_\_ . '/../../Born/Selenium/Emulate.php';
    * use Born\Selenium\Emulate;
    * Emulate::run($link, $acc);
    
2. It is necessary to check that chromedriver has the same major version as Google Chrome
   * check Google Chrome version
     * google-chrome --version
   * download chromedriver from https://chromedriver.chromium.org/downloads
   * unzip chromedriver to /tests/utils/Shellnium
   * Make chromedriver and jq executable
       * chmod +x chromedriver
       * chmod +x jq

3. Chromedriver will run automatically if we run the tests if all set correctly