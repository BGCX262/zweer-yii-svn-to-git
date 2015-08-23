<?php

class TrackstarActiveRecord extends CActiveRecord
{
    /**
     * Prepares create_time, create_user_id, update_time and update_user_id attributes before performing validation.
     */
    protected function beforeValidate()
    {
        if($this->isNewRecord) {
            // Set the create date, last updated date and the user doing the creating
            $this->create_time = new CDbExpression('NOW()');
            $this->create_user_id = Yii::app()->user->id;
        }

        $this->update_time = new CDbExpression('NOW()');
        $this->update_user_id = Yii::app()->user->id;

        return parent::beforeValidate();
    }
}