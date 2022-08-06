<?php

require('./vendor/autoload.php');
define('ROOT_PATH', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
require_once $_SERVER["DOCUMENT_ROOT"] . "/Modules/BlockChain/Blockchain.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Modules/BlockChain/Block.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Modules/BlockChain/Utils.php";

$blockchain = new \BlockChain\Blockchain([
	'name'       => 'Blockchain',
	'version'    => 1,
	'blocks_dir' => __DIR__ . '/data/'
]);

$faker = Faker\Factory::create();

$block = new \BlockChain\Block([
	'author' => 'Bel Veth',
	'message' => $faker->realText(mt_rand(10, 150))
]);

$blockchain->addBlock($block);

header("Location: /view.php");