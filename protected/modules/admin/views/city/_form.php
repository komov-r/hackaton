<?php
/* @var $this CityController */
/* @var $model City */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'city-form',
	'enableAjaxValidation'=>false,
        'htmlOptions'=>array('class'=>'form-horizontal')
)); ?>

<?if($model->hasErrors()):?><div class="alert alert-error">

	<?php echo $form->errorSummary($model); ?>
</div>
<? endif;?>
 <div class="control-group">
		<?php echo $form->labelEx($model,'name',array('class'=>'control-label')); ?>
     <div class="controls">
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
     </div>
</div>
 <div class="control-group">
	<div class="controls">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить',array('class'=>'btn')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>

