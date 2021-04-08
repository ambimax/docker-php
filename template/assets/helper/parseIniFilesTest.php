<?php declare(strict_types=1);

namespace Ambimax\Parser;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;
use PHPUnit\Framework\TestCase;

final class parseIniFilesTest extends TestCase
{
    private $fs;
    private $root;
    protected $_parser;

    public function setUp(): void
    {
        ini_set("allow_url_fopen", '1');
        vfsStreamWrapper::register();

        // Setup vfsStream
        $this->root = vfsStream::setup('root');
        $structure = [
            'php' => [
                'conf.d' => [],
            ],
            'test.d' => []
        ];
        vfsStream::create($structure, $this->root);
        $this->fs = vfsStream::url('root');

        $this->_parser = new parseIniFiles();
        $this->_parser->setConfigDir($this->root->url() . '/php/conf.d');
    }

    public function testVarsAreProperlySet()
    {
        $vars = $this->_parser->getParsedIniVariables();
        $expected = $this->getExpectedIniVars();

        $this->assertSame($expected['allow_url_fopen'], $vars['allow_url_fopen']);
        $this->assertSame($expected['opcache.enable'], $vars['opcache.enable']);
        $this->assertSame($expected['assert.exception'], $vars['assert.exception']);
        $this->assertSame($expected['mbstring.http_output_conv_mimetypes'], $vars['mbstring.http_output_conv_mimetypes']);
        $this->assertSame($expected['sendmail_path'], $vars['sendmail_path']);
        $this->assertSame($expected['cli.prompt'], $vars['cli.prompt']);
    }

    public function testGenerateGroupedFileRowsWithHeader()
    {
        $vars = $this->getExpectedIniVars();
        list($groupedRows, $rows) = $this->_parser->generateGroupedFileRows($vars, 'iniEnvString');

        $this->assertSame([
            '; Defaults for php',
            'allow_url_fopen=${PHP_ALLOW_URL_FOPEN}',
            'max_execution_time=${PHP_MAX_EXECUTION_TIME}',
            'session.cookie_samesite=${PHP_SESSION_COOKIE_SAMESITE}',
            'sendmail_path=${PHP_SENDMAIL_PATH}',
        ], current($groupedRows));

        $this->assertSame([
            '; Defaults for opcache',
            'opcache.blacklist_filename=${PHP_OPCACHE_BLACKLIST_FILENAME}',
            'opcache.enable_file_override=${PHP_OPCACHE_ENABLE_FILE_OVERRIDE}',
            'opcache.enable=${PHP_OPCACHE_ENABLE}',
        ], $groupedRows['opcache']);

        $this->assertSame([
            '; Defaults for mbstring',
            'mbstring.http_output_conv_mimetypes=${PHP_MBSTRING_HTTP_OUTPUT_CONV_MIMETYPES}',
        ], $groupedRows['mbstring']);

        $this->assertSame([
            '; Defaults for cli',
            'cli.prompt=${PHP_CLI_PROMPT}',
        ], $groupedRows['cli']);

        $this->assertSame([
            '; Defaults for php',
            'allow_url_fopen=${PHP_ALLOW_URL_FOPEN}',
            'max_execution_time=${PHP_MAX_EXECUTION_TIME}',
            'session.cookie_samesite=${PHP_SESSION_COOKIE_SAMESITE}',
            'sendmail_path=${PHP_SENDMAIL_PATH}',
            '; Defaults for opcache',
            'opcache.blacklist_filename=${PHP_OPCACHE_BLACKLIST_FILENAME}',
            'opcache.enable_file_override=${PHP_OPCACHE_ENABLE_FILE_OVERRIDE}',
            'opcache.enable=${PHP_OPCACHE_ENABLE}',
            '; Defaults for assert',
            'assert.exception=${PHP_ASSERT_EXCEPTION}',
            '; Defaults for mbstring',
            'mbstring.http_output_conv_mimetypes=${PHP_MBSTRING_HTTP_OUTPUT_CONV_MIMETYPES}',
            '; Defaults for cli',
            'cli.prompt=${PHP_CLI_PROMPT}',
        ], $rows);
    }

