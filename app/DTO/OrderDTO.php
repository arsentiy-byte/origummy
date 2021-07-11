<?php

declare(strict_types=1);

namespace App\DTO;

use JetBrains\PhpStorm\Pure;

/**
 * Class OrderDTO.
 */
final class OrderDTO implements InterfaceDTO
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $phone;

    /**
     * @var string
     */
    public string $address;

    /**
     * @var string
     */
    public string $deviceInfo;

    /**
     * @var string|null
     */
    public ?string $additionalInfo = null;

    /**
     * @var int
     */
    public int $count = 1;

    /**
     * @var string
     */
    public string $paymentType;

    /**
     * @var string
     */
    public string $deliveryTime;

    /**
     * @var string|null
     */
    public ?string $deliveryType = null;

    /**
     * @var array
     */
    public array $products;

    /**
     * @param array $input
     * @return OrderDTO
     */
    #[Pure]
 public static function fromArray(array $input): self
 {
     $self = new static();

     $self->name = $input['name'];
     $self->phone = $input['phone'];
     $self->address = $input['address'];
     $self->deviceInfo = $input['device_info'];
     $self->additionalInfo = $input['additional_info'] ?? null;
     $self->count = isset($input['count']) ? (int) $input['count'] : 1;
     $self->paymentType = $input['payment_type'];
     $self->deliveryTime = $input['delivery_time'];
     $self->deliveryType = $input['delivery_type'] ?? null;
     $self->products = $input['products'];

     return $self;
 }

    /**
     * @return array
     */
    public function getClientData(): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'device_info' => $this->deviceInfo,
        ];
    }

    /**
     * @return array
     */
    public function getOrderData(): array
    {
        return [
            'additional_info' => $this->additionalInfo,
            'count' => $this->count,
            'payment_type' => $this->paymentType,
            'delivery_time' => $this->deliveryTime,
            'delivery_type' => $this->deliveryType,
            'client_id' => null,
        ];
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}
