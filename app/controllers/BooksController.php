<?php

namespace app\controllers;

use app\components\CustomActiveController;
use app\models\Book;

class BooksController extends CustomActiveController
{
    public $modelClass = Book::class;
}
