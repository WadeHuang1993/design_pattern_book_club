<?php

namespace Tests\Feature;

class EmailSender
{

    /**
     * 透過第三方信件服務寄送信件
     *
     * @param array $userEmails 使用者的電子郵件地址
     * @param array $emailContent 信件內容
     * @return array
     */
    public static function send(array $userEmails, array $emailContent)
    {
        foreach ($userEmails as &$userEmail) {
            /** 假設是透過 Google 寄送信件 */
            // $mailer = new GoogleEmail()
            // $mailer->send($userEmail['email'], $emailContent['title'], $emailContent['content']);

            // 註記已經寄送信件
            /** 註記已經寄送信件 */
            $userEmail['isSent'] = true;
        }

        return $userEmails;
    }
}
