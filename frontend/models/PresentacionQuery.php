<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Usuario]].
 *
 * @see Usuario
 */
class PresentacionQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Presentacion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Presentacion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
