<?php

namespace Ambimax;

use MaddHatter\MarkdownTable\Builder;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class generateReadme
{
    private $twig;

    private array $phpVersions;
    private array $images;
    private array $distros = [];

    private array $extensions = [];

    private array $debianVersions = [
        'Bullseye' => 11,
    ];

    /**
     * All available extensions on any php version
     */
    private array $availableExtensions = [];

    public function __construct()
    {
        $loader = new FilesystemLoader('template');
        $this->twig = new Environment($loader);

        $this->_parseManifest();
        $this->_setExtensions();
    }

    protected function _parseManifest()
    {
        $json = (array) json_decode(file_get_contents('manifest.json'), true);
        $this->phpVersions = array_keys($json['images']);
        $this->images = $json['images'];

        foreach($this->images as $phpVersion => $distroString) {
            foreach($distroString as $slag) {
                list($k, $distro) = explode(':', $slag);
                if(!array_key_exists($distro, $this->distros)) {
                    $this->distros[$distro] = ucfirst($distro);
                }
            }
        }
        sort($this->distros);
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
                $row[] = in_array($module, $this->extensions[$phpVersion]) ? ' ✓ ' : '';
            }

            $tableBuilder->row($row);
        }

        return $tableBuilder->render();
    }

    public function getDockerHubMatrix()
    {
        $markdown = [];
        foreach($this->images as $phpVersion => $distroString) {

            $markdown[] = sprintf('### PHP %s', $phpVersion);

            // create instance of the table builder
            $tableBuilder = new Builder();

            $tableBuilder
                 ->headers(['Distro', 'Image'])
                 ->align(['L']);

            foreach($distroString as $slag) {
                list($k, $distro) = explode(':', $slag);

                $name = sprintf('ambimax/php-%s-%s', $phpVersion, $distro);
                $url = sprintf('https://hub.docker.com/r/ambimax/php-%s-%s', $phpVersion, $distro);
                $link = sprintf('[%s](%s)', $name, $url);
                $tableBuilder->row([ucfirst($distro), $link]);
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

    public function getEndOfLifeTemplate()
    {
        // create instance of the table builder
        $tableBuilder = new Builder();

        $tableBuilder
            ->headers(['Name', 'End Of Life'])
            ->align(['L']);

        $matrix = [];

        // PHP
        foreach($this->phpVersions as $version) {
            $matrix[] = [
                'product' => 'php',
                'cycle' => $version,
                'label' => sprintf('PHP %s', $version)
            ];
        }

        foreach($this->distros as $name) {
            switch($name) {
                case preg_match('/alpine(.*)/i', $name, $match) ? true : false:
                    $matrix[] = [
                        'product' => 'alpine',
                        'cycle' => $match[1],
                        'label' => sprintf('Alpine %s',$match[1])
                    ];
                    break;
                default:
                    $cycle = $this->debianVersions[$name];
                    $matrix[] = [
                        'product' => 'debian',
                        'cycle' => $cycle,
                        'label' => sprintf('Debian %s', $name),
                    ];
                    break;
            }
        }

        foreach($matrix as $product) {
            $url = sprintf('https://endoflife.date/api/%s/%s.json', $product['product'], $product['cycle']);
            $api = (array) json_decode(file_get_contents($url));
            $row = [
                $product['label'],
                $api['eol']
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
            'endoflife' => $this->getEndOfLifeTemplate()
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
