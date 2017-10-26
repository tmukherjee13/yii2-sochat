<?php

namespace Sochat;

use \common\modules\message\models\Message;
use \common\modules\user\models\User;
use \common\modules\user\models\Profile;
use \common\modules\user\models\UserType;
use yii\db\Query;

trait Chatter
{

    public function insertMessage($data)
    {
        $chat = new Message();
        $chat->load($data);
        if ($chat->save()) {
            $msg = $this->getMessage($chat->id);
            return $msg;
        } else {
            return $chat->errors;
        }
    }

    public function getMessage($msgId)
    {

        $imageUrl = Yii::$app->urlManagerUpload->baseUrl.'/users/profile/';
        $defaultImageUrl = Yii::$app->urlManagerUpload->baseUrl.'/users/profile/default.png';

        $query = new Query;
        $query->select(['c.id', 'c.sender_id as from', 'c.receiver_id as to', 'c.message', 'c.created_at', 'u.username','p.first_name','p.last_name','ut.description as userType','IF(IsNull(`p`.image_web_filename),'.$defaultImageUrl.',CONCAT('.$imageUrl.',`p`.image_web_filename)) as `profile_picture`'])
            ->from(['c' => Message::tableName()])
            ->where(['=', 'c.id', $msgId])
        // ->where(['or', ['to_user' => $id], ['from_user' => $id]])
            ->orderBy('created_at', SORT_DESC);
        // ->limit(10);

        $query->leftJoin(['u' => User::tableName()], 'u.id = c.sender_id');
        $query->leftJoin(['p' => Profile::tableName()], 'p.user_id = u.id');
        $query->leftJoin(['ut' => UserType::tableName()], 'ut.id = u.user_type');

        $message = $query->one();
        return $message;
    }

}
