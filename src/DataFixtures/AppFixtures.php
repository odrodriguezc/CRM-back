<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractFixture;
use App\Entity\Customer;
use App\Entity\Invoice;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends AbstractFixture
{
    public function loadData(ObjectManager $manager)
    {

        $this->createMany(Customer::class, 40, function (Customer $customer) {
            $customer
                ->setFullName($this->faker->name())
                ->setEmail($this->faker->safeEmail)
                ->setCreatedAt($this->faker->dateTimeBetween('-6 months'))
                ->setUpdatedAt($this->faker->dateTimeBetween('-6 months'));

            if ($this->faker->boolean()) {
                $customer->setCompany($this->faker->company);
            }
        });


        $this->createMany(Invoice::class, 100, function (Invoice $invoice, $index) {
            // $createdAt = $this->faker->dateTimeBetween('-6 months');
            // $updatedAt = (clone $createdAt)->modify('+'. mt_rand(10, 20) . ' days');

            $invoice
                ->setChrono($index + 1)
                ->setAmount(mt_rand(200, 1500) * 100)
                ->setCreatedAt($this->faker->dateTimeBetween('-6 months'))
                ->setUpdatedAt($this->faker->dateTimeBetween('-6 months'))
                ->setTitle($this->faker->catchPhrase)
                ->setCustomer($this->getRandomReference(Customer::class));
        });
    }
}
