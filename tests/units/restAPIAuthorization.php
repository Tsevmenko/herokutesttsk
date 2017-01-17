<?
echo $_SERVER["DOCUMENT_ROOT"] . "suzywong/authorization/login/authorization.php";
//require_once $_SERVER["DOCUMENT_ROOT"] . "suzywong/authorization/login/authorization.php";

class authorizationTest extends \PHPUnit_Framework_TestCase
{	
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
		* @dataProvider phoneProvider
	*/

	public function testCheckPhone($phone, $expected)
	{
		echo "<br/>Тестирование номера телефона '".$phone."': ";

		$res = authorization::checkPhone($phone);

		print_r($res);

		//echo ($res["result"] == $expected) ? "Тест прошел<br/>" : "Тест не прошел<br/>";

		//$this->assertEquals($res["result"], $expected);
	}

	public function phoneProvider()
	{
		return array(
			["some string", false],
			["00000000000", false],
			["72222222222", true],
			//["", true],
		);
	}
}
?>