# yii2-log-after-save

ActiveRecord
------------------------------
```php
/**
 * @param int $statusId
 * @param string|null $comment
 */
public function setStatus($statusId, $comment = null)
{
    $this->setAttribute('status_id', $statusId);
    $this->_addLog(new StatusLog(['order_id' => $this->id, 'status_id' => $statusId, 'comment' => $comment]));
}

/**
 * @param ActiveRecord $log
 */
protected function _addLog(ActiveRecord $log)
{
    /** @var LogAfterSaveBehavior $behavior */
    $behavior = $this->getBehavior(LogAfterSaveBehavior::NAME);

    if (! $behavior)
        $behavior = $this->attachBehavior(LogAfterSaveBehavior::NAME, LogAfterSaveBehavior::class);

    $behavior->addLog($log);
}
```
