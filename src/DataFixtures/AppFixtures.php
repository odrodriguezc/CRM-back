<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Invoice;
use App\Entity\Customer;
use App\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends AbstractFixture
{

    protected UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder =  $encoder;
    }

    public function loadData(ObjectManager $manager)
    {

        $this->createMany(User::class, 10, function (User $user, $u) {
            $user->setEmail("user$u@gmail.com")
                ->setFullName($this->faker->name())
                ->setPassword($this->encoder->encodePassword($user, "12345"));
        });

        $this->createMany(Customer::class, 40, function (Customer $customer) {
            $customer
                ->setFullName($this->faker->name())
                ->setEmail($this->faker->safeEmail)
                ->setCreatedAt($this->faker->dateTimeBetween('-6 months'))
                ->setUpdatedAt($this->faker->dateTimeBetween('-6 months'))
                ->setUser($this->getRandomReference(User::class));

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
