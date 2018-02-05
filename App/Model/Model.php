<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Core\Http\Request;

class Model extends EloquentModel
{
    public function scopePage($query, $pageSize)
    {
        $page = Request::getInstance()->getRequestParam('page') ? Request::getInstance()->getRequestParam('page') : 1;
        $paginator = $query->paginate($pageSize, ['*'], 'page', $page);
        $paginator->setPath(\Core\Http\Request::getInstance()->getServerParams()['request_uri']);
        return $paginator;
    }
}