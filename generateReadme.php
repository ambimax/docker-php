<?php

namespace Ambimax;

use MaddHatter\MarkdownTable\Builder;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class generateReadme
{
    private $twig;

    private $modules = '';

    private $distros = [
        'buster' => 'Debian Buster',
        'alpine3.13' => 'Alpine 3.13',
    ];

    private $phpVersions = ['7.3', '7.4', '8.0'];

    private $extensions = [];

    /**
     * All available extensions on any php version
     *
     * @var array
     */
    private $availableExtensions = [];

    public function __construct()
    {
        $loader = new FilesystemLoader('template');
        $this->twig = new Environment($loader);

        $this->_setExtensions();
    }

    protected function _setExtensions()
    {
        foreach($this->phpVersions as $phpVersion) {
            $this->extensions[$phpVersion] = $this->getModules($phpVersion);
            sort($this->extensions[$phpVersion]);
        }

        foreach($this->extensions as $phpVersion => $extensions) {
            foreach($extensions as $name) {
                if(!in_array($name, $this->availableExtensions)) {
                    $this->availableExtensions[] = $name;
                }
            }
        }

        sort($this->availableExtensions);
    }

    public function getPhpAssetFileContent($filename, $phpVersion)
    {
        $filename = sprintf('template/components/php/%s/assets/%s', $phpVersion, $filename);
        return $this->getFileContents($filename);
    }

    public function getFileContents($path)
    {
        if(!file_exists($path)) {
            throw new \Exception("File $path is not readable");
        }
        return file($path);
    }

    public function getModules($phpVersion)
    {
        $modules = [];
        foreach($this->getPhpAssetFileContent('modules.list', $phpVersion) as $line) {
            if(preg_match('/^[a-zA-Z]+/', $line)){
                $modules[] = trim($line);
            }
        }

        return array_unique($modules);
    }

    public function getPhpModulesMatrix()
    {
        // create instance of the table builder
        $tableBuilder = new Builder();

        $tableBuilder
            ->headers(['PHP Module', ...$this->phpVersions])
            ->align(['L']);

        foreach ($this->availableExtensions as $module) {
            $row = [$module];

            foreach ($this->phpVersions as $phpVersion) {
                $row[] = in_array($module, $this->extensions[$phpVersion]) ? ' ✓ ' : ' ';
            }

            $tableBuilder->row($row);
        }

        return $tableBuilder->render();
    }

    public function getDockerHubMatrix()
    {
        $markdown = [];
        foreach($this->distros as $distro => $name) {
            $markdown[] = sprintf('### %s', $name);

            // create instance of the table builder
            $tableBuilder = new Builder();

            $tableBuilder
                ->headers(['PHP Version', 'Image'])
                ->align(['L']);

            foreach($this->phpVersions as $phpVersion) {
                $name = sprintf('ambimax/php-%s-%s', $phpVersion, $distro);
                $url = sprintf('https://hub.docker.com/r/ambimax/php-%s-%s', $phpVersion, $distro);
                $link = sprintf('[%s](%s)', $name, $url);
                $tableBuilder->row([$phpVersion, $link]);
            }

            $markdown[] = $tableBuilder->render();
        }

        return implode(PHP_EOL, $markdown);
    }

    public function getEnvironmentVariablesMatrix()
    {
        // create instance of the table builder
        $tableBuilder = new Builder();

        $tableBuilder
            ->headers(['PHP Version', 'Link'])
            ->align(['L']);

        foreach($this->phpVersions as $phpVersion) {
            $url = sprintf('template/components/php/%s/assets/all.env', $phpVersion);
            $row = [
                $phpVersion,
                sprintf('[%s](%s)', $url, $url),
            ];
            $tableBuilder->row($row);
        }

        return $tableBuilder->render();
    }

    public function renderTemplate()
    {
        return $this->twig->render('README.md.twig', [
            'php_modules' => $this->getPhpModulesMatrix(),
            'docker_hub_matrix' => $this->getDockerHubMatrix(),
            'environment_variables_matrix' => $this->getEnvironmentVariablesMatrix(),
        ]);
    }

    public function render()
    {
        file_put_contents('README.md', $this->renderTemplate());
    }
}


if(isset($argc) && $argc) {
    require_once 'vendor/autoload.php';
    $generator = new generateReadme();
    $generator->render();
}
