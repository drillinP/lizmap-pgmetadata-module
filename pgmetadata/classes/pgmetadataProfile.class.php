<?php
/**
* @package   lizmap
* @subpackage pgmetadata
* @author    Pierre DRILLIN
* @copyright 2020 3liz
* @link      https://3liz.com
* @license    Mozilla Public Licence
*/

class pgmetadataProfile {

    /**
    * Get the Name of the pgmetadata DB profile
    * @param project Project key
    * @param repository Repository key
    * @param layerName Name of the Parcelle layer
    * @param profile The default cadastre DB profile
    * @return Name of the cadastre DB profile
    */
    public static function get($repository, $project, $layerName) {
        $profile = 'pgmetadata';
        $p = lizmap::getProject($repository.'~'.$project);
        $layer = $p->findLayerByName($layerName);
        if($layer){
            $layerId = $layer->id;
            $qgisLayer = $p->getLayer($layerId);
            if ($qgisLayer) {
                $profile = $qgisLayer->getDatasourceProfile();
            }
        }
        //jLog::log(json_encode($profile));
        return $profile;
    }

}
