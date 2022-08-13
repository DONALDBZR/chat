<?php
// Importing the Block
$_SERVER["DOCUMENT_ROOT"] . "/Public/Scripts/PHP/Block.php";
// Blockchain Class
class Blockchain
{
    // Class variables
    private array $unconfirmedTransactions;
    public array $chain;
    protected Block $Block;
    // Constructor method
    protected function __construct()
    {
        // Instantiating the Block
        $this->Block = new Block();
        // Creating the genesis block
        $this->createGenesisBlock();
    }
    // Create Genesis Block method
    protected function createGenesisBlock()
    {
        // Creating the Genesis Block
        $GenesisBlock = $this->Block;
        // Setting all the data of the Genesis Block
        $GenesisBlock->setIndex(0);
        $GenesisBlock->setTransaction($this->Block->getTransaction());
        $GenesisBlock->setTimestamp();
        $GenesisBlock->setPreviousHash("0");
        $GenesisBlock->setNonce("0");
        // Setting the hash of the Genesis Block
        $GenesisBlock->setHash($GenesisBlock->computeHash());
        // Adding the Genesis Block to the chain
        array_push($this->chain, $GenesisBlock);
    }
}
