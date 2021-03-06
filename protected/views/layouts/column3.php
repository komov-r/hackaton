<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<!-- Start: HEADER -->
<header>
    <!-- Start: Navigation wrapper -->
    <div class="navbar navbar-static-top">
        <div class="navbar-inner ">
            <div style="width:1200px;margin: 0px auto">
                <a href="" class="brand ">Лиза алерт</a>

                <!-- Start: Primary navigation -->
                <div class="nav-collapse collapse">        
                    <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'items' => array(
                            array('label' => 'Вход', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                            array('label' => 'Выход (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                        ),
                        'htmlOptions' => array('class' => 'nav pull-right'),
                    ));
                    ?>  
                </div>
            </div>
        </div>
    </div>
    <!-- End: Navigation wrapper -->   
</header>
<div class="content">
    <div class="" style="width:1200px;margin: 20px auto">
        <div class="span2" style="margin-left: 0px">
            <div class="well" style="padding: 8px 0px">
                <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title' => '',
                ));
                $this->widget('zii.widgets.CMenu', array(
                    'items' => $this->main_menu,
                    'activateItems' => true,
                    'activeCssClass' => 'active',
                    'encodeLabel' => false,
                    'htmlOptions' => array('class' => 'nav nav-list'),
                ));
                $this->endWidget();
                ?>


            </div>
            <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title' => '',
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items' => $this->menu,
                'htmlOptions' => array('class' => 'nav nav-tabs nav-stacked'),
            ));
            $this->endWidget();
            ?>
        </div>
        <div class="span12">
            <div id="content">

<?= $content; ?>
            </div><!-- content -->
        </div>
        <div class="span2">


        </div>
    </div>
</div>
<!-- End: MAIN CONTENT -->
<?php $this->endContent(); ?>