<?php
// Block class
class Block
{
    // Class variables
    private int $index;
    private Transaction $Transaction;
    private string $timestamp;
    private string $previousHash;
    private string $nonce;
    // Constructor method
    protected function __construct()
    {
        // Instantiating Transaction
        $this->Transaction = new Transaction();
    }
    // Index accessor method
    protected function getIndex()
    {
        return $this->index;
    }
    // Index mutator method
    protected function setIndex(int $index)
    {
        $this->index = $index;
    }
    // Transaction accessor method
    protected function getTransaction()
    {
        return $this->Transaction;
    }
    // Transaction mutator method
    protected function setTransaction(Transaction $Transaction)
    {
        $this->Transaction = $Transaction;
    }
    // Timestamp accessor method
    protected function getTimestamp()
    {
        return $this->timestamp;
    }
    // Timestamp mutator method
    protected function setTimestamp()
    {
        // Setting the default timezone
        date_default_timezone_set("Indian/Mauritius");
        // Setting the current time to the timestamp
        $this->timestamp = date("Y-m-d H:i:s");
    }
    // Previous Hash accessor method
    protected function getPreviousHash()
    {
        return $this->previousHash;
    }
    // Previous Hash mutator method
    protected function setPreviousHash(string $previousHash)
    {
        $this->previousHash = $previousHash;
    }
    // Nonce accessor method
    protected function getNonce()
    {
        return $this->nonce;
    }
    // Nonce mutator method
    protected function setNonce(string $nonce)
    {
        $this->nonce = $nonce;
    }
    // Compute Hash method
    protected function computeHash()
    {
        // Local variables
        $blockString = $this->getIndex() . $this->getTransaction() . $this->getTimestamp() . $this->getPreviousHash() . $this->getNonce();
        // Returning the hash of the block string
        return hash("sha256", $blockString);
    }
}
