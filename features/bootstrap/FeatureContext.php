<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use EC\Command\AddProductToCart;
use EC\Command\ClearCart;
use EC\Handler\AddProductToCartHandler;
use EC\Handler\ClearCartHandler;
use EC\Product;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $bus;
    private $carts;
    private $cartId;


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->carts = new \EC\Repository\InMemoryEventSourcedCartsRepository();
        $this->cartId = Uuid::uuid4();
        $laptop = new Product(Uuid::uuid4(), 'Laptop');
        $pecet = new Product(Uuid::uuid4(), 'Pecet');

        $this->bus = new MessageBus([
            new HandleMessageMiddleware(new HandlersLocator([
                AddProductToCart::class => [new AddProductToCartHandler($this->carts)],
                ClearCart::class => [new ClearCartHandler($this->carts)],
            ])),
        ]);
    }

    /**
     * @Given there is :productName product in customer cart
     */
    public function thereIsProductInCustomerCart($productName)
    {
        $product = new Product(Uuid::uuid4(), $productName);
        $this->bus->dispatch(new AddProductToCart($this->cartId->toString(), $product->getId()->toString()));
    }

    /**
     * @When customer clear his cart
     */
    public function customerClearHisCart()
    {
        $this->bus->dispatch(new ClearCart($this->cartId->toString()));
    }

    /**
     * @Then customer cart should be empty
     */
    public function customerCartShouldBeEmpty()
    {
        $cart = $this->carts->getOrCreate($this->cartId);

        if (count($cart->getItems()) > 0) {
            throw new \LogicException('There should be empty cart');
        }
    }

}
