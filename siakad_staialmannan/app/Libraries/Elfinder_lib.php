<?php
namespace App\Libraries;

use elFinderConnector;
use elFinder;
use elFinderVolumeDriver;
use elFinderVolumeLocalFileSystem;

class Elfinder_lib 
{
  public function run($opts) {
        $connector = new elFinderConnector(new elFinder($opts));
        return $connector->run();
    }
} 