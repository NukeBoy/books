<?php

use app\models\Author;
use app\models\Book;
use Codeception\Util\HttpCode;
use Faker\Factory;

class BookCest
{
    public function getAllBooks(ApiTester $I)
    {
        $I->sendGet('/books');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"array"}');
        $validResponseJsonSchema = json_encode([
            'properties' => [
                '_id'             => ['type' => 'string'],
                'title'           => ['type' => 'string'],
                'year_of_publish' => ['type' => 'integer'],
                'author_id'       => ['type' => 'string'],
                'description'     => ['type' => 'string'],
                'date_created'    => ['type' => 'string'],
                'date_updated'    => ['type' => 'string'],
            ]
        ], JSON_THROW_ON_ERROR);
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    public function createNewBook(ApiTester $I)
    {
        $faker = Factory::create();
        $I->sendPost(
            '/books',
            [
                'title'           => $faker->title,
                'year_of_publish' => $faker->year,
                'author_id'       => $this->getAuthorEntityID(),
                'description'     => $faker->text
            ]
        );
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                '_id'             => 'string',
                'title'           => 'string',
                'year_of_publish' => 'string',
                'author_id'       => 'string',
                'description'     => 'string',
                'date_created'    => 'string',
                'date_updated'    => 'string',
            ]
        );
    }

    private function getAuthorEntityID()
    {
        return (string)Author::find()->one()->_id;
    }

    public function getBook(ApiTester $I)
    {
        $book = $this->getBookEntity();
        $I->sendGet('/books/' . $book->_id);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"object"}');
        $validResponseJsonSchema = json_encode([
            'properties' => [
                '_id'             => ['type' => 'string'],
                'title'           => ['type' => 'string'],
                'year_of_publish' => ['type' => 'string'],
                'author_id'       => ['type' => 'string'],
                'description'     => ['type' => 'string'],
                'date_created'    => ['type' => 'string'],
                'date_updated'    => ['type' => 'string'],
            ]
        ], JSON_THROW_ON_ERROR);
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    private function getBookEntity()
    {
        return Book::find()->one();
    }

    public function updateBook(ApiTester $I)
    {
        $book = $this->getBookEntity();
        $faker = Factory::create();
        $newTitle = $faker->title;
        $newYear = $faker->year;
        $I->sendPut(
            '/books/' . $book->_id,
            [
                'title'           => $newTitle,
                'year_of_publish' => $newYear,
                'author_id'       => $this->getAuthorEntityID(),
            ]
        );
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'title'           => $newTitle,
            'year_of_publish' => $newYear,
            'author_id'       => $this->getAuthorEntityID(),
        ]);
    }

    public function deleteBook(ApiTester $I)
    {
        $book = $this->getBookEntity();
        $I->sendDelete('/books/' . $book->_id);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
        $I->sendGet('/books/' . $book->_id);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
    }
}
