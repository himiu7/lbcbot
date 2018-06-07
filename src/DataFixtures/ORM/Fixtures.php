<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 04.06.2018
 * Time: 13:56
 */

namespace App\DataFixtures\ORM;

use App\Entity\Algorithm;
use App\Entity\AlgorithmParam;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $algorithm = (new Algorithm())
            ->setName('lbc_sell_ad')
            ->setDescription('Продвижение объявлений на рынке продаж')
            ->setInputClass('AdBuyInput')
            ->setResultClass('AdTradeResult');

        $param = (new AlgorithmParam())
            ->setName('ad_id')
            ->setTitle('ID объявления для продвиджения');
        $algorithm->addParam($param);

        $param = (new AlgorithmParam())
            ->setName('min_price_limit')
            ->setTitle('Минимальная цена предложения');
        $algorithm->addParam($param);

        $param = (new AlgorithmParam())
            ->setName('price_step')
            ->setTitle('Размер ставки понижения цены');
        $algorithm->addParam($param);

        $manager->persist($algorithm);
        $manager->flush();
    }
}