<?php

namespace maks757\egallery\entities;

use maks757\imagable\Imagable;
use Yii;
use yii\helpers\BaseFileHelper;

/**
 * This is the model class for table "gallegy".
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $key
 * @property integer $object_id
 * @property integer $position
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image', 'key', 'object_id'], 'required'],
            [['object_id', 'position'], 'integer'],
            [['title', 'image', 'key'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'image' => 'Image',
            'key' => 'Key',
            'object_id' => 'Object ID',
        ];
    }

    /**
     * @param string $category
     * @param string $type
     * @return string
     */
    public function getImage($category = 'gallery', $type = 'origin')
    {
        /**@var Imagable $imagine */
        $imagine = \Yii::$app->gallery;
        $imagePath = $imagine->get($category, $type, $this->image);
        $aliasPath = BaseFileHelper::normalizePath(Yii::getAlias('@frontend/web'));
        $image = str_replace($aliasPath,'',$imagePath);
        return $image;
    }

    public function delete()
    {
        /** @var Imagable $imagine */
        $imagine = \Yii::$app->gallery;
        $imagePath = $imagine->get('gallery', 'origin', $this->image);
        unlink($imagePath);
        return parent::delete();
    }


}
