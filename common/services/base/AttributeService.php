<?php
namespace addons\YunStore\common\services\base;

use addons\YunStore\common\models\base\Attribute;
use common\components\Service;
use common\enums\StatusEnum;
use common\helpers\ArrayHelper;
use Yii;


class AttributeService extends Service
{
    /**
     * 获取对应的参数和规格
     *
     * @param $attribute_id
     */
    public function getDataById($attribute_id)
    {
        $model = Attribute::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andWhere(['id' => $attribute_id])
            ->andFilterWhere(['merchant_id' => $this->getMerchantId()])
            ->with(['value'])
            ->asArray()
            ->one();

        return $model;
    }

    /**
     * @return array
     */
    public function getMapList()
    {
        return ArrayHelper::map($this->getList(), 'id', 'title');
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getList()
    {
        return Attribute::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andWhere(['merchant_id' => Yii::$app->services->merchant->getId()])
            ->orderBy('sort asc, id desc')
            ->asArray()
            ->all();
    }
}