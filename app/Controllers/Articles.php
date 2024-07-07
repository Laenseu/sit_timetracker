<?php

namespace App\Controllers;

use App\Models\ArticleModel;

class Articles extends BaseController
{
    public function index(): string
    {
    //check if the database is connected
        // $db = db_connect();
        // $db->listTables();
    //====================
        $model = new ArticleModel;

        $data = $model->findAll();



        return view("Articles/index", [
            "articles" => $data
        ]);
    }
}
