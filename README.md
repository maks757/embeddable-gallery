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
![Alt text](/image/author.jpg "Optional title")

[VK](https://vk.com/maverick757)<br>
[Google](https://plus.google.com/u/1/115560753977134232792)<br>
[GitHub](https://github.com/maks757)
