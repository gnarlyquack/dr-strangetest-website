<?php declare(strict_types=1);
// test_orders.php

namespace test\orders;

use example\Database;
use example\OrderManager;
use example\PaymentProcessor;
use example\PaymentProcessorA;
use example\PaymentProcessorB;
use function strangetest\assert_true;

function setup_run_processor_a(Database $database): array
{
    $processor = new PaymentProcessorA();
    return [$database, $processor];
}

function setup_run_processor_b(Database $database): array
{
    $processor = new PaymentProcessorB();
    return [$database, $processor];
}

function setup_file(Database $database, PaymentProcessor $processor): array
{
    $database->loadTestData();
    $processor->setTestMode();
    return [$database, $processor];
}

function teardown_file(Database $database, PaymentProcessor $_): void
{
    $database->clearTestData();
}

function setup(Database $database, PaymentProcessor $processor): array
{
    $database->reset();
    return [new OrderManager($database, $processor)];
}

function test(OrderManager $order): void
{
    $order->placeOrder();
    assert_true($order->wasPlaced(), 'Order was not placed');
}