    public function testGenerateGroupedFileRowsWithoutHeader()
    {
        $vars = $this->getExpectedIniVars();
        list($groupedRows, $rows) = $this->_parser->generateGroupedFileRows($vars, 'iniEnvString', false);

        $this->assertSame([
            'allow_url_fopen=${PHP_ALLOW_URL_FOPEN}',
            'max_execution_time=${PHP_MAX_EXECUTION_TIME}',
            'session.cookie_samesite=${PHP_SESSION_COOKIE_SAMESITE}',
            'sendmail_path=${PHP_SENDMAIL_PATH}',
        ], current($groupedRows));

        $this->assertSame([
            'opcache.blacklist_filename=${PHP_OPCACHE_BLACKLIST_FILENAME}',
            'opcache.enable_file_override=${PHP_OPCACHE_ENABLE_FILE_OVERRIDE}',
            'opcache.enable=${PHP_OPCACHE_ENABLE}',
        ], $groupedRows['opcache']);

        $this->assertSame([
            'mbstring.http_output_conv_mimetypes=${PHP_MBSTRING_HTTP_OUTPUT_CONV_MIMETYPES}',
        ], $groupedRows['mbstring']);

        $this->assertSame([
            'cli.prompt=${PHP_CLI_PROMPT}',
        ], $groupedRows['cli']);

        $this->assertSame([
            'allow_url_fopen=${PHP_ALLOW_URL_FOPEN}',
            'max_execution_time=${PHP_MAX_EXECUTION_TIME}',
            'session.cookie_samesite=${PHP_SESSION_COOKIE_SAMESITE}',
            'sendmail_path=${PHP_SENDMAIL_PATH}',
            'opcache.blacklist_filename=${PHP_OPCACHE_BLACKLIST_FILENAME}',
            'opcache.enable_file_override=${PHP_OPCACHE_ENABLE_FILE_OVERRIDE}',
            'opcache.enable=${PHP_OPCACHE_ENABLE}',
            'assert.exception=${PHP_ASSERT_EXCEPTION}',
            'mbstring.http_output_conv_mimetypes=${PHP_MBSTRING_HTTP_OUTPUT_CONV_MIMETYPES}',
            'cli.prompt=${PHP_CLI_PROMPT}',
        ], $rows);
    }

    public function testGetConfigDirPath()
    {
        $path = $this->fs . '/test.d';
        $this->_parser->setConfigDir($path);

        $this->assertSame(
            'vfs://root/test.d/file.php',
            $this->_parser->getConfigDirPath('file.php')
        );

        $this->assertSame(
            'vfs://root/test.d/ini/file.php',
            $this->_parser->getConfigDirPath('ini/file.php')
        );
    }

    public function testCreateDirectory()
    {
        $this->assertFalse($this->root->hasChild('php/testDirectory'));
        $this->_parser->createDirectory($this->fs . '/php/testDirectory');
        $this->assertTrue($this->root->hasChild('php/testDirectory'));
        $this->assertDirectoryExists($this->fs . '/php/testDirectory');
    }

    public function testSaveToFile()
    {
        $filename = $this->root->url() . '/php/conf.d/php.ini';
        $rows = [
            'Hello',
            'Guys',
            '!'
        ];

        $this->_parser->saveToFile($filename, $rows);

        $this->assertFileExists($filename);
        $this->assertEquals(
            implode(PHP_EOL, $rows),
            file_get_contents($filename)
        );
    }

    public function testReplaceIniFilesWithEnvVariables()
    {
        $this->_parser->setConfigDir($this->root->url() . '/php/conf.d');

        $vars = $this->getExpectedIniVars();
        $this->_parser->replaceIniFilesWithEnvVariables($vars);

        $this->assertEquals(
            $this->expectedFileContents('php.ini'),
            file_get_contents($this->root->url() . '/php/conf.d/php.ini')
        );

        $this->assertEquals(
            $this->expectedFileContents('assert.ini'),
            file_get_contents($this->root->url() . '/php/conf.d/assert.ini')
        );

        $this->assertEquals(
            $this->expectedFileContents('cli.ini'),
            file_get_contents($this->root->url() . '/php/conf.d/cli.ini')
        );

        $this->assertEquals(
            $this->expectedFileContents('opcache.ini'),
            file_get_contents($this->root->url() . '/php/conf.d/opcache.ini')
        );

        $this->assertEquals(
            $this->expectedFileContents('mbstring.ini'),
            file_get_contents($this->root->url() . '/php/conf.d/mbstring.ini')
        );
    }

