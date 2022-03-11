<?php

namespace tests\unit\fixtures;

use app\models\Author;
use app\models\Book;
use Faker\Factory;
use yii\mongodb\ActiveFixture;

class BookFixture extends ActiveFixture
{
    public $modelClass = Book::class;
    public $collectionName = 'book';
    public $depends = [
        AuthorFixture::class
    ];

    protected function getData()
    {
        $faker = Factory::create();
        $data = [];

        $authors = array_map(static fn($author) => (string)$author['_id'], Author::find()->all());

        for ($i = 1; $i <= 100; $i++) {
            $data[] = [
                'id'              => $i,
                'title'           => $faker->title(),
                'year_of_publish' => $faker->year(),
                'description'     => $faker->text(),
                'date_created'    => $faker->dateTime()->format('Y.m.d H:i:s'),
                'date_updated'    => $faker->dateTime()->format('Y.m.d H:i:s'),
                'author_id'       => $faker->randomElement($authors)
            ];
        }

        return $data;
    }
}
