<?php

namespace App\Twig;

use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use Symfony\Component\Asset\Packages;

class RevManifestExtension extends \Twig_Extension
{
    private $env;
    private $baseRoot;
    private $asset;

    public function __construct($env, $baseRoot, Packages $asset) {
        $this->asset = $asset;
        $this->env = $env;
        $this->baseRoot = $baseRoot;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('assets_versionning', [ $this, 'assetsVersionningFunction' ]),
            new \Twig_SimpleFunction('assets_versionning_amp', [ $this, 'assetsVersionningAmpFunction' ]),
        );
    }

    public function assetsVersionningFunction($pathOrigin)
    {
        static $jsonData;
        if (!isset($jsonData)) {
            try {
                $jsonData = @json_decode(file_get_contents($this->baseRoot.'/rev-manifest.json'), true);
            }
            catch (\Exception $e) {
            }
        }

        if($pathOrigin === 'app.css' && @array_key_exists('app.css', $jsonData)){
            return $this->asset->getUrl('/assets/css/'.$jsonData['app.css']);
        }
        if(@array_key_exists($pathOrigin, $jsonData)) {
            $path = explode('/',$jsonData[$pathOrigin]);
            unset($path[0]);
            $path = implode('/',$path);
            return $this->asset->getUrl('/'.$path);
        }

        /*
        $pathinfo = pathinfo($pathOrigin);
        var_dump()

        switch ($pathOrigin) {
            case '/assets/css/app.css':
                if ($pathinfo['extension'] === 'css' && array_key_exists("app.css", $jsonData) && !is_dir($this->baseRoot.'/'.$jsonData["app.css"]) && is_readable($this->baseRoot.'/'.$jsonData["app.css"])) {

                    $array = explode("/", $jsonData["app.css"]);
                    $path = $array[0];
                    return "/assets/css/" . $path;
                }
                break ;
            case 'web/assets/js/app.js':


                echo 'ici';
                var_dump($pathOrigin);
                exit();
                if ($pathinfo['extension'] === 'js' && array_key_exists("app.js", $jsonData) && !is_dir($this->baseRoot.'/'.$jsonData["app.js"]) && is_readable($this->baseRoot.'/'.$jsonData["web/assets/js/app.js"])) {
                    $array = explode("/", $jsonData["app.js"]);
                    unset($array[0]);
                    $path = implode("/", $array);

                    return $path;
                }
                break;
        }

        return $pathOrigin;*/
    }

    public function assetsVersionningAmpFunction($pathOrigin)
    {
        static $jsonData;
        if (!isset($jsonData)) {
            try {
                $jsonData = @json_decode(file_get_contents($this->baseRoot.'/rev-manifest-amp.json'), true);
            }
            catch (\Exception $e) {
            }
        }

        if($pathOrigin === 'app-amp.css' && @array_key_exists('app-amp.css', $jsonData)){
            $tmp = (file_get_contents($this->baseRoot.'/public/assets/css/'.$jsonData['app-amp.css']));
            return ($tmp);
        }
        if(@array_key_exists($pathOrigin, $jsonData)) {
            $path = explode('/',$jsonData[$pathOrigin]);
            unset($path[0]);
            $path = implode('/',$path);
            $tmp = (file_get_contents($this->baseRoot.'/public/'.$path));
            return ($tmp);
        }
    }

    public function getName()
    {
        return 'assets_versionning_extension';
    }

    /*public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('rev_manifest', array($this, 'revManifest')),
        );
    }

    public function revManifest(string $assetPath) {
        $filePath = explode("/", $assetPath);
        $fileName = $filePath[count($filePath) - 1];
        static $manifest;

        if (!isset($manifest)) {
            try {
                $manifest = json_decode(file_get_contents(__DIR__. "/../../../../rev-manifest.json", true));
            }
            catch (\Exception $e) {
            }
        }
        if (array_key_exists($fileName, $manifest))
            return $manifest[$fileName];
        return $fileName;
    }*/

}