<?php
/**
 * @author Maxim Cherednyk <maks757q@gmail.com, +380639960375>
 */

namespace maks757\egallery\controllers;


use maks757\egallery\components\UploadForm;
use maks757\egallery\entities\Gallery;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class ImageController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index', []);
    }

    public function actionUpload(){
        $request = \Yii::$app->request;
        if($request->isPost){
            Url::remember(\Yii::$app->request->referrer);
            $model = new UploadForm();
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($path = $model->upload()) {
                $gallery = new Gallery();
                $gallery->key = md5($request->post('key'));
                $gallery->object_id = $request->post('id');
                $position = Gallery::find()->where(['key' => $gallery->key, 'object_id' => $gallery->object_id])->orderBy(['position' => SORT_DESC])->one()->position;
                $gallery->position = empty($position) ? 1 : $position + 1;
                $gallery->image = $path;
                $gallery->save();
                return true;
            }
        }
    }

    public function actionUploadImage(){
        $request = \Yii::$app->request;
        if($request->isPost){
            $id = $request->post('Gallery')['id'];
            $gallery = Gallery::findOne($id);
            $gallery->load($request->post());
            $gallery->save();
        }
        return $this->render(\Yii::$app->request->referrer);
    }

    public function actionChangePosition()
    {
        /* @var $images Gallery[] */
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request->post();
        if(!empty($request['position']) || $request['position'] == 0 && !empty($request['id'])) {
            $image = Gallery::findOne($request['id']);
            $images = Gallery::find()->where(['object_id' => $image->object_id, 'key' => $image->key])
                ->orderBy(['position' => SORT_ASC])->all();
            $index = 0;
            foreach ($images as $image_list){
                if($request['position'] == $index)
                    $index++;
                if($image_list->id == $image->id) {
                    $image->position = $request['position'];
                    $image->save();
                } else {
                    $image_list->position = $index;
                    $image_list->save();
                    $index++;
                }
            }
            return true;
        }
        return false;
    }

    public function actionDelete($id, $object_id, $object_class)
    {
        /** @var $object ActiveRecord */
        $object = \Yii::createObject($object_class)->findOne($object_id);
        $gallery = Gallery::findOne($id);
        $gallery->delete();
        return $this->renderPartial('index', [
            'object' => $object
        ]);
    }
}
