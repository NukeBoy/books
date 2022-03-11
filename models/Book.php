<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveQuery;
use yii\mongodb\ActiveRecord;

/**
 * @property int $_id
 * @property string $title
 * @property int $year_of_publish
 * @property string $description
 * @property string $author_id
 * @property string $date_created
 * @property string $date_updated
 * @property Author $author
 */
class Book extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'book';
    }

    public function attributes(): array
    {
        return ['_id', 'title', 'year_of_publish', 'description', 'author_id', 'date_created', 'date_updated'];
    }

    public function rules(): array
    {
        return [
            [['title', 'year_of_publish', 'author_id'], 'required'],
            [['title', 'description', 'author_id'], 'string'],
            [['year_of_publish'], 'integer'],
            [['date_created', 'date_updated'], 'date', 'format' => 'php:Y.m.d H:i:s'],
            [
                ['author_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Author::class,
                'targetAttribute' => ['author_id' => '_id'],
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class'              => TimestampBehavior::class,
                'createdAtAttribute' => 'date_created',
                'updatedAtAttribute' => 'date_updated',
                'value'              => date('Y.m.d H:i:s'),
            ]
        ];
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['author_id' => '_id']);
    }
}
