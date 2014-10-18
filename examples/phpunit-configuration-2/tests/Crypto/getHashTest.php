<?php
namespace tests\Crypto;

class Crypto_getInstance extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test description:
	 * will go through 100 runs
	 * each run will generate a random 10 char string and will store the time difference for the method to return the hash for each algorithm
	 * in the end the lower score will be displayed along with the algorithm
	 * 
	 * @medium
	 */
	public function testPerformanceComparissonBetweenAlgosUsingRandom10CharStrings()
	{
		$algos = hash_algos();
		$resultsTime = array();
		$expected = 'md5';

		for ($i=0; $i < 10000; $i++) { 
			$random = substr(str_shuffle('ABCDEFGHIJKLMNO1234567890'), 0, 10);

			foreach ($algos as $algorithm) {
				$starttime = microtime(true);
				$result = \Crypto::getHash($random, $algorithm);
				$deltatime = microtime(true) - $starttime;

				if (!isset($resultsTime[$algorithm])) {
					$resultsTime[$algorithm] = 0;
				}

				$resultsTime[$algorithm] += $deltatime;
			}
		}

		asort($resultsTime);
		$resultsTime = array_reverse($resultsTime);
		$keys = array_keys($resultsTime);

		// this only proves that in this case md5 is faster.
		// If you tweak the number of runs and the random string then other results will be obtained.
		$this->assertEquals($expected, end($keys));
	}
}