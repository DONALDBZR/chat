<?php

namespace BlockChain;

class Utils
{

    public static function dumpBlockchain(Blockchain $blockchain)
    {
        clearstatcache();

        $sizeFile  = filesize($blockchain->getBlocksFile());
        $fo        = fopen($blockchain->getBlocksFile(), 'rb');
        fseek($fo, 0);

        $index = 1;
        while (ftell($fo) < $sizeFile) {

            $header = fread($fo, Blockchain::HEADER_LENGTH);
            $values = self::unpackValues($header);
            $data   = fread($fo, $values['dataLength']);

            echo "Block #" . $index++ . "<br>";
            echo "Timestamp:     " . date("d/m/Y H:i:s", $values['timestamp']) . "(" . $values['timestamp'] . ")<br>";
            echo "Previous Hash: " . $values['previousHash'] . "<br>";
            echo "Block Hash:    " . $values['blockHash'] . "<br>";
            echo "Data Length:   " . $values['dataLength'] . "<br>";
            echo "MESSAGE: " .  json_decode(($data))->message . "<br><br>";
            echo "-------------------<br><br>";

        }

        fclose($fo);

        return true;
    }

    public static function unpackValues($header)
    {
        return [
            'magicNumber'  => unpack('V', substr($header, 0, 4))[1],
            'version'      => ord($header[4]),
            'timestamp'    => unpack('V', substr($header, 5, 4))[1],
            'previousHash' => bin2hex(substr($header, 9, Blockchain::HASH_LENGTH)),
            'blockHash'    => bin2hex(substr($header, 41, Blockchain::HASH_LENGTH)),
            'dataLength'   => unpack('V', substr($header, -4, 4))[1],
        ];
    }
}