    public function testWriteDefaultValues()
    {
        $vars = $this->getExpectedIniVars();
        $this->_parser->setConfigDir($this->root->url() . '/php/assets', 'assets', false);
        $this->_parser->writeDefaultValues($vars);

        $this->assertEquals(
            $this->expectedFileContents('all.env'),
            file_get_contents($this->root->url() . '/php/assets/all.env')
        );
        echo file_get_contents($this->root->url() . '/php/assets/all.env');
    }

    public function testWriteNonDefaultValues()
    {
        $vars = $this->getExpectedIniVars();
        $this->_parser->setConfigDir($this->root->url() . '/php/assets', 'assets', false);
        $this->_parser->writeNonEmptyDefaultValues($vars);

        $this->assertEquals(
            $this->expectedFileContents('all.nonempty.env'),
            file_get_contents($this->root->url() . '/php/assets/all.nonempty.env')
        );
        echo file_get_contents($this->root->url() . '/php/assets/all.nonempty.env');
    }

    public function getExpectedIniVars()
    {
        return [
            'allow_url_fopen' => [
                'group' => '',
                'envName' => 'PHP_ALLOW_URL_FOPEN',
                'envValue' => '1',
                'envString' => 'ENV PHP_ALLOW_URL_FOPEN=1',
                'iniEnvString' => 'allow_url_fopen=${PHP_ALLOW_URL_FOPEN}'
            ],
            'max_execution_time' => [
                'group' => '',
                'envName' => 'PHP_MAX_EXECUTION_TIME',
                'envValue' => '0',
                'envString' => 'ENV PHP_MAX_EXECUTION_TIME=0',
                'iniEnvString' => 'max_execution_time=${PHP_MAX_EXECUTION_TIME}'
            ],
            'opcache.blacklist_filename' => [
                'group' => 'opcache',
                'envName' => 'PHP_OPCACHE_BLACKLIST_FILENAME',
                'envValue' => '',
                'envString' => 'ENV PHP_OPCACHE_BLACKLIST_FILENAME=1',
                'iniEnvString' => 'opcache.blacklist_filename=${PHP_OPCACHE_BLACKLIST_FILENAME}'
            ],
            'opcache.enable_file_override' => [
                'group' => 'opcache',
                'envName' => 'PHP_OPCACHE_ENABLE_FILE_OVERRIDE',
                'envValue' => '0',
                'envString' => 'ENV PHP_OPCACHE_ENABLE_FILE_OVERRIDE=0',
                'iniEnvString' => 'opcache.enable_file_override=${PHP_OPCACHE_ENABLE_FILE_OVERRIDE}'
            ],
            'opcache.enable' => [
                'group' => 'opcache',
                'envName' => 'PHP_OPCACHE_ENABLE',
                'envValue' => '1',
                'envString' => 'ENV PHP_OPCACHE_ENABLE=1',
                'iniEnvString' => 'opcache.enable=${PHP_OPCACHE_ENABLE}'
            ],
            'assert.exception' => [
                'group' => 'assert',
                'envName' => 'PHP_ASSERT_EXCEPTION',
                'envValue' => '1',
                'envString' => 'ENV PHP_ASSERT_EXCEPTION=1',
                'iniEnvString' => 'assert.exception=${PHP_ASSERT_EXCEPTION}'
            ],
            'mbstring.http_output_conv_mimetypes' => [
                'group' => 'mbstring',
                'envName' => 'PHP_MBSTRING_HTTP_OUTPUT_CONV_MIMETYPES',
                'envValue' => '^(text/|application/xhtml\+xml)',
                'envString' => 'ENV PHP_MBSTRING_HTTP_OUTPUT_CONV_MIMETYPES=^(text/|application/xhtml\+xml)',
                'iniEnvString' => 'mbstring.http_output_conv_mimetypes=${PHP_MBSTRING_HTTP_OUTPUT_CONV_MIMETYPES}'
            ],
            'session.cookie_samesite' => [
                'group' => '',
                'envName' => 'PHP_SESSION_COOKIE_SAMESITE',
                'envValue' => '',
                'envString' => 'ENV PHP_SESSION_COOKIE_SAMESITE=',
                'iniEnvString' => 'session.cookie_samesite=${PHP_SESSION_COOKIE_SAMESITE}'
            ],
            'sendmail_path' => [
                'group' => '',
                'envName' => 'PHP_SENDMAIL_PATH',
                'envValue' => '/usr/sbin/sendmail -t -i',
                'envString' => 'ENV PHP_SENDMAIL_PATH="/usr/sbin/sendmail -t -i"',
                'iniEnvString' => 'sendmail_path=${PHP_SENDMAIL_PATH}'
            ],
            'cli.prompt' => [
                'group' => 'cli',
                'envName' => 'PHP_CLI_PROMPT',
                'envValue' => '\b \> ',
                'envString' => 'ENV PHP_CLI_PROMPT="\b \> "',
                'iniEnvString' => 'cli.prompt=${PHP_CLI_PROMPT}'
            ],
        ];
    }

