<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;

/**
 * @property int $_id
 * @property string $name
 * @property string $surname
 * @property string $date_birth
 * @property string $biography
 * @property string $date_created
 * @property string $date_updated
 */
class Author extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'author';
    }

    public function attributes(): array
    {
        return ['_id', 'name', 'surname', 'date_birth', 'biography', 'date_created', 'date_updated', 'books'];
    }

    public function behaviors(): array
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

    public function rules(): array
    {
        return [
            [['name', 'surname', 'date_birth'], 'required'],
            [['name', 'surname', 'biography'], 'string'],
            [['date_birth'], 'date', 'format' => 'php:Y.m.d H:i:s'],
        ];
    }

    public function delete(): bool|int
    {
        Book::deleteAll(['author_id' => (string)$this->_id]);
        return parent::delete();
    }
}
