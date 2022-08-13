<?php
// Importing the Block
$_SERVER["DOCUMENT_ROOT"] . "/Public/Scripts/PHP/Block.php";
// Blockchain Class
class Blockchain
{
    // Class variables
    private array $unconfirmedTransactions;
    private array $chain;
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
        // Creating the genesis block as an empty array
        $genesisBlock = array();
        // Setting the data for the genesis block
        $genesisBlock["index"] = $this->Block->setIndex(0);
        $genesisBlock["transaction"] = $this->Block->setTransaction($this->Block->getTransaction());
        $genesisBlock["timestamp"] = $this->Block->setTimestamp();
        $genesisBlock["previousHash"] = $this->Block->setPreviousHash("0");
        $genesisBlock["nonce"] = $this->Block->setNonce("0");
    }
}