    public function expectedFileContents($file)
    {
        $content = [
            'assert.ini' => [
                '; Defaults for assert',
                'assert.exception=${PHP_ASSERT_EXCEPTION}'
            ],
            'opcache.ini' => [
                '; Defaults for opcache',
                'opcache.blacklist_filename=${PHP_OPCACHE_BLACKLIST_FILENAME}',
                'opcache.enable_file_override=${PHP_OPCACHE_ENABLE_FILE_OVERRIDE}',
                'opcache.enable=${PHP_OPCACHE_ENABLE}',
            ],
            'php.ini' => [
                '; Defaults for php',
                'allow_url_fopen=${PHP_ALLOW_URL_FOPEN}',
                'max_execution_time=${PHP_MAX_EXECUTION_TIME}',
                'session.cookie_samesite=${PHP_SESSION_COOKIE_SAMESITE}',
                'sendmail_path=${PHP_SENDMAIL_PATH}',
            ],
            'mbstring.ini' => [
                '; Defaults for mbstring',
                'mbstring.http_output_conv_mimetypes=${PHP_MBSTRING_HTTP_OUTPUT_CONV_MIMETYPES}'
            ],
            'cli.ini' => [
                '; Defaults for cli',
                'cli.prompt=${PHP_CLI_PROMPT}',
            ],

            'all.env' => [
                '# Defaults for php',
                'ENV PHP_ALLOW_URL_FOPEN=1',
                'ENV PHP_MAX_EXECUTION_TIME=0',
                'ENV PHP_SESSION_COOKIE_SAMESITE=',
                'ENV PHP_SENDMAIL_PATH="/usr/sbin/sendmail -t -i"',
                '# Defaults for assert',
                'ENV PHP_ASSERT_EXCEPTION=1',
                '# Defaults for mbstring',
                'ENV PHP_MBSTRING_HTTP_OUTPUT_CONV_MIMETYPES=^(text/|application/xhtml\+xml)',
                '# Defaults for cli',
                'ENV PHP_CLI_PROMPT="\b \> "',
            ],

            'all.nonempty.env' => [
                '# Defaults for php',
                'ENV PHP_ALLOW_URL_FOPEN=1',
                'ENV PHP_MAX_EXECUTION_TIME=0',
                'ENV PHP_SENDMAIL_PATH="/usr/sbin/sendmail -t -i"',
                '# Defaults for assert',
                'ENV PHP_ASSERT_EXCEPTION=1',
                '# Defaults for mbstring',
                'ENV PHP_MBSTRING_HTTP_OUTPUT_CONV_MIMETYPES=^(text/|application/xhtml\+xml)',
                '# Defaults for cli',
                'ENV PHP_CLI_PROMPT="\b \> "',
            ]
        ];

        if(!isset($content[$file])) {
            throw new \Exception("No expected file content defined in $file");
        }

        return implode(PHP_EOL, $content[$file]);
    }
}
