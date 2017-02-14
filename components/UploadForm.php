<?php
/**
 * @author Maxim Cherednyk <maks757q@gmail.com, +380639960375>
 */

namespace maks757\egallery\components;

use maks757\imagable\Imagable;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, svg', 'maxFiles' => 0],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $path = [];
            foreach ($this->imageFiles as $file) {
                /**@var Imagable $imagine */
                $imagine = \Yii::$app->gallery;
                $path = $imagine->create('gallery', $file);
            }
            return $path;
        } else {
            return false;
        }
    }
}