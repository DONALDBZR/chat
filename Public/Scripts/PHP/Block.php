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
    public function __construct()
    {
        // Instantiating Transaction
        $this->Transaction = new Transaction();
    }
}
