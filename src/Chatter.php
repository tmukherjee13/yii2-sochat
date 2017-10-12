<?php

namespace Sochat;

trait Chatter
{

    public function insertMessage($data)
    {
        $chat = new Chat();
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
        $query = new Query;
        $query->select(['c.id', 'c.from_user', 'c.to_user', 'c.message', 'c.created_at', 'u.username'])
            ->from(['c' => Chat::tableName()])
            ->where(['=', 'c.id', $msgId])
        // ->where(['or', ['to_user' => $id], ['from_user' => $id]])
            ->orderBy('created_at', SORT_DESC);
        // ->limit(10);

        $query->leftJoin(['u' => User::tableName()], 'u.id = c.from_user');
        // $query->join('LEFT JOIN', User::tableName(), 'wf_user.id = wf_chat.from_user');

        $message = $query->one();
        return $message;
    }

}
