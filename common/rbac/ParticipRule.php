<?php

namespace common\rbac;

use Yii;
use yii\rbac\Rule;

class ParticipRule extends Rule {

    public $name = 'participAccess';

    /**
     * @param string|integer $user ID пользователя.
     * @param Item $item роль или разрешение с которым это правило ассоциировано
     * @param array $params параметры, переданные в ManagerInterface::checkAccess(), например при вызове проверки
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params) {
        if (Yii::$app->user->can('operator')) {
            if ($item->name == 'unlock') {
                return false;
            } else {
                return true;
            }
        }
        else if (Yii::$app->user->can('admin')) {
            return true;
        } else {
            if (isset($params['particip'])) {
                $id = $params['particip']->created_by;
                if ($params['particip']->created_by == $user) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false;
    }

}
