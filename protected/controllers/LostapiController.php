<?php

class LostapiController extends ApiController
{

    protected $model = 'Lost';

    public function accessRules()
    {
        return array_merge(
                array(array('allow',
                'users' => array('*'),
            )
                ), parent::accessRules()
        );
    }

    public function actionList($city_id = '')
    {

        $modelname = $this->model;

        $params = array();
        if (!empty($city_id))
            $params = array('city_id' => $city_id);

        $models = $modelname::model()->findAllByAttributes($params);

        if (is_null($models))
        {
            $this->_sendResponse(200, array('error' => 0, 'content' => array()));
        } else
        {
            $content = array_map(function($v)
                    {
                        return
                                array('photo' => Yii::app()->params['url'] . Yii::app()->params['photosRelative'] . $model->photo) +
                                $v->attributes +
                                array('city' => $v->city->attributes) +
                                array('coordinator' => $v->coordinator->attributes);
                    }, $models);

            $this->_sendResponse(200, array('error' => 0, 'content' => $content));
        }
    }

    public function actionView($id)
    {

        $modelname = $this->model;

        $model = $modelname::model()->findByPk($id);

        if (!$model)
        {
            $this->_sendResponse(404, array('error' => "Couldn't find model."));
        } else
        {
            $this->_sendResponse(200, array('error' => 0, 'content' =>
                array('photo' => Yii::app()->params['url'] . Yii::app()->params['photosRelative'] . $model->photo) +
                $model->attributes +
                array('city' => $model->city->attributes) +
                array('coordinator' => $model->coordinator > attributes)));
        }
    }

}