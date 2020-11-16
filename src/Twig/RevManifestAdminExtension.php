<?php

namespace App\Twig;


use Symfony\Component\Asset\Packages;

class RevManifestAdminExtension extends \Twig_Extension
{
    private $asset;

    public function __construct(Packages $asset) {
        $this->asset = $asset;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('assets_versionning_admin', [ $this, 'assetsVersionningAdminFunction' ]),
        );
    }

    public function assetsVersionningAdminFunction($pathOrigin)
    {
        static $jsonData;
        if (!isset($jsonData)) {
            try {
                $jsonData = @json_decode(file_get_contents('./../rev-manifest-admin.json'), true);
            }
            catch (\Exception $e) {
            }
        }
        if($pathOrigin === 'app-admin.css' && @array_key_exists('app-admin.css', $jsonData)){
            return $this->asset->getUrl('/assets_admin/css/'.$jsonData['app-admin.css']);
        }
        if(@array_key_exists($pathOrigin, $jsonData)) {
            $path = explode('/',$jsonData[$pathOrigin]);
            unset($path[0]);
            $path = implode('/',$path);
            return $this->asset->getUrl('/'.$path);
        }
    }

    public function getName()
    {
        return 'assets_versionning_admin_extension';
    }

}