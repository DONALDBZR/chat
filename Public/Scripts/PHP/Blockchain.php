<?php
// Importing the Block
$_SERVER["DOCUMENT_ROOT"] . "/Public/Scripts/PHP/Block.php";
// Blockchain Class
class Blockchain
{
    // Class variables
    private array $unconfirmedTransactions;
    private int $difficulty;
    public array $chain;
    protected Block $Block;
    // Constructor method
    public function __construct()
    {
        // Instantiating the Block
        $this->Block = new Block();
        // Setting the difficulty of the blockchain
        $this->setDifficulty(2);
        // Creating the genesis block
        $this->createGenesisBlock();
    }
    // Difficulty accessor method
    public function getDifficulty()
    {
        return $this->difficulty;
    }
    // Difficulty mutator method
    public function setDifficulty(int $difficulty)
    {
        $this->difficulty = $difficulty;
    }
    // Create Genesis Block method
    public function createGenesisBlock()
    {
        // Creating the Genesis Block
        $GenesisBlock = $this->Block;
        // Setting all the data of the Genesis Block
        $GenesisBlock->setIndex(0);
        $GenesisBlock->setTransactions($this->Block->getTransactions());
        $GenesisBlock->setTimestamp();
        $GenesisBlock->setPreviousHash("0");
        $GenesisBlock->setNonce("0");
        // Setting the hash of the Genesis Block
        $GenesisBlock->setHash($GenesisBlock->computeHash());
        // Adding the Genesis Block to the chain
        array_push($this->chain, $GenesisBlock);
    }
    // Last Block method
    public function lastBlock()
    {
        return $this->chain[-1];
    }
    // Proof Of Work method
    public function proofOfWork(Block $block)
    {
        // Setting the nonce of the block
        $block->setNonce(0);
        // Computing the hash of the block
        $computedHash = $block->computeHash();
        // While-Loop to iterate when it is not on the genesis block
        while (!str_contains($computedHash, "0" * $this->getDifficulty())) {
            // Incrementing the Nonce of the block
            $block->setNonce($block->getNonce() + 1);
            // Computing the hash of the block
            $computedHash = $block->computeHash();
        }
        // Returning the hash
        return $computedHash;
    }
    // Add Block method
    public function addBlock(Block $block, string $proof)
    {
        // Setting the hash of the previous block
        $previousHash = $this->lastBlock()->getHash();
        // If-statement to verify that the previous hash is not equal to the block's previous hash
        if ($previousHash != $block->getPreviousHash()) {
            return false;
        }
        // If-statement to verify that the proof is valid
        if ($this->isValidProof($block, $proof)) {
            return false;
        }
        // Setting the hash of the block to be the proof
        $block->setHash($proof);
        // Adding the block to the block chain
        array_push($this->chain, $block);
        return true;
    }
    // Is Valid Proof method
    public function isValidProof(Block $block, string $blockHash)
    {
        // If-statement to verify that the proof is valid
        if (str_contains($blockHash, "0" * $this->getDifficulty()) and $blockHash === $block->computeHash()) {
            return true;
        } else {
            return false;
        }
    }
    // Add New Transaction method
    public function addNewTransaction($transaction)
    {
        array_push($this->unconfirmedTransactions, $transaction);
    }
    // Mine method
    public function mine()
    {
        // If-statement to verify that there is no unconfirmed transaction
        if (!$this->unconfirmedTransactions) {
            return false;
        } else {
            // Fetching the last block
            $lastBlock = $this->lastBlock();
            // Creating a new block
            $newBlock = $this->Block;
            // Setting the data for the new block
            $newBlock->setIndex($lastBlock->getIndex() + 1);
            $newBlock->setTransactions($this->unconfirmedTransactions);
            $newBlock->setTimestamp();
            $newBlock->setPreviousHash($lastBlock->getHash());
            // Setting the proof for the new block
            $proof = $this->proofOfWork($newBlock);
            // Adding the new block
            $this->addBlock($newBlock, $proof);
            // Clearing the unconfirmed transactions
            $this->unconfirmedTransactions = array();
            // Returning the new block's index
            return $newBlock->getIndex();
        }
    }
}
