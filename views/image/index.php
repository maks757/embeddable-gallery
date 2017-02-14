<?php
/**
 * @author Maxim Cherednyk <maks757q@gmail.com, +380639960375>
 */
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$js_url = Url::toRoute(['/gallery'], true);
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<?= $form->field(new \maks757\egallery\components\UploadForm(), 'imageFiles[]')->widget(FileInput::className(), [
    'options' => [
        'multiple' => true,
        'accept' => 'image/*'
    ],
    'pluginOptions' => [
        'showRemove' => true,
        'previewFileType' => 'image',
//        'maxFileCount' => 20,
        'uploadUrl' => Url::to(['/gallery/image/upload']),
        'uploadExtraData' => [
            'id' => $object->id,
            'key' => $object->className()
        ],
    ],
    'pluginEvents' => [
        'fileuploaded' => 'function() { $.pjax.reload({container:"#pjax_block", timeout: 10000, url: "'.$js_url.'"}); }'
    ]
])->label('Загрузка изображений') ?>
<?php ActiveForm::end() ?>
<?php Pjax::begin(['enablePushState' => false, 'id' => 'pjax_block']) ?>
<?= \maks757\egallery\widgets\show_images\Gallery::widget(['object' => $object]) ?>
<?php Pjax::end() ?>
