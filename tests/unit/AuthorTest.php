<?php

namespace tests\unit\models;

use app\models\Author;
use Codeception\Test\Unit;

class AuthorTest extends Unit
{
    public function testFindUserById()
    {
        expect_that($author = Author::findOne(1));
        expect($author->name)->equals('Garry');
    }
}
