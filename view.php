<html>

<body onload="scroll();">
	<table>

		<tr>
			<td>
			</td>
			<td>
				<a href="add.php"><button type="button">Add</button></a>
			</td>
		</tr>
		<tr>
			<td>
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


				\BlockChain\Utils::dumpBlockchain($blockchain);

				?></td>
			<td>
			</td>
		</tr>
		<tr>
			<td></td>
			<td> <a href="add.php"><button onclick="scroll();" type="button">Add</button></a>
			</td>
		</tr>

	</table>
</body>

</html>
<script>
	window.addEventListener('load', function() {
		scroll();
	});

	function scroll() {
		window.scrollTo(0, document.body.scrollHeight);
	}
</script>