<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->registerCssFile('@web/css/plagins/jquery.zbox.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile("@web/js/plagins/jquery.zbox.js",['depends' =>'yii\web\YiiAsset']);
$this->registerJsFile("@web/js/plagins/lightbox.js",['depends' =>'yii\web\YiiAsset']);

$this->title = 'Розміщення інформації в каталозі, порівняння тарифних планів - Каталог Панорама';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Розміщення інформації за тарифним планом «Преміум», розміщення підприємств за тарифом "Стандатр", 
    порівняння тарифних планів,  інші інформаційні послуги. Замовляйте! '
]);
$this->params['breadcrumbs'][] = 'Розміщення інформації в каталозі';
$this->registerCssFile('@web/css/plan.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);
?>
<div class="row">
    <div class="col-md-12">
        <h1>Прайс на розміщення інформації</h1>

        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => 'Головна', 'url' => '/'],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>


        <p>Пропонуємо два тарифні плани для розміщення інформації про ваш заклад: «Преміум» і «Стандарт».</p>
        <h2>Розміщення інформації про компанію за тарифним планом «Преміум»</h2>
        <p>«Преміум» - найкраща пропозиція Каталогу. Пакет передбачає створення досконалої сторінки замовника з
            детальним
            описом товарів та послуг, зображення на карті, можливістю додавати прайси на продукцію.
            У зацікавлених відвідувачів сторінки є можливість написати листа компанії або замовити дзвінок.
            Також клієнти цього тарифного плану виділяються в загальному переліку підприємств.</p>
        <p>Результат - створення повноцінного профілю. Преміум може бути прекрасною альтернативою для фірм,
            які поки що не мають власного сайту.</p>
        <p><strong><i>Вартість розміщення інформації –700 грн/рік (Акційна ціна діє до грудня 2018 р.)</i></strong></p>
        <p>Переглянути приклад розміщення «Преміум»</p>
        <h2>Розміщення підприємств за тарифним планом «Стандарт»</h2>
        <p>«Стандарт» – це розміщення інформації про підприємство із мінімальними витратами.</p>
        <p>Пакет передбачає наповнення сторінки замовника такою інформацією: опис діяльності, логотип, контакти та
            посилання на сайт.</p>
        <p>Результат - розширення мережі покупців та бізнес-партнерів, додаткова реклама в інтернеті.</p>
        <p><strong><i>Вартість – 400 грн/рік (Акційна ціна діє до грудня 2018 р.)</i></strong></p>
        <p>Переглянути приклад розміщення підприємства «Стандарт»</p>
        <p>Порівняльна характеристика тарифних планів</p>

        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th>Тарифний план</th>
                <th>Стандарт</th>
                <th>Преміум</th>
            </tr>
            <tr>
                <td colspan="4" align="center"><b><i>Критерії порівняння</i></b></td>
            </tr>
            <tr>
                <td>1</td>
                <td>Логотип</td>
                <td>Так</td>
                <td>Так</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Опис діяльності</td>
                <td>До 500 символів б/п (~60 слів)</td>
                <td>До 1000 символів б/п (~120 слів)</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Контактна інформація: телефон, емейл, адреса</td>
                <td>Так</td>
                <td>Так</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Посилання на сайт</td>
                <td>Так</td>
                <td>Так</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Додаткова інформація</td>
                <td>Ні</td>
                <td>3 файли (Microsoft Excel, Microsoft Word, PDF, JPEG, GIF, PNG (розмір зображення 250x141 px, вага
                    1.5 Mb)
                </td>
            </tr>
            <tr>
                <td>6</td>
                <td>Зображення на карті</td>
                <td>Ні</td>
                <td>Так</td>
            </tr>
            <tr>
                <td>7</td>
                <td>Додаткові функції</td>
                <td>Ні</td>
                <td>Написати листа, замовити дзвінок, поділитися в соц. мережах</td>
            </tr>
            <tr>
                <td>8</td>
                <td>Виділення в загальному списку</td>
                <td>Ні</td>
                <td>Так</td>
            </tr>
            <tr>
                <td>9</td>
                <td>Вартість</td>
                <td>400,00 грн/рік</td>
                <td>700,00 грн/рік</td>
            </tr>
        </table>

        <h2>Інші інформаційні послуги</h2>
        <p><b>Розміщення банера на головній сторінці</b></p>
        <p>Розмір: 250 x 141 px</p>
        <p>Формат: JPEG, GIF</p>
        <p><strong><i>Вартість: 500,00 грн – 6 міс., 1000,00 грн – 1 рік</i></strong></p>
        <p><strong>Розміщення публікації в рубриці «Новини»</strong></p>
        <p>Стаття рекламно-інформаційного характеру з авторством замовника та посиланням на сайт</p>
        <p>Вимоги (виконує адміністрація сайту):</p>
        <p>Рівень унікальності - від 85%</p>
        <p>Обов’язкова СЕО оптимізація тексу, фото/відео</p>
        <p>Термін – публікація залишається на сайті завжди</p>
        <p><strong><i>Вартість: 3000 символів – 300,00 грн.</i></strong></p>
        <p><strong><i>Написання статті, оптимізація тексту – додаткова вартість в залежності від складності
                    матеріалу від 35,00грн за 1000 символів.</i></strong></p>
        <p><strong>Дозвольте вашим потенційним клієнтам та партнерам швидше знайти вас. Замовляйте розміщення інформації
                про ваш бізнес
                в Каталозі Панорама!</strong></p>
        <p><a href="/add">Додати компанію</a> або <a href="/contact">Зверніться до нас</a> за додатковою інформацією.
        </p>


    </div>
</div>