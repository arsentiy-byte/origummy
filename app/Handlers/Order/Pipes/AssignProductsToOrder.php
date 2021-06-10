<?php

declare(strict_types=1);

namespace App\Handlers\Order\Pipes;

use App\Handlers\Order\OrderParam;
use App\Models\Order\OrderProduct;
use App\Models\Product\Product;
use Closure;

/**
 * Class AssignProductsToOrder.
 */
final class AssignProductsToOrder
{
    /**
     * @param OrderParam $orderParam
     * @param Closure $next
     * @return mixed
     */
    public function handle(OrderParam $orderParam, Closure $next): mixed
    {
        $products = $orderParam->getDto()->getProducts();
        $orderId = $orderParam->getOrder()->id;

        $orderParam->setProducts($this->getProducts($products, $orderId));

        return $next($orderParam);
    }

    /**
     * @param array $products
     * @param int $orderId
     * @return Product[]
     */
    private function getProducts(array $products, int $orderId): array
    {
        $result = [];
        foreach ($products as $product) {
            OrderProduct::create([
                'order_id'      => $orderId,
                'product_id'    => $product['id'],
                'count'         => $product['count'],
            ]);

            $productModel = Product::findOrFail($product['id']);
            $productModel->orderCount = $product['count'];
            $result[] = $productModel;
        }

        return $result;
    }
}
