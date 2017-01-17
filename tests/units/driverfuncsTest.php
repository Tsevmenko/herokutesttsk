<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/driverfuncs.php";

class driverTest extends \PHPUnit_Framework_TestCase
{	
	private $datetime;
	private $address;
	private $coords;
	// DB part
	private $DBHost;
	private $DBName;
	private $DBusername;
	private $DBpassword;

	public function setUp()
	{
		$this->DBHost = "localhost";
		$this->DBName = "suzywong_bx";
		$this->DBusername = "root";
		$this->DBpassword = "";

		// инициализация
		global $USER;
		global $DB;

		$DB->Connect($this->DBHost, $this->DBName, $this->DBusername, $this->DBpassword);
		if(!$USER->IsAuthorized())
			$USER->Authorize(1);
	}

	/** 
		* @dataProvider addDriverRequestProvider
	*/

	// тестирование создания заявки на вызов водителя

	public function testAddDriverRequest($datetime, $address, $coords, $expected)
	{
		echo "<br/>Добавление заявки на вызов водителя: ";
		// конец инициализации
		$res = driverfuncs::addDriverRequest($datetime, $address, $coords, "Y");

		echo ($res["result"] == $expected) ? "Тест прошел<br/>" : "Тест не прошел<br/>";

		$this->assertEquals($res["result"], $expected);
	}

	public function addDriverRequestProvider()
	{
		return array(
			["30.12.2016 20:20:20", "Баженова, 47, 2 парадная", "50.21, 34.10", true],
			["", "Баженова, 47, 2 парадная", "50.21, 34.10", false],
			["30.12.2016 20:20:20", "", "50.21, 34.10", true],
			["30.12.2016 20:20:20", "", "", true],
		);
	}

	/** 
		* @dataProvider getDriverRequestsProvider
	*/

	// тестирование получения информации о всех вызовах водителей

    public function testGetDriverRequests($param, $expected)
    {
    	echo "<br/>Получения информации о всех вызовах водителей: ";
    	$res = driverfuncs::getDriverRequests($param);

    	if(count($res) > 0)
    		$result = true;
    	else 
    		$result = false;

    	echo ($expected == $res) ? "Тест прошел<br/>" : "Тест не прошел<br/>";

    	$this->assertEquals($expected, $result);
    }

    public function getDriverRequestsProvider()
	{
		return array(
			["", true], 
			[13, false], 
			[-1, false], 
			["Не принят", true], 
			["Принят водителем", true]
		);
	}

	/** 
		* @dataProvider acceptDriverRequestProvider
	*/

	// тестирование принятия вызова водителем
	public function testAcceptDriverRequest($requestId, $datetime, $expected)
	{
		echo "<br/>Принятие заявки: ";

		$res = driverfuncs::acceptDriverRequest($requestId, $datetime);

		echo ($expected == $res["result"]) ? "Тест прошел<br/>" : "Тест не прошел<br/>";

		$this->assertEquals($res["result"], $expected);
	}

	public function acceptDriverRequestProvider()
	{
		return array(
			["", "11.11.2011 11:11:11", false],
			[1551, "", true],
			[1551, "11.11.2011 11:11:11", true],
		);
	}

	/** 
		* @dataProvider rejectDriverRequestProvider
	*/

	// тестирование отклонения вызова водителя
	public function testRejectDriverRequest($requestId, $reason, $expected)
	{
		echo "<br/>Отклонение заявки: ";

		$res = driverfuncs::rejectDriverRequest($requestId, $reason);

		echo ($expected == $res["result"]) ? "Тест прошел<br/>" : "Тест не прошел<br/>";

		$this->assertEquals($res["result"], $expected);
	}

	public function rejectDriverRequestProvider()
	{
		return array(
			["", "Передумал", false],
			[1551, "Передумал", true],
			[1551, "", true],
		);
	}

	/** 
		* @dataProvider getRequestDataProvider
	*/

	// тестирование получения информации о вызове водителя
	public function testGetRequestData($param, $expected)
	{
		echo "<br/>Получение детальной информации о вызове водителя: ";

		$res = driverfuncs::getRequestData($param);
		
		echo ($expected == $res) ? "Тест прошел<br/>" : "Тест не прошел<br/>";
		if($res) $res = true;

		$this->assertEquals($res, $expected);
	}

	public function getRequestDataProvider()
	{
		return array(
			[-1, false],
			[1630, true],
		);
	}

	/** 
		* @dataProvider addDriverReceiptProvider
	*/

	// тестирование добавления накладной водителя (после забора вещей)
	public function testAddDriverReceipt($driver_request_id, $list_of_things, $expected)
	{
		echo "<br/>Добавление накладной водителя: ";
		$res = driverfuncs::addDriverReceipt($driver_request_id, $list_of_things);

		echo ($expected == $res["result"]) ? "Тест прошел<br/>" : "Тест не прошел<br/>";

		$this->assertEquals($res["result"], $expected);
	}

	public function addDriverReceiptProvider()
	{
		return array(
			[-1, "Брюки,Штанцы,Носочки женские шерстяные,Тапки-тряпки", false],
			[1630, "Брюки,Штанцы,Носочки женские шерстяные,Тапки-тряпки", true],
		);
	}
}
?>