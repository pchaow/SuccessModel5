<?php
namespace App\Services;

use League\Glide\Server;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: chaow.po
 * Date: 1/14/2016
 * Time: 8:45 PM
 */
class ProjectService
{

    public static function getCover(Server $server, Request $request, $id, $file)
    {
        //$project = Project::find($id);
        $cover_file = $file;

        $path = "project/$id/cover/$cover_file";

        return $server->getImageResponse($path, $_GET);
    }

    public static function getPhoto(Server $server, Request $request, $id, $file)
    {
        $photo_file = $file;
        $path = "project/$id/photo/$photo_file";
        return $server->getImageResponse($path, $_GET);
    }

}