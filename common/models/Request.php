<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property string $name
 * @property string $email
 * @property int $status
 * @property string $message
 * @property string|null $comment
 */
class Request extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const STATUS_ACTIVE = 0;
    const STATUS_RESOLVED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['name', 'email', 'message'],
            self::SCENARIO_UPDATE => ['comment'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'status', 'message'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['message', 'comment'], 'string'],
            [['name', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['comment'], 'required', 'on' => [self::SCENARIO_UPDATE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->scenario === self::SCENARIO_UPDATE) {
            $this->status = self::STATUS_RESOLVED;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->scenario === self::SCENARIO_UPDATE) {
            $mail = Yii::$app->mailer->compose([
                'html' => 'requestUpdate-html',
                'text' => 'requestUpdate-text',
            ], ['model' => $this]);

            $mail->setFrom(Yii::$app->params['senderEmail'])
                ->setTo($this->email)
                ->setSubject(Yii::$app->params['request.subject'])
                ->send();
        }
    }
}
