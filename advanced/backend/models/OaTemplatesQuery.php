<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[OaTemplates]].
 *
 * @see OaTemplates
 */
class OaTemplatesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OaTemplates[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OaTemplates|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
