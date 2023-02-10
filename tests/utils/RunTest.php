<?php

namespace utils;

require_once('ReportHandler.php');

$shortOpts = "t:";  // Test type: pos|neg - required
$shortOpts .= "i::"; // Index of the test file to run - optional
$shortOpts .= "f::"; // Custom XLS file name without extension - optional
$shortOpts .= "d::"; // Show debug in console - optional
$shortOpts .= "l::"; // Show file list - optional

$longOpts = [
    "type:",
    "indexes::",
    "file::",
    "debug::",
    "list::"
];

$options = getopt($shortOpts, $longOpts);

(new RunTest($options));

class RunTest
{
    /**
     * @var mixed|null
     */
    private $whichTest;

    /**
     * @var string|null
     */
    private $indexes;

    /**
     * @var string
     */
    private $spreadSheet;

    /**
     * @var bool|mixed
     */
    private $debug;

    /**
     * Processing the options from CLI
     *
     * @param array $options
     * @throws \SleekDB\Exceptions\IOException
     * @throws \SleekDB\Exceptions\InvalidArgumentException
     * @throws \SleekDB\Exceptions\JsonException
     */
    public function __construct(array $options)
    {
        $this->whichTest = $options['t'] ?? ($options['type'] ?? null);
        $list = $options['l'] ?? ($options['list'] ?? false);
        $this->indexes = $options['i'] ?? ($options['indexes'] ?? null);
        $this->spreadSheet = $options['f'] ?? ($options['file'] ?? 'TestData');
        $this->debug = $options['d'] ?? ($options['debug'] ?? true);
        if (!$this->whichTest || !in_array($this->whichTest, ['pos', 'neg'])) {
            $this->usageHelp();
        } else {
            if ($this->whichTest == 'pos') {
                $fileList = glob(__DIR__ . '/../integration/positiveflow/*.php');
            } else {
                $fileList = glob(__DIR__ . '/../integration/negativeflow/*.php');
            }
            if ($list) {
                print_r($fileList);
            } else {
                $this->run($fileList);
            }
        }
    }

    /**
     * Run test flow
     *
     * @param $fileList
     * @return void
     * @throws \SleekDB\Exceptions\IOException
     * @throws \SleekDB\Exceptions\InvalidArgumentException
     * @throws \SleekDB\Exceptions\JsonException
     */
    protected function run($fileList)
    {
        $files = [];
        $this->checkIndex($fileList,$files);
        foreach ($files as $file) {
            $baseName = basename($file);
            $className = str_split($baseName, strpos($baseName, '.'))[0];
            $explodeClassName = explode('_', $className);
            $methodName = 'test_' . $explodeClassName[0] . '_' . $explodeClassName[1];
            if ($this->debug) {
                echo "############################\n";
                echo " RUN\n";
                echo " $baseName\n";
                echo "############################\n";
                echo "\n";
            }
            exec("php -r \"require '$file'; $className::$methodName('$this->spreadSheet');\"", $output);
            if ($this->debug) {
                print_r($output);
                $output = '';
            }
            sleep(5);
        }

        $reportHandler = new \ReportHandler();

        $testDataStore = $reportHandler->initTestStore();
        $testDataAll = $testDataStore->findAll(["_id" => "asc"]);

        $reportsStore = $reportHandler->initReportStore();

        $fullTest = [
            'name' => '#' . ($reportsStore->getLastInsertedId() + 1) . ' - Report ' . date("m-d-Y H:i:s"),
            'tests_number' => count($testDataAll),
            'report' => $testDataAll,
            'options' => [
                'type' => $this->whichTest,
                'indexes' => $this->indexes,
                'file' => $this->spreadSheet,
                'debug' => $this->debug
            ]
        ];

        $reportsStore->updateOrInsert($fullTest, false);

        $testDataStore->deleteStore();
    }

    /**
     * Check if we run all the tests or just the given test files
     *
     * @param $fileList
     * @param $files
     * @return void
     */
    private function checkIndex($fileList, &$files)
    {
        if ($this->indexes !== null) {
            $indexes = explode(',', $this->indexes);
            array_walk($indexes, function ($index, $k) use (&$indexes) {
                $indexes[$k] = vsprintf("%02d", $index);
            });
            array_walk($fileList, function ($file) use ($indexes, &$files) {
                $fileName = basename($file);
                $pattern = '/_*(\d+)_/';
                preg_match($pattern, $fileName, $matches);
                if (isset($matches[1]) && in_array($matches[1], $indexes)) {
                    $files[] = $file;
                }
            });
        } else {
            $files = $fileList;
        }
    }

    /**
     * Usage help
     *
     * @return void
     */
    protected function usageHelp()
    {
        echo <<<HELP
        Usage: php RunTest.php [-t|--type]=<type of the test pos|neg> - required
            php RunTest.php [-i|--indexes]=<index of the test file to run, comma seperated>
            php RunTest.php [-f|--file]=<filename without extension>
            php RunTest.php [-d|--debug]=<set the visibility of the logs in the console 0|1 - optional, default is 1>
            php RunTest.php [-l|--list]=<list the test files you want to run. so you can check file indexes.>
        examples:
            php RunTest.php -t=pos
            php RunTest.php -t=pos -i=1 -f=FileName -d=0
            php RunTest.php -t=neg -i=1,3,10 -f=FileName -d=1
            php RunTest.php --type=pos --indexes=1,2,3 --file=FileName --debug=1
            php RunTest.php --type=pos --list=1

HELP;
    }
}