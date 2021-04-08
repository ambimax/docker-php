<?php

namespace Ambimax;

use PHPUnit\Framework\TestCase;

class generateReadmeTest extends TestCase
{
    private $gen;
    private $defaultPhpVersion = '7.4';

    public function setUp(): void
    {
        $this->gen = new generateReadme();
    }

    public function testRendering()
    {
        $this->assertStringContainsString(
            'Hello World',
            $this->gen->renderTemplate()
        );
    }

    public function testGetModules()
    {
        $phpVersion = $this->defaultPhpVersion;
        print_r($this->gen->getModules($phpVersion));
        $this->assertContains('Zend OPcache', $this->gen->getModules($phpVersion));
        $this->assertContains('bcmath', $this->gen->getModules($phpVersion));
        $this->assertNotContains('', $this->gen->getModules($phpVersion));
        $this->assertNotContains('[Zend Modules]', $this->gen->getModules($phpVersion));
    }

    public function testIsTrue()
    {
        $this->assertTrue(true);
    }

    public function testBuildMatrixTable()
    {
        $matrix = [
            '7.3' => ['rot' => '1', 'blau' => '1'],
            '7.4' => ['gelb' => '1', 'blau' => '1'],
            '8.0' => ['grün' => '1'],
        ];

        $result = $this->gen->buildMatrixTable($matrix);

        $this->assertSame('| PHP Module | 7.3 | 7.4 | 8.0 |
|------------|-----|-----|-----|
| blau       | ✓ | ✓ |     |
| gelb       |     | ✓ |     |
| grün      |     |     | ✓ |
| rot        | ✓ |     |     |
',
            $result
        );


    }
}

