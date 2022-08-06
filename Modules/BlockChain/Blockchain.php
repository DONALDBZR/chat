<?php

namespace BlockChain;

class Blockchain
{
    const DEFAULT_VERSION = '1';

    const MAGIC_NUMBER = 0x7FFFFFFF;

    const HASH_LENGTH = 32;

    const HEADER_LENGTH = 77;

    private $name;

    private $version;

    private $blocksDir;

    private $blocksFile;

    public function __construct(array $settings)
    {
        $this->setUp($settings)->initializeFiles();
    }

    private function setUp(array $settings)
    {
        if (!isset($settings['name']) || empty($settings['name'])) {
            throw new \InvalidArgumentException("Invalid 'name'");
        }
        if (!isset($settings['blocks_dir']) || !is_writable($settings['blocks_dir'])) {
            throw new \LogicException("Invalid 'blocks_dir'");
        }

        $this->name      = $settings['name'];
        $this->version   = $settings['version'] ?? self::DEFAULT_VERSION;
        $this->blocksDir = $settings['blocks_dir'];

        return $this;
    }

    private function initializeFiles()
    {
        $this->blocksFile = $this->blocksDir . DS . "{$this->name}.{$this->version}.dat";
        if (!file_exists($this->blocksFile)) {
            fclose(fopen($this->blocksFile, 'wb'));
        }

        if (!is_writable($this->blocksFile)) {
            throw new \UnexpectedValueException("Can't create blocks file at '{$this->blocksFile}'", 1);
        }
    }

    public function addBlock(Block $block)
    {
        $previousBlock = $this->getLastBlock();
        if ($previousBlock instanceof Block) {
            $block->setPreviousHash($previousBlock->getBlockHash());
        }

        $block->generateBlockHash();

        $fo = fopen($this->blocksFile, 'ab');
        fwrite($fo, pack('V', self::MAGIC_NUMBER), 4);
        fwrite($fo, chr($this->version), 1);
        fwrite($fo, pack('V', $block->getTimestamp()), 4);
        fwrite($fo, hex2bin($block->getPreviousHash()), self::HASH_LENGTH);
        fwrite($fo, hex2bin($block->getBlockHash()), self::HASH_LENGTH);
        fwrite($fo, pack('V', $block->getDataLength()), 4);
        fwrite($fo, $block->getData(), $block->getDataLength());
        fclose($fo);

        return $block;
    }

    public function getLastBlock()
    {
        clearstatcache();

        if (filesize($this->blocksFile) == 0) {
            return null;
        }

        $fo = fopen($this->blocksFile, 'rb');
        fseek($fo, -113, SEEK_END);

        $header = fread($fo, self::HEADER_LENGTH);
        if (unpack('V', substr($header, -4, 4))[1] > Block::BLOCK_DATA_LIMIT) {
            fseek($fo, 0);
            $header = fread($fo, self::HEADER_LENGTH);
        }

        $values = Utils::unpackValues($header);
        return (new Block(fread($fo, $values['dataLength'])))
            ->setTimestamp($values['timestamp'])
            ->setPreviousHash($values['previousHash'])
            ->setBlockHash($values['blockHash'])
            ->setDataLength($values['dataLength']);
    }

    public function generateGenesisBlock()
    {
        $genesis = new Block('Genesis Block');
        $genesis->generateBlockHash();
        return $this->addBlock($genesis);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getBlocksDir()
    {
        return $this->blocksDir;
    }

    public function getBlocksFile()
    {
        return $this->blocksFile;
    }
}
