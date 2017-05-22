<?php
/**
 * @author Maxim Cherednyk <maks757q@gmail.com, +380639960375>
 */

use yii\helpers\Url;
use yii\jui\Sortable;
use yii\widgets\Pjax;

/**
 * @var $this \yii\web\View
 * @var $url string
 * @var $images \maks757\egallery\entities\Gallery[]
 */
$index = 0;
$url_drop_down = \yii\helpers\Url::toRoute(['/egallery/image/change-position'], true);
$css = <<<css
.sortable-placeholder{
    min-width: 208px !important;
}
css;
$this->registerCss($css);
?>
<?php Pjax::begin(['enablePushState' => false, 'id' => 'pjax_block']) ?>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
                <h4 class="panel-title">
                    <a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"
                       aria-expanded="false" aria-controls="collapseThree">
                        Картинки
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                <div class="panel-body">
                    <?php
                    $items = [];
                    $index = 1;
                    foreach ($images as $image): ?>
                        <?php
                        $form = \yii\widgets\ActiveForm::begin(['action' => $url, 'options' => ['data-pjax' => true]]);
                        $html = \yii\helpers\Html::beginForm($url, 'post', ['data-pjax' => true]);

                        $html .= \yii\helpers\Html::a(
                            '',
                            Url::toRoute(['/egallery/image/delete', 'id' => $image->id, 'object_id' => $object->id, 'object_class' => $object->className()]),
                            ['class' => 'glyphicon glyphicon-remove-circle']
                        );
                        $html .= '<br>';

                        if ($show_name) {
                            $html .= \yii\helpers\Html::label('Название', 'imageForm' . $index).'<br>';
                            $html .= \yii\helpers\Html::activeTextInput($image, 'title', ['id' => 'imageForm' . $index, 'class' => 'form-control']);
                        }

                        $html .= \yii\helpers\Html::activeHiddenInput($image, 'id');
                        $html .= \yii\helpers\Html::endForm();
                        $html .= \yii\helpers\Html::label('Изображение', 'image').'<br>';
                        $html .= \yii\helpers\Html::img($image->getImage(), ['width' => '200', 'id' => 'image']);
                        yii\widgets\ActiveForm::end();
                        $js = <<<js
                                $( "#imageForm$index" ).blur(function() {
                                    $("#imageForm$index").closest("form").submit();
                                });
js;

                        $items[] = [
                            'content' => $html,
                            'options' => ['data-id' => $image->id, 'width' => '200']

                        ];

                        $this->registerJs($js);
                        $index++;
                        ?>
                    <?php endforeach; ?>

                    <?= Sortable::widget([
                        'type'=>'grid',
                        'items' => $items,
                        'pluginEvents' => [
                            'sortupdate' => <<<js
                            function(event, ui) {
                                var position = ui.item.index();
                                var id = ui.item.attr('data-id');
                                console.log('id: '+id+'position:'+position); 
                                console.log('$url_drop_down'); 
                                $.ajax({
                                    url: '$url_drop_down',
                                    data: {id: id, position: position},
                                    type: 'POST',
                                    cache: false,
                                    // processData: false,
                                    // contentType: false,
                                    dataType: 'json',
                                    success: function (dataofconfirm) {
                                        console.log(dataofconfirm);
                                    },
                                    error: function (error) {
                                        console.log(error);
                                    }
                                });
                            }
js
                        ],
                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>

<?php Pjax::end() ?>