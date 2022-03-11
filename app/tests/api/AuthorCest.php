<?php

use app\models\Author;
use app\models\Book;
use Codeception\Util\HttpCode;
use Faker\Factory;

class AuthorCest
{
    public function getAllAuthors(ApiTester $I)
    {
        $I->sendGet('/authors');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"array"}');
        $validResponseJsonSchema = json_encode([
            'properties' => [
                '_id'          => ['type' => 'string'],
                'name'         => ['type' => 'string'],
                'surname'      => ['type' => 'string'],
                'biography'    => ['type' => 'string'],
                'date_birth'   => ['type' => 'string'],
                'date_created' => ['type' => 'string'],
                'date_updated' => ['type' => 'string'],
            ]
        ], JSON_THROW_ON_ERROR);
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    public function createNewAuthor(ApiTester $I)
    {
        $faker = Factory::create();
        $I->sendPost(
            '/authors',
            [
                'name'       => $faker->firstName,
                'surname'    => $faker->lastName,
                'biography'  => $faker->text,
                'date_birth' => $faker->date('Y.m.d H:i:s')
            ]
        );
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                '_id'          => 'string',
                'name'         => 'string',
                'surname'      => 'string',
                'biography'    => 'string',
                'date_birth'   => 'string',
                'date_created' => 'string',
                'date_updated' => 'string',
            ]
        );
    }

    public function getAuthor(ApiTester $I)
    {
        $author = $this->getAuthorEntity();
        $I->sendGet('/authors/' . $author->_id);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"object"}');
        $validResponseJsonSchema = json_encode([
            'properties' => [
                '_id'          => ['type' => 'string'],
                'name'         => ['type' => 'string'],
                'surname'      => ['type' => 'string'],
                'biography'    => ['type' => 'string'],
                'date_birth'   => ['type' => 'string'],
                'date_created' => ['type' => 'string'],
                'date_updated' => ['type' => 'string'],
            ]
        ], JSON_THROW_ON_ERROR);
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    private function getAuthorEntity()
    {
        return Author::find()->one();
    }

    public function updateAuthor(ApiTester $I)
    {
        $author = $this->getAuthorEntity();
        $faker = Factory::create();
        $newName = $faker->name;
        $newSurname = $faker->lastName;
        $newDate = $faker->date('Y.m.d H:i:s');
        $I->sendPut(
            '/authors/' . $author->_id,
            [
                'name'       => $newName,
                'surname'    => $newSurname,
                'date_birth' => $newDate,
            ]
        );
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'name'       => $newName,
            'surname'    => $newSurname,
            'date_birth' => $newDate,
        ]);
    }

    public function deleteAuthor(ApiTester $I)
    {
        $author = $this->getAuthorEntity();
        $I->sendDelete('/authors/' . $author->_id);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
        $I->sendGet('/authors/' . $author->_id);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->assertIsEmpty(Book::findAll(['author_id' => (string)$author->_id]));
    }

    public function getAllAuthorsStatistic(ApiTester $I)
    {
        $I->sendGet('/authors/statistic');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"array"}');
        $validResponseJsonSchema = json_encode([
            'name'       => 'string',
            'surname'    => 'string',
            'book_count' => 'int'
        ], JSON_THROW_ON_ERROR);
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }
}
