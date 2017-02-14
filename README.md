# embeddable-gallery
Embeddable gallery, to be attached to any model

### backend config 
```php
'modules' => [
    'gallery' => [
        'class' => \common\modules\gallery\GalleryModule::className()
    ],
    //...
],
```

### common config 
```php
'components' => [
        'gallery' => [
            'class' => \maks757\imagable\Imagable::className(),
            'imageClass' => CreateImageMetaMulti::className(),
            'nameClass' => GenerateName::className(),
            'imagesPath' => '@frontend/web/images',
            'categories' => [
                'category' => [
                    'gallery' => [
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
![Alt text](/image/author.jpg "Optional title")