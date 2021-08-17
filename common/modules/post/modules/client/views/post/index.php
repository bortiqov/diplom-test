<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
?>
<div class="container-fluid">
    <div class="kurs-header row p-3 mt-3">
        <div class="col-12 row justify-content-between">
            <div class="col-12 col-lg-6">
                <img class="img-fluid" src="/images/kurs-header-img.svg" alt="kurs-header">
            </div>
            <div class="col-12 col-lg-6 row header-text-part">
                <div class="col-12 col-sm-8">
                    <div class="kurs-header-title"><?=__("вакансии общего питания")?></div>
                    <div class="first-color"><?=__("Есть невероятное множество интересных историй из области кулинарных
                        открытий, исторических фактов.")?>
                    </div>
                </div>
                <div class="col-12 col-sm-4 mt-4 mt-sm-0 d-flex justify-content-center align-items-center">
                    <div class="kurs-header-btn">
                        <a class="primary" href="#"> <?=__("Вакансии")?> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row naw-kurs">
        <div class="col-12 naw-kurs-title">
            <?=__("Наши Post дают вам настоящий профессионализм. Не упустите эту возможность!")?>
        </div>
        <?= \yii\widgets\ListView::widget([
            'options' => [
//                'tag' => false,
                'class' => 'col-12 row shkola-news'
            ],
            'itemOptions' => ['class' => 'col-12 col-sm-6 col-md-4  mb-3 pr-0 pr-sm-3'],
            'itemView' => '_item',
            'summary' => false,
            'dataProvider' => $dataProvider
        ]) ?>
    </div>
</div>
