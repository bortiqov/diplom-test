<?php

namespace common\modules\translation\models;


use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "source_message".
 *
 * @property int $id
 * @property string $category
 * @property string $message
 *
 * @property Message[] $messages
 */
class SourceMessage extends \yii\db\ActiveRecord
{
    const SCENARIO_SEARCH = "search";
    const STATUS_ACTIVE = 1;
    const CACHE_TAG = 'translation';

    public $search;
    public $language;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['category'], 'string', 'max' => 255],
            [['search', 'language'], 'safe', 'on' => ['search']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'message' => 'Message',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['id' => 'id'])->inverseOf('id0');
    }

    /**
     * @inheritdoc
     * @return SourceMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SourceMessageQuery(get_called_class());
    }

    public static function create($message, $category = "main")
    {
        $sm = new self();
        $sm->category = $category;
        $sm->message = $message;

        if (static::findOne(['category' => $category, 'message' => $message]) instanceof SourceMessage) {
            return true;
        }

        $sm->validate();
        if ($sm->hasErrors()) {
            return $sm->getErrors();
        }
        return $sm->save();
    }

    public function addTranslations($data)
    {
        $insert = [];
        foreach ($data as $lang => $translation) {
            $insert[] = [
                'id' => $this->id,
                'language' => $lang,
                'translation' => $translation,
            ];
        }
        if (count($insert)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                Yii::$app->db
                    ->createCommand()
                    ->delete(Message::tableName(), ['id' => $this->id])
                    ->execute();
                Yii::$app->db
                    ->createCommand()
                    ->batchInsert(Message::tableName(), ['id', 'language', 'translation'], $insert)
                    ->execute();
                $transaction->commit();
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        return false;
    }

    public function search($params)
    {
        $this->load($params);
        $query = self::find()
            ->select(['m.*', 'translation' => 't.translation'])
            ->from(['m' => self::tableName()])
            ->leftJoin(['t' => Message::tableName()],"t.id = m.id ");

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'sort'       => [
                'defaultOrder' => ['id' => 'DESC'],
                'attributes'   => [
                    'id',
                    'translation',
                    'message',
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if ($this->search){
            $query
                ->orFilterWhere(['like', 'message', $this->search])
                ->orFilterWhere(['like', 'translation', $this->search]);
        }

        return $dataProvider;
    }




}
