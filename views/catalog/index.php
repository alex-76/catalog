<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = 'Каталог підприємств України по рубриках і регіонах';
$this->params['breadcrumbs'][] = $this->title;

//$this->registerJsFile("@web/js/main.js",['depends' =>'yii\web\YiiAsset']);
$this->registerCssFile('@web/css/main.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);
?>



<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <img src="/images/1.jpg" alt="" class="img-responsive">
            <div class="carousel-caption">

                <p></p>
            </div>
        </div>
        <div class="item">
            <img src="/images/2.jpg" alt="" class="img-responsive">
            <div class="carousel-caption">

                <p></p>
            </div>
        </div>
        <div class="item">
            <img src="/images/3.jpg" alt="" class="img-responsive">
            <div class="carousel-caption">

                <p></p>
            </div>
        </div>


    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>





        <h1>Каталог підприємств</h1>
        <div class="row" style="background-color: #f5f5f5">
        <?php
            if(!empty($result)) {
                $i = 1;
                foreach ($result as $val) {
                    $subcategory = $val->subcategory;
                    if(!empty($subcategory)) {

                        echo '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-6" >';
                        echo '<div class="header-h3 head-catalog">'.mb_strtoupper($val->name,'UTF-8').'</div>';
                        echo '<ul class="list-unstyled list-subcategory">';

                        if(!empty($subcategory)) {
                            foreach ($subcategory as $subcat) {
                                echo '<li><a href="post/'.$subcat->subcategory_id.'">'.$subcat->title.'</a></li>';
                            }
                        }
                        echo '</ul></div>';

                        if($i % 2 == 0 ) {
                            echo '<div class="clearfix visible-lg"></div>';
                            echo '<div class="clearfix visible-md"></div>';
                            echo '<div class="clearfix visible-sm"></div>';
                        }
                        $i++;
                    }
                }
            }

        ?>
        </div>







