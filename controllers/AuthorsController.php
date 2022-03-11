<?php

namespace app\controllers;

use app\components\CustomActiveController;
use app\models\Author;
use app\models\Book;

class AuthorsController extends CustomActiveController
{
    public $modelClass = Author::class;

    public function actionStatistic()
    {
        $authors = Author::find()->orderBy(['name' => SORT_ASC, 'surname' => SORT_ASC])->all();
        /** @var Author $author */
        foreach ($authors as $author) {
            yield [
                'name'       => $author->name,
                'surname'    => $author->surname,
                'book_count' => Book::find()->where(['author_id' => (string)$author->_id])->count()
            ];
        }
    }
}
