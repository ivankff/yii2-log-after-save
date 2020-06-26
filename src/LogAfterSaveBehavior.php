<?php

namespace ivankff\yii2LogAfterSave;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;

/**
 * @property ActiveRecord $owner
 */
class LogAfterSaveBehavior extends Behavior
{

    const NAME = 'logAfterSave';

    /**
     * Список логов, которые надо сохранить после сохранения основной модели
     * @var ActiveRecord[]
     */
    public $afterSave = [];

    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'onAfterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'onAfterSave',
        ];
    }

    /**
     * @param AfterSaveEvent $event
     */
    public function onAfterSave($event)
    {
        while ($item = array_shift($this->afterSave))
            $item->save();

        if ($this->owner)
            $this->owner->detachBehavior(self::NAME);
    }

    /**
     * @param ActiveRecord $log
     */
    public function addLog(ActiveRecord $log)
    {
        $this->afterSave[] = $log;
    }

}