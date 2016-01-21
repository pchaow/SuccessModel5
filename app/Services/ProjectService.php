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

        return $server->outputImage($path, $_GET);
    }

}