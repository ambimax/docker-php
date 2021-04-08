<?php

namespace Ambimax\Parser;

class parseIniFiles
{
    protected $defaultGroups = [
        "",
        "apc",
        "arg_separator",
        "assert",
        "cli",
        "curl",
        "date",
        "filter",
        "highlight",
        "iconv",
        "mail",
        "mbstring",
        "mysqlnd",
        "openssl",
        "pcre",
        "phar",
        "session",
        "sqlite3",
        "syslog",
        "url_rewriter",
        "user_ini",
        "zend",
        "zlib",
    ];

    public function setConfigDir($dir, $directoryIdentifier = 'config', $validate = true)
    {
        if($validate && !is_dir($dir)) {
            throw new \OutOfBoundsException(sprintf('Directory "%s" not found!', $dir));
        }
        $this->_dirs[$directoryIdentifier] = rtrim($dir, '/');
    }

    public function getConfigDirPath($filename, $directoryIdentifier = 'config')
    {
        if(!isset($this->_dirs[$directoryIdentifier])) {
            throw new \Exception(sprintf('Directory config "%s" not found!', $directoryIdentifier));
        }

        return $this->_dirs[$directoryIdentifier] . DIRECTORY_SEPARATOR . $filename;
    }

    public function parse()
    {
        $this->output("Parsing ini variables");
        $vars = $this->getParsedIniVariables();

        $this->output("Replacing ini files with variabled files");
        $this->replaceIniFilesWithEnvVariables($vars);

        $this->output("Save default value helper for usage");
        $this->writeDefaultValues($vars);
        $this->writeNonEmptyDefaultValues($vars);
        $this->writePhpModules($vars);
    }


    public function getParsedIniVariables()
    {
        foreach (ini_get_all() as $configKey => $values) {

            $group = '';
            if(preg_match('/([a-z0-9_]+)\./i', $configKey, $match)) {
                $group = $match[1];
            }

            $envName = strtoupper(sprintf('PHP_%s', str_replace('.', '_', $configKey)));
            $defaultValue = $values['global_value'];

            $envString = false === strpos($defaultValue, ' ')
                ? sprintf('ENV %s=%s', $envName, $defaultValue)
                : sprintf('ENV %s="%s"', $envName, $defaultValue);

            $vars[$configKey] = [
                'group' => $group,
                'envName' => $envName,
                'envValue' => $defaultValue,
                'envString' => $envString,
                'iniEnvString' => sprintf('%s=%s', $configKey, '${' . $envName . '}'),
            ];
        }

        return $vars;
    }

    public function replaceIniFilesWithEnvVariables($vars)
    {
        list($groupedRows, $rows) = $this->generateGroupedFileRows($vars, 'iniEnvString');

        foreach($groupedRows as $group => $rows)
        {
            if(empty($group)) {
                $group = 'php';
            }
            $file = $this->getConfigDirPath("$group.ini");
            $this->saveToFile($file, $rows);
        }
    }

    public function writeDefaultValues($vars)
    {
        list($groupedRows, $rows, $nonEmptyGroupedRows, $nonEmptyRows) = $this->generateGroupedFileRows($vars, 'envString', '# Defaults for %s');

        $defaultRows = [];
        foreach($groupedRows as $group => $rows) {
            if(in_array($group, $this->defaultGroups)) {
                $defaultRows = array_merge($defaultRows, $rows);
            } else {
                $this->saveToFile($this->getConfigDirPath(sprintf('%s.env', $group), 'assets'), $rows);
            }
        }

        $this->saveToFile($this->getConfigDirPath("all.env", 'assets'), $defaultRows);
    }

    public function writeNonEmptyDefaultValues($vars)
    {
        list($groupedRows, $rows, $nonEmptyGroupedRows) = $this->generateGroupedFileRows($vars, 'envString', '# Defaults for %s');

        $defaultRows = [];
        foreach($nonEmptyGroupedRows as $group => $rows) {
            if(in_array($group, $this->defaultGroups)) {
                $defaultRows = array_merge($defaultRows, $rows);
            } else {
                $this->saveToFile($this->getConfigDirPath(sprintf('%s.nonempty.env', $group), 'assets'), $rows);
            }
        }

        $this->saveToFile($this->getConfigDirPath("all.nonempty.env", 'assets'), $defaultRows);
    }

    public function writePhpModules()
    {
        $this->saveToFile($this->getConfigDirPath("modules.list", 'assets'), get_loaded_extensions());
    }

    public function generateGroupedFileRows($vars, $rowIndexKey, $headerCommentTpl = '; Defaults for %s')
    {
        // group
        $grouped = [];
        foreach($vars as $configKey => $var) {
            $group = $var['group'];
            $grouped[$group][$configKey] = $var;
        }

        // generate rows
        $rows = [];
        $nonEmptyRows = [];
        $groupedRows = [];
        $nonEmptyGroupedRows = [];
        foreach($grouped as $group => $vars) {

            if($headerCommentTpl) {
                $groupName = !empty($group) ? $group : 'php';
                $title = sprintf($headerCommentTpl, $groupName);
                $rows[] = $title;
                $nonEmptyRows[] = $nonEmptyRows;
                $groupedRows[$group][] = $title;
                $nonEmptyGroupedRows[$group][] = $title;
            }

            foreach($vars as $var) {
                $rows[] = $var[$rowIndexKey];
                $groupedRows[$group][] = $var[$rowIndexKey];

                if(isset($var['envValue']) && $var['envValue'] !== "") {
                    $nonEmptyRows[] = $var[$rowIndexKey];
                    $nonEmptyGroupedRows[$group][] = $var[$rowIndexKey];
                }
            }
        }

        return [$groupedRows, $rows, $nonEmptyGroupedRows, $nonEmptyRows];
    }

    public function saveToFile($filename, array $rows = [])
    {
        $this->output("Saving to $filename");
        $this->createDirectory(dirname($filename));
        file_put_contents($filename, implode(PHP_EOL, $rows));

        return $this;
    }

    public function createDirectory($path, $chmod = 0777, $recursive = true)
    {
        if(!is_dir($path)) {
            if (!mkdir($path, $chmod, $recursive)) {
                die('Error creating directory');
            }
        }
    }

    public function output($message)
    {
        echo $message.PHP_EOL;
    }
}

if(isset($argc) && $argc) {
    $parser = new parseIniFiles();
    $parser->setConfigDir(getenv('PHP_INI_DIR').'conf.d', 'config');
    $parser->setConfigDir(getenv('PHP_INI_DIR').'assets', 'assets', false);
    $parser->parse();
}
