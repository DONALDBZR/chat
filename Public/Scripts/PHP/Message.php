<?php

/**
 * • The class that stores all the properties related to the messages given that it should inherit from the conversation
 */
class Conversation extends Contact
{
    /**
     * Primary Key of the record
     */
    private int $id;
    /**
     * Plain text to be encrypted
     */
    private string $plainText;
    /**
     * Cipher text to be decrypted
     */
    private string $cipherText;
    // Constructor method
    public function __construct()
    {
        // Instantiating PDO
        $this->PDO = new PHPDataObject();
    }
    // ID accessor method
    public function getId()
    {
        return $this->id;
    }
    // ID mutator method
    public function setId(int $id)
    {
        $this->id = $id;
    }
    // Plain Text accessor method
    public function getPlainText()
    {
        return $this->plainText;
    }
    // Plain Text mutator method
    public function setPlainText(string $plain_text)
    {
        $this->plainText = $plain_text;
    }
    // Cipher Text accessor method
    public function getCipherText()
    {
        return $this->cipherText;
    }
    // Cipher Text mutator method
    public function setCipherText(string $cipher_text)
    {
        $this->cipherText = $cipher_text;
    }
}
