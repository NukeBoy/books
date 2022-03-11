<?php

namespace tests\unit\fixtures;

use yii\mongodb\ActiveFixture;
use app\models\Author;

class AuthorFixture extends ActiveFixture
{
    public $modelClass = Author::class;
    public $collectionName = 'author';
}
