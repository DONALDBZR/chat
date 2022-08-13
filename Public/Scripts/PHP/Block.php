<?php
// Block class
class Block
{
    // Class variables
    private int $index;
    protected Transaction $Transaction;
    private string $timestamp;
    private string $previousHash;
    private int $nonce;
    private string $hash;
    // Constructor method
    public function __construct()
    {
        // Instantiating Transaction
        $this->Transaction = new Transaction();
    }
    // Index accessor method
    public function getIndex()
    {
        return $this->index;
    }
    // Index mutator method
    public function setIndex(int $index)
    {
        $this->index = $index;
    }
    // Transaction accessor method
    public function getTransaction()
    {
        return $this->Transaction;
    }
    // Transaction mutator method
    public function setTransaction(Transaction $Transaction)
    {
        $this->Transaction = $Transaction;
    }
    // Timestamp accessor method
    public function getTimestamp()
    {
        return $this->timestamp;
    }
    // Timestamp mutator method
    public function setTimestamp()
    {
        // Setting the default timezone
        date_default_timezone_set("Indian/Mauritius");
        // Setting the current time to the timestamp
        $this->timestamp = date("Y-m-d H:i:s");
    }
    // Previous Hash accessor method
    public function getPreviousHash()
    {
        return $this->previousHash;
    }
    // Previous Hash mutator method
    public function setPreviousHash(string $previousHash)
    {
        $this->previousHash = $previousHash;
    }
    // Nonce accessor method
    public function getNonce()
    {
        return $this->nonce;
    }
    // Nonce mutator method
    public function setNonce(int $nonce)
    {
        $this->nonce = $nonce;
    }
    // Hash accessor method
    public function getHash()
    {
        return $this->hash;
    }
    // Hash mutator method
    public function setHash(string $hash)
    {
        $this->hash = $hash;
    }
    // Compute Hash method
    public function computeHash()
    {
        // Local variables
        $blockString = $this->getIndex() . $this->getTransaction() . $this->getTimestamp() . $this->getPreviousHash() . $this->getNonce();
        // Returning the hash of the block string
        return hash("sha256", $blockString);
    }
}
