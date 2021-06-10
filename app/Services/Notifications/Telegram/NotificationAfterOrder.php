<?php

declare(strict_types=1);

namespace App\Services\Notifications\Telegram;

use App\Services\Notifications\GetMessageInterface;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

final class NotificationAfterOrder extends Notification implements GetMessageInterface
{
    private array $data;

    private function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        $message = '*Заказ #'.$this->data['order_id']."*\n\n";
        $message .= 'Имя: '.$this->data['name']."\n";
        $message .= 'Номер телефона: '.$this->data['phone']."\n";
        $message .= 'Адрес: '.$this->data['address']."\n";
        $message .= 'Способ оплаты: '.$this->data['payment_type']."\n";
        $message .= 'Время доставки: '.$this->data['delivery_time']."\n";
        $message .= 'Кол-во приборов: '.$this->data['order_count']."\n";
        $message .= 'Итоговая цена: '.$this->data['total_price']." тг.\n";
        $message .= 'Дата заказа: '.$this->data['order_date']."\n\n";
        $message .= 'Доп. информация: '.$this->data['additional_info']."\n\n";
        $message .= "    *Корзина*\n";
        foreach ($this->data['products'] as $index => $product) {
            $message .= ($index + 1).') '.$product['title'].' - '.$product['count']." пор.\n";

            foreach ($product['promotions'] as $promotion) {
                $message .= '    - '.$promotion['title'].";\n";
            }
        }

        return $message;
    }

    /**
     * @param $notifiable
     * @return string[]
     */
    public function via($notifiable): array
    {
        return [TelegramChannel::class];
    }

    /**
     * @param $notifiable
     * @return TelegramMessage
     */
    public function toTelegram($notifiable): TelegramMessage
    {
        return TelegramMessage::create()->content($this->getMessage());
    }

    /**
     * @param array $data
     */
    public static function send(array $data): void
    {
        $self = new static($data);

        TelegramNotification::send($self);
    }
}
