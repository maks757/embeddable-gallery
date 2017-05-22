# embeddable-gallery
Embeddable gallery, to be attached to any model

### backend config 
```php
'modules' => [
    'egallery' => [
        'class' => \maks757\egallery\GalleryModule::className()
    ],
    //...
],
```

### common config 
```php
'components' => [
        'egallery' => [
            'class' => \maks757\imagable\Imagable::className(),
            'imageClass' => CreateImageMetaMulti::className(),
            'nameClass' => GenerateName::className(),
            'imagesPath' => '@frontend/web/images',
            'categories' => [
                'category' => [
                    'egallery' => [
                        'size' => [
                            'origin' => [
                                'width' => 0,
                                'height' => 0,
                            ]
                        ]
                    ]
                ]
            ]
        ],
        //...
    ],
```

### views
```php
<?php if(!empty($model->id)): ?>
    <?= $form->field(new \maks757\egallery\components\UploadForm(), 'imageFiles[]')->widget(FileInput::className(), [
        'options' => [
            'multiple' => true,
            'accept' => 'image/*'
        ],
        'pluginOptions' => [
            'showRemove' => false,
            'previewFileType' => 'image',
            'maxFileCount' => 20,
            'uploadUrl' => Url::toRoute(['/egallery/image/upload']),
            'uploadExtraData' => [
                'id' => $model->id,
                'key' => $model->className()
            ],
        ],
        'pluginEvents' => [
            'fileuploaded' => 'function() { $.pjax.reload({container:"#pjax_block", timeout: 100000, url: "'.Url::to('', true).'"}); }'
        ]
    ])->label('Загрузка изображений') ?>
    <?php Pjax::begin(['enablePushState' => false, 'id' => 'pjax_block']) ?>
    <?= \maks757\egallery\widgets\show_images\Gallery::widget(['object' => $model, 'show_name' => false]) ?>
    <?php Pjax::end() ?>
<?php endif; ?>
```

![Alt text](/image/author.jpg "Optional title")

[VK](https://vk.com/maverick757)<br>
[Google](https://plus.google.com/u/1/115560753977134232792)<br>
[GitHub](https://github.com/maks757)
