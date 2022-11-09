<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * 寄送信件測試案例
 */
class EmailSenderTest extends TestCase
{
    public function testSendEmail()
    {
        $this->specify(
            '
        全站會員的信箱，
        透過信件服務寄送信件，
        系統排除信件格式不正確的信件，
        寄出信件規格正確的信件，且標記已寄送，
        ',
            function () {
                /** @given 全站會員的信箱 */
                $userEmails = [
                    [
                        'email' => 'unit@test.com',
                        'isSent' => false,
                    ],
                    [
                        'email' => '', // 信件格式不符
                        'isSent' => false,
                    ]
                ];

                /** @when 透過信件服務寄送信件 */
                $emailContent = [
                    'title' => '促銷優惠告你知！',
                    'content' => '全站消費滿 1000 元免運',
                ];
                $result = EmailSender::send($userEmails, $emailContent);

                /** @then 系統排除信件格式不正確的信件 */
                $userEmailAlreadySent = array_filter($result, function ($userEmail) {
                    return $userEmail['isSent'] === false;
                });
                self::assertCount(1, $userEmailAlreadySent);

                /** @then 寄出信件規格正確的信件，且標記已寄送 */
                $userEmailAlreadySent = array_filter($result, function ($userEmail) {
                    return $userEmail['isSent'] === true;
                });
                self::assertCount(1, $userEmailAlreadySent);
            }
        );
    }
}
