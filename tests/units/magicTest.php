<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/magic.php";

class ProductsTest extends \PHPUnit_Framework_TestCase
{
	private $phone;
	private $id;
	private $DBHost;
	private $DBName;
	private $DBusername;
	private $DBpassword;

	public function setUp()
	{
		$this->phone = "4959981958";
		$this->id = "41008";
		$this->DBHost = "localhost";
		$this->DBName = "suzywong_bx";
		$this->DBusername = "root";
		$this->DBpassword = "";
	}

	public function testFindUserByPhoneRemoutedly($expected)
	{
		echo "---------- MAGIC tests part ----------<br/><br/>";

		echo "Ищем пользователя с телефоном: " . $this->phone . "</br>";
		$res = magic::findUserByPhoneRemoutedly($this->phone);
		if($res[0]->ClientID &&
			$res[0]->ClientName &&
			$res[0]->SecondName &&
			$res[0]->Phones &&
			$res[0]->AccountID && count($res) > 0)
			$res = true;
		else 
			$res = false;
		echo "Найдено " . count($res) . " пользователей.<br/>";
		$this->assertEquals($res, true);
	}

	public function testFindUserByIdRemoutedly($expected)
	{
		echo "Ищем пользователя с ID: " . $this->id . "</br>";
		$res = magic::findUserByIdRemoutedly($this->id);
		if($res[0]->ClientID &&
			$res[0]->ClientName &&
			$res[0]->SecondName &&
			$res[0]->Phones &&
			$res[0]->AccountID && count($res) > 0)
			$res = true;
		else 
			$res = false;
		echo "Найдено " . count($res) . " пользователей.<br/>";
		$this->assertEquals($res, true);
	}

	/** 
		* @dataProvider updateUserProvider
	*/

	public function testUpdateUser($userId, $name, $secondName, $phone)
	{
		echo "<br/>Тестируем обновление данных пользователя с данными:</br>";
		echo "UserID: ".$userId." Name: ".$name." SecondName: ".$secondName." Phone: ".$phone."<br/>"; 
		global $DB;
		$DB->Connect($this->DBHost, $this->DBName, $this->DBusername, $this->DBpassword);
		$arParams["SELECT"] = array("UF_MAGIC_ID");
		$arParams["FIELDS"] = array("ID", "NAME");

		$filter = array("ID" => $userId);
		$rsUsers = CUser::GetList(($by="id"), ($order="asc"), $filter, $arParams);

		while($user = $rsUsers->GetNext()) { break; }

		if($user == '')
		{
			if($userId == -1) $res = true;
			else $res = false;
		}
		else
		{
			$res = magic::updateUser($user["UF_MAGIC_ID"], $name, $secondName, $phone);
			if($res["result"] == "success")
				$res = true;
			else
			{
				$res = false;
			}
		}
		if($res) echo "Тест прошел<br/>";
		else echo "Тест не прошел<br/>";
		$this->assertEquals($res, true);
	}

	public function updateUserProvider()
	{
		return array(
			[1, '','second', "72222222221", "Address"],
			[-1, 'Name','', "72222222221", "Address"],
		);
	}

	public function testPricelistExist($userId)
	{
		echo "<br/>Тестируем наличие прайслиста<br/>";
		global $DB;
		$DB->Connect($this->DBHost, $this->DBName, $this->DBusername, $this->DBpassword);
		$arParams["SELECT"] = array("UF_MAGIC_ID");
		$arParams["FIELDS"] = array("ID", "NAME");

		$filter = array("ID" => $userId);
		$rsUsers = CUser::GetList(($by="id"), ($order="asc"), $filter, $arParams);

		while($user = $rsUsers->GetNext()) { break; }

		if($user == '')
		{
			if($userId == -1) $res = true;
			else $res = false;
		}
		else
		{
			$res = magic::getPriceList("", $userId);
			if($res["result"] == "success")
			{
				echo "Тест прошел<br/>";
				$res = true;
			}
			else
			{
				echo "Тест не прошел<br/>";
				$res = false;
			}
		}

		$this->assertEquals($res, true);
	}

	/** 
		* @dataProvider pricelistStructureProvider
	*/

	public function testPricelistStructureParser($pricelistId)
	{
		echo "<br/>Тестируем парсинг прайслиста<br/>";
		global $DB;
		$DB->Connect($this->DBHost, $this->DBName, $this->DBusername, $this->DBpassword);
		$res = magic::getPricelistStructure($pricelistId);
		if($res["ID"] == "") $res = false;
		else $res = true;

		$this->assertEquals($res, true);
	}

	public function pricelistStructureProvider()
	{
		return array([1]);
	}



	//echo "---------- END MAGIC tests part ----------<br/>";
}
?>