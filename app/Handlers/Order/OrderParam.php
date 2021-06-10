<?php

declare(strict_types=1);

namespace App\Handlers\Order;

use App\DTO\OrderDTO;
use App\Handlers\InterfaceParam;
use App\Models\Client;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Traits\OrderTrait;

/**
 * Class OrderParam.
 */
final class OrderParam implements InterfaceParam
{
    use OrderTrait;

    /**
     * @var OrderDTO
     */
    private OrderDTO $dto;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var Order
     */
    private Order $order;

    /**
     * @var Product[]
     */
    private array $products;

    public function __construct(OrderDTO $orderDTO)
    {
        $this->dto = $orderDTO;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        $products = $this->getProducts();
        $order = $this->getOrder();
        $client = $this->getClient();

        return [
            'order_id'          => $order->id,
            'name'              => $client->name,
            'phone'             => $client->phone,
            'address'           => $client->address,
            'payment_type'      => $order->payment_type,
            'order_count'       => $order->count,
            'products'          => $this->filterProducts($products),
            'total_price'       => $this->getTotalPrice($products),
            'delivery_time'     => $order->delivery_time,
            'order_date'        => now()->toDateString(),
            'additional_info'   => $order->additional_info,
        ];
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @return OrderDTO
     */
    public function getDto(): OrderDTO
    {
        return $this->dto;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    /**
     * @param Product[] $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }
}
