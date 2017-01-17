<?
$root = "/suzywong/";

CModule::IncludeModule("iblock");

require_once $_SERVER["DOCUMENT_ROOT"] . $root . "client/orders/pay/cloudpayments.php";

class CloudpaymentsTest extends \PHPUnit_Framework_TestCase
{
	private $test_cases;

	public function setUp()
	{
		$this->test_cases = array();

		$this->test_cases[] = array(
			"action" => "paywithcryptogram",
			"Name" => "123",
			"CardCryptogramPacket" => "014242424242311202Go93Dp7yA6FZrhcg2D+u/R8PwXbdyu9CR9Vu0MfDfdyakljkMdhuB9mnIWBJKiZv1VqLoM1+FL1gfbzNpApm06QFQebTTjAoo6LkRqS5Rm5l4yRI1jY4y80DrA6umu9Qv4KN4Inu8hrRHO791qExdT9OOhH70ffcqkS6tyqoTAvg9YpRJOc0g+NvIe9/vSDNQhEjBe5sXIspcUZ0WCHgb6CYOoLY/cpNsTDBL6UcuN6elwDpzNpcGENsHHVqzuJqH+eQyx0WRpwsUU6EFIZhEAuNjvd8yAbzknF1X9OqUkWnKTlgBUKRJlYzjLCnOoFPJBNVcdZSJ2tdmTnGvzVVWA==",
			"cardnumber" => "4242424242424242",
			"AUTOWITHDRAWAL" => "N"
		);

		$this->test_cases[] = array(
			"action" => "paywithcryptogram",
			"Name" => "123",
			"CardCryptogramPacket" => "015555554444311202GN27EgRarY/B98TiXu6e/URFob4Yp+v/2ejACOqJ6CN43N0RnuYdh/r+7t3+MRo5fdgyLwFCWtKy9a9VzXkWBGrA0dWNB1HGLEfsO+lHvbTASJUWmF7q1t3PohQRn4TUHOiGjJZF9VYHXZbHRIiX6N+1OO7jgw9IXU8oXI+f6aegi/ogUkSmrGo/grXu/BJl6pBIF3caWrcKLIElFNq9h0M/bKZYLsWfk4GTfCjaGts8HxXfcfbrcAk88KOf5C8fzTkcozVjRJdhipJCeG7JDFsGhD/RMAZLyif19evaOYQvdPHUrAZZjG7J2w0TVHf5Kyc7nDEHwVDgIdc0QynDXA==",
			"cardnumber" => "5555555555554444",
			"AUTOWITHDRAWAL" => "N"
		);

		$this->test_cases[] = array(
			"action" => "paywithcryptogram",
			"Name" => "123",
			"CardCryptogramPacket" => "014012881881311202il2Eq1z+HkH34zgWC81nXt5n95w6a6mozHihjoGbKcco67h8VgILk0pGlgpP5aDbV7JnLenxcRLEEy+bgfh1JJ7RfywqTaeSuu8rwfllBtH6ZRdKIIMLlma6ZdUfzTPx2HsHtSKN9aiO+lIjPbPwi74VlEFnQNxLw70Bx/H+pqEXgyJoNo+rvI4c//DLkqtJnu3OlOug2+6+4QjY5lgAcM+X/W/aDecJBUc21LDdLoWlviondbrlS5ySbnbX3wfy7sNKVzCUQ0MmkylDa8uml/PJHpiVugk4bNRskrwjRVBQyH5dvlvpMNar/+9bE6Tb5QZyT0UEGyAy61dn3489Pg==",
			"cardnumber" => "4012888888881881",
			"AUTOWITHDRAWAL" => "N"
		);

		$this->test_cases[] = array(
			"action" => "paywithcryptogram",
			"Name" => "123",
			"CardCryptogramPacket" => "014012881881191202Z1PDqs12d2ElfpzuP4E96eSMfJ8sGsYAV9HwWxDnxncyisJxubVAiRvVmvN+caEDIyUCaboqK3HCuo/d1+9q+vBWLw7U0nOI2A1sBQFiAnIyPJbke10gLQQxzlD3E+RSJhle/S6BhXvFNrcDZTE651/XHN88FJduuI4VdjeVcVf0RejqmbxScdwS6+98iHv0u176SHfGCpPrSMZnTz7Cby3Q4Rjc8/Z/bof8HBNhL3BTzBpY6z/YmX+UT1MsNFtqIoeFBP2V5sn6msqRFe/p8Pa8/I4BKvMTLP80kq7DVnbxODYx05GjxD93iJJS7e0BtfljaST9Sso5K3tVfMYFeg==",
			"cardnumber" => "5105105105105100",
			"AUTOWITHDRAWAL" => "N"
		);

		$this->test_cases[] = array(
			"action" => "paywithcryptogram",
			"Name" => "123",
			"CardCryptogramPacket" => "014111111111901202b4bL/m4fv+vXOSeqplEMEel12tmwcXfI8vESjk2erwVSp2TkXVB7huagfKUFlipjgVyspnRcABCjmxGyRN7jNYXMe4T4bYX1pLZ+GbsaiJJThJjboC0mKFd4n6Ils+eqCAdQO7AzFl2RdHmy1yt/Nu0TIvRDyHRK3RVjQBSkkbHtMUrg65E6ltwj2ztPKw3n9vicMncWbSgDElligY23+kW3ka1mfQoaraM6q1FJJH9QZ4k6QGq0rqJTXQVDkfgWPZ3ZHZ5uUun2J4ILls7MechxG7hh1mBRUvX/lyrfyFu3SRKZ/8N3Q3dS7/enE3Zd+6crox6bymzgXvqYihia+w==",
			"cardnumber" => "4111111111111111",
			"AUTOWITHDRAWAL" => "N"
		);

		$this->test_cases[] = array(
			"action" => "paywithcryptogram",
			"Name" => "123",
			"CardCryptogramPacket" => "015200828210311202VQnwdCh/8caeSOdUhxHtcPbI0b5vpPcD/sanRHAO8Op7BXlvSlZqAuuZoxMd6Hoh4I27IOCNn5+MakBFDVUBpwYO2yvMhEQ5IO2EpuRFf2UymXQeFN3bmPy/uXgbANR14mrM9/m9Vdaj3FN1ZGBDU/xjF4WVZ8kiAHXF4jUai2/zyk5+XL562xlCg+xSQveADRlyFZctdA8Dfw4ID3lQx27tpracOalnA4rJHAH594rcbuavkYyIBEpjwRS3gshC9ijMrkzBoADTbr26SQkXR8+F82vElIoKHWiqk3g3VShBDXWo23gX1joh6WGX2ygNyvY6DPeo0nZQbMuhe1onLA==",
			"cardnumber" => "5200828282828210",
			"AUTOWITHDRAWAL" => "N"
		);

		$this->test_cases[] = array(
			"action" => "paywithcryptogram",
			"Name" => "123",
			"CardCryptogramPacket" => "014000055556341202hGoUrwieeSqy8eKZBKRz448KhYcJfLgHeTP38Qw4eFpFdBmHdgYT75A+V5QfrvlBHyjxbTXCpK+ID1hAleCt/XQpsmeNAFZ2uwwMrtQz/hG9V6e7fXIfXrbs2rSmc5tKlph/rzb9jycu9taFPNGpXCy9apNNoXO7xP4HFZIHKZ2pnDhnslxZWFSKROgelfAI9qlZM4hc6e1zAIh0aMr/Dbt0bH9QC88JZTFHxy7ysbbTvoKrGbkdvaL6Thxm+PHjb5752WH1guClrZh6f+6ZoXe98LLaPDADUa63m/9YrBsWKZ33UmQP8ZYj5PiA2jCa3uuTaD0+DfPJ5MOflEkWaw==",
			"cardnumber" => "4000056655665556",
			"AUTOWITHDRAWAL" => "N"
		);

		$this->test_cases[] = array(
			"action" => "paywithcryptogram",
			"Name" => "123",
			"CardCryptogramPacket" => "015404000043311202gVMxQmbNzF1e+IT9X1MXoRBTimtlzW6Ct+xQQwd1sqmTPycCPsv8ZksKFdRrOZV3yzc91ro5ID5EXtRXbUI857NT1Wworx8xMUNr5oKFHyXGyqsrz8+sAIhjQLy7RpWGp3Ta41lQI54I8W2oAv1+Dnc47XD7bjjMfcA5puOEArRqi+EZEuBX0TGQyjA+Gnv9T4fans2hbRAF8cSUE6UxIZecNPiYCTipM0VarExeOQ+evmM1dYkjsSmnJMksN03l25EnjHxsL8+0WXA4j8mQsEnWHt0e7CNx2G4afP2E28IJM2FmaLW2Ral3Q+oarBJjKTz6PpofPSFfW2UZ7bpc3A==",
			"cardnumber" => "5404000000000043",
			"AUTOWITHDRAWAL" => "N"
		);

		$this->test_cases[] = array(
			"cardnumber" => "5404000000000фыв43",
		);

		$this->test_cases[] = array(
			"cardnumber" => "540400000000043",
		);

		$this->test_cases[] = array(
			"cardnumber" => "540400000000000043",
		);
	}
	public function testIncomingData()
	{
		echo "---------- CloudPayments tests part ----------<br/><br/>";

		echo "Тестирование входящих данных...<br/>";
		$res = "";
		foreach($this->test_cases as $k => $v)
		{
			$str = 'In My Cart : 11 12 items';
			preg_match_all('!\d+!', $v['cardnumber'], $res);
			if(strlen($res[0][0]) != 16)
				echo $v["cardnumber"]." - Ошибка в номере карты<br/>";
			else
				echo $v["cardnumber"]." - Данные корректны<br/>";
		}
		echo "Тест проведен<br/><br/>";
		$this->assertEquals(true, true);
	}
	// Карта Visa с 3-D Secure Success Success
	public function testVisaWith3DS()
	{
		echo "Карта Visa с 3-D Secure Результат - Успешный результат...<br/>";
		echo $this->test_cases[0]['cardnumber'].'<br/>';
		$data = array(
			"Amount" => 1,
			"InvoiceId" => 1001,
			"Description" => "Тест оплаты услуг SuzyWong - Visa c 3-D Secure",
			"AccountId" => '1',
			"Name" => $this->test_cases[0]["Name"],
			"CardCryptogramPacket" => $this->test_cases[0]["CardCryptogramPacket"],
		);
		$result = cloudpayments::directPayment($data);

		if(!$result["success"])
			$result = $this->cloudpayments3DSHandler($result["TransactionId"], $result["PaReq"]);
		else
			$result = false;

		if($result == true) echo "Тест прошел</br/><br/>";
		else echo "Тест не прошел<br/><br/>";

		$this->assertEquals($result, true);
	}
	// Карта MasterCard с 3-D Secure Success Success
	public function testMCWith3DS()
	{
		echo "Карта MasterCard с 3-D Secure Результат - Успешный результат...<br/>";
		echo $this->test_cases[1]['cardnumber'].'<br/>';
		$data = array(
			"Amount" => 1,
			"InvoiceId" => 1001,
			"Description" => "Тест оплаты услуг SuzyWong - MasterCard с 3-D Secure",
			"AccountId" => '1',
			"Name" => $this->test_cases[1]["Name"],
			"CardCryptogramPacket" => $this->test_cases[1]["CardCryptogramPacket"],
		);
		$result = cloudpayments::directPayment($data);

		if(!$result["success"])
			$result = $this->cloudpayments3DSHandler($result["TransactionId"], $result["PaReq"]);
		else
			$result = false;

		if($result == true) echo "Тест прошел</br/><br/>";
		else echo "Тест не прошел<br/><br/>";

		$this->assertEquals($result, true);
	}
	// Карта Visa с 3-D Secure "Недостаточно средств"
	public function testVisaWith3DSFailure()
	{
		echo "Карта Visa с 3-D Secure Результат - недостаточно средств...<br/>";
		echo $this->test_cases[2]['cardnumber'].'<br/>';
		$data = array(
			"Amount" => 1,
			"InvoiceId" => 1001,
			"Description" => "Тест оплаты услуг SuzyWong - Visa с 3-D Secure",
			"AccountId" => '1',
			"Name" => $this->test_cases[2]["Name"],
			"CardCryptogramPacket" => $this->test_cases[2]["CardCryptogramPacket"],
		);
		$result = cloudpayments::directPayment($data);
		
		if(!$result["success"])
			$result = $this->cloudpayments3DSHandler($result["TransactionId"], $result["PaReq"]);
		else
			$result = false;

		if($result == false) echo "Тест прошел</br/><br/>";
		else echo "Тест не прошел<br/><br/>";

		$this->assertEquals($result, false);
	}
	// Карта MasterCard с 3-D Secure "Недостаточно средств"
	public function testMCWith3DSFailure()
	{
		echo "Карта MasterCard с 3-D Secure Результат - недостаточно средств...<br/>";
		echo $this->test_cases[3]['cardnumber'].'<br/>';
		$data = array(
			"Amount" => 1,
			"InvoiceId" => 1001,
			"Description" => "Тест оплаты услуг SuzyWong - MasterCard с 3-D Secure",
			"AccountId" => '1',
			"Name" => $this->test_cases[3]["Name"],
			"CardCryptogramPacket" => $this->test_cases[3]["CardCryptogramPacket"],
		);
		$result = cloudpayments::directPayment($data);
		
		if(!$result["success"])
			$result = $this->cloudpayments3DSHandler($result["TransactionId"], $result["PaReq"]);
		else
			$result = false;

		if($result == false) echo "Тест прошел</br/><br/>";
		else echo "Тест не прошел<br/><br/>";

		$this->assertEquals($result, false);
	}
	// Карта Visa без 3-D Secure "Успешный результат"
	public function testVisaWithout3DS()
	{
		echo "Карта Visa без 3-D Secure Успешный результат...<br/>";
		echo $this->test_cases[4]['cardnumber'].'<br/>';
		$data = array(
			"Amount" => 1,
			"InvoiceId" => 1001,
			"Description" => "Тест оплаты услуг SuzyWong - Visa без 3-D Secure",
			"AccountId" => '1',
			"Name" => $this->test_cases[4]["Name"],
			"CardCryptogramPacket" => $this->test_cases[4]["CardCryptogramPacket"],
		);
		$result = cloudpayments::directPayment($data);

		if($result["Success"] == true)
			$result = true;
		else
			$result = false;

		if($result == true) echo "Тест прошел</br/><br/>";
		else echo "Тест не прошел<br/><br/>";

		$this->assertEquals($result, true);
	}
	// Карта MasterCard без 3-D Secure "Успешный результат"
	public function testMCWithout3DS()
	{
		echo "Карта MasterCard без 3-D Secure Успешный результат...<br/>";
		echo $this->test_cases[5]['cardnumber'].'<br/>';
		$data = array(
			"Amount" => 1,
			"InvoiceId" => 1001,
			"Description" => "Тест оплаты услуг SuzyWong - MasterCard без 3-D Secure",
			"AccountId" => '1',
			"Name" => $this->test_cases[5]["Name"],
			"CardCryptogramPacket" => $this->test_cases[5]["CardCryptogramPacket"],
		);
		$result = cloudpayments::directPayment($data);

		if($result["Success"] == true)
			$result = true;
		else
			$result = false;

		if($result == true) echo "Тест прошел</br/><br/>";
		else echo "Тест не прошел<br/><br/>";

		$this->assertEquals($result, true);
	}
	// Карта Visa без 3-D Secure "Недостаточно средств на карте"
	public function testVisaWithout3DSNoMoney()
	{
		echo "Карта Visa без 3-D Secure Недостаточно средств на карте...<br/>";
		echo $this->test_cases[6]['cardnumber'].'<br/>';
		$data = array(
			"Amount" => 1,
			"InvoiceId" => 1001,
			"Description" => "Тест оплаты услуг SuzyWong - Visa без 3-D Secure",
			"AccountId" => '1',
			"Name" => $this->test_cases[6]["Name"],
			"CardCryptogramPacket" => $this->test_cases[6]["CardCryptogramPacket"],
		);
		$result = cloudpayments::directPayment($data);

		if(substr($result["CardHolderMessage"], 1, -10) == "Недостаточно средств на карте")
		{
			echo substr($result["CardHolderMessage"], 1, -10).'</br>';
			$result = true;
		}
		else
			$result = false;

		if($result == true) echo "Тест прошел</br/><br/>";
		else echo "Тест не прошел<br/><br/>";

		$this->assertEquals($result, true);
	}
	// Карта MasterCard без 3-D Secure "Недостаточно средств на карте"
	public function testMCWithout3DSNoMoney()
	{
		echo "Карта MasterCard без 3-D Secure Недостаточно средств на карте...<br/>";
		echo $this->test_cases[7]['cardnumber'].'<br/>';
		$data = array(
			"Amount" => 1,
			"InvoiceId" => 1001,
			"Description" => "Тест оплаты услуг SuzyWong - MasterCard без 3-D Secure",
			"AccountId" => '1',
			"Name" => $this->test_cases[7]["Name"],
			"CardCryptogramPacket" => $this->test_cases[7]["CardCryptogramPacket"],
		);
		$result = cloudpayments::directPayment($data);

		if(substr($result["CardHolderMessage"], 1, -10) == "Недостаточно средств на карте")
		{
			echo substr($result["CardHolderMessage"], 1, -10).'</br>';
			$result = true;
		}
		else
			$result = false;

		if($result == true) echo "Тест прошел</br/><br/>";
		else echo "Тест не прошел<br/><br/>";

		echo "---------- END CloudPayments tests part ----------<br/>";
		$this->assertEquals($result, true);
	}
	private function cloudpayments3DSHandler($TransactionId, $PaRes)
	{
		$data = array(
			"TransactionId" => $TransactionId,
			"PaRes" => substr($PaRes, 1, -1)
		);
		$result = cloudpayments::securePayment($data);

		if($result["Success"] == "true") return true;
		else 
		{
			echo "Ответ " . substr($result["CardHolderMessage"], 1, -10).'<br/>';
			return false;
		}
	}
}