<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/magic.php";
require_once $_SERVER["DOCUMENT_ROOT"] . $root . "/suzywong/client/orders/pay/cloudpayments.php";

class order
{
	public $PointID;
    public $OrderID;
    public $BookedDateTime; 
	public $FullOrderSum;
	public $RealizationDateTime;
	public $FullPayment;
	public $PaymentName;
	public $Completed;
	public $CompletedName;
	public $ClientID;
	public $PreOrder;
	public $EnterDateTime;
	public $VoidID;
	public $CurrentPointID;
	public $CurrentPointName; 
	public $DebtSum;

	function __construct($PointID, $OrderID, $BookedDateTime, 
		$FullOrderSum, $RealizationDateTime, $FullPayment, $PaymentName, 
		$Completed, $CompletedName, $ClientID, $EnterDateTime, $VoidID, 
		$CurrentPointID, $CurrentPointName, $DebtSum)
	{
		$this->PointID = $PointID;
		$this->OrderID = $OrderID;
		$this->BookedDateTime = $BookedDateTime;
		$this->FullOrderSum = $FullOrderSum;
		$this->RealizationDateTime = $RealizationDateTime;
		$this->FullPayment = $FullPayment;
		$this->PaymentName = $PaymentName;
		$this->Completed = $Completed;
		$this->CompletedName = $CompletedName;
		$this->ClientID = $ClientID;
		$this->PreOrder = $PreOrder;
		$this->EnterDateTime = $EnterDateTime;
		$this->VoidID = $VoidID;
		$this->CurrentPointID = $CurrentPointID;
		$this->CurrentPointName = $CurrentPointName;
		$this->DebtSum = $DebtSum;
	}
}
 
class scenarioTest extends \PHPUnit_Framework_TestCase
{
	private $DBHost;
	private $DBName;
	private $DBusername;
	private $DBpassword;

	public function setUp()
	{
		$mock = new order(1,2,3,4,5);

		$this->phone = "4959981958";
		$this->id = "41008";
		$this->DBHost = "localhost";
		$this->DBName = "suzywong_bx";
		$this->DBusername = "root";
		$this->DBpassword = "";
		global $DB;
		$DB->Connect($this->DBHost, $this->DBName, $this->DBusername, $this->DBpassword);
	}

	/** 
		* @dataProvider balanceHistoryProvider
	*/

	public function testBalanceHistory($price, $cardnumber, $crypto, $expected)
	{
		echo "<br/>История баланса: ";

		$data = array(
			"Amount" => $price,
			"InvoiceId" => 1001,
			"Description" => "Тест оплаты услуг SuzyWong - Visa без 3-D Secure",
			"AccountId" => '1',
			"Name" => "Cardholder",
			"CardCryptogramPacket" => $crypto,
		);

		$result = cloudpayments::directPayment($data);

		if($result["Success"] == "true")
		{
			if(floatval($result["PaymentAmount"]) == floatval($price))
			{
				echo "Тест прошел.<br/>";
				$result = true;
			}
			else
			{
				echo "Сумма платежа не равна сумме заказа.<br/>";
				$result = false;
			}
		}
		else
		{
			echo "Ошибка запроса платежа.<br/>";
			$result = false;
		}

		$this->assertEquals($result, $expected);
	}

	public function balanceHistoryProvider()
	{
		return array(["1000", "4111111111111111", "014111111111901202b4bL/m4fv+vXOSeqplEMEel12tmwcXfI8vESjk2erwVSp2TkXVB7huagfKUFlipjgVyspnRcABCjmxGyRN7jNYXMe4T4bYX1pLZ+GbsaiJJThJjboC0mKFd4n6Ils+eqCAdQO7AzFl2RdHmy1yt/Nu0TIvRDyHRK3RVjQBSkkbHtMUrg65E6ltwj2ztPKw3n9vicMncWbSgDElligY23+kW3ka1mfQoaraM6q1FJJH9QZ4k6QGq0rqJTXQVDkfgWPZ3ZHZ5uUun2J4ILls7MechxG7hh1mBRUvX/lyrfyFu3SRKZ/8N3Q3dS7/enE3Zd+6crox6bymzgXvqYihia+w==", true]);
	}

	/** 
		* @dataProvider pricelistProvider
	*/

	public function testPricelist($userId, $expected_price, $expected_result)
	{
		echo "<br/>Прайслист<br/>";
		$cUser = new CUser; 
		// подтягиваем номер телефона пользователя
		$filter = Array("ID" => $userId);
		$dbUsers = $cUser->GetList(($by="id"), ($order="asc"), $filter);
		while ($arUser = $dbUsers->Fetch()) { break; }
		if($arUser == "") 
		{
			echo "Не найден пользователь с ID ".$userId.'<br/>';
			$result = false;
		}
		else
		{
			// подтягиваем пользователя по номеру телефона
			$res = magic::findUserByPhoneRemoutedly($phone);
			// подтягиваем прайслист пользователя
			$res = magic::getPriceList($res["PriceListID"]);
			if($res["pricelistid"] != "" && $res["result"] == "success")
			{
				// получаем структуру прайслиста
				$res = magic::getPricelistStructure($res["PriceListID"]);
				
				if(floatval($expected_price) == floatval($res["GROUPS"][765]['ELEMENTS'][1]['POSITION_BASE_PRICE']))
				{
					echo "Тест прошел<br/>";
					$result = true;
				}
				else
				{
					echo "Цена не соответствует ожидаемой<br/>";
					$result = false;
				}
				// если клиента нет, то
			}
			else
			{
				echo "Ошибка присвоения прайслиста клиенту.<br/>";
				$result = false;
			}
			
		}
		$this->assertEquals($expected_result, $result);
	}

	public function pricelistProvider()
	{
		return array([125, 600, true], [0, 600, false]);
	}

	/** 
		* @dataProvider receiptsOrdersProvider
	*/

	public function testReceiptsOrders($userId, $expected_result)
	{
		echo "<br/>Квитанции/Заказы<br/>";
		$cUser = new CUser;
		// подтягиваем номер телефона пользователя
		$filter = Array("ID" => $userId);
		$dbUsers = $cUser->GetList(($by="id"), ($order="asc"), $filter);
		while ($arUser = $dbUsers->Fetch()) { break; }
		
		if($arUser == "") 
		{
			echo "Не найден пользователь с ID ".$userId.'<br/>';
			$result = false;
		}
		else
		{	
			// подтягиваем квитанции по номеру телефона
			$orders = magic::getUsersReceipts($arUser['PERSONAL_PHONE']);
			
			// создаем квитанцию через mock
			$mock = $this->getMock("order", array(), array(16, 81295, "2016-12-08T15:55:22", 0, "Не оплачена",
				0, "Не оплачена", 168452, '', "2016-12-08T15:55:22", 0, 16, "Тест приложения", 0));
			
			$result = true;
			foreach($orders as $k => $v)
			{
				if($v->BookedDateTime == $mock->BookedDateTime && 
					$v->FullOrderSum == $mock->FullOrderSum)
				{
					echo "Новая квитанция дублирует существующую.<br/>";
					$result = false;
				}
			}
		}
		echo ($expected_result == $result) ? "Тест прошел<br/>" : "Тест не прошел<br/>";
		$this->assertEquals($expected_result, $result);
	}

	public function receiptsOrdersProvider()
	{
		return array([125, true], [0, false]);
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
			{
				// запрашиваем данные с магии и сравниваем с тем, что отправляли на изменение
				$res = magic::findUserByIdRemoutedly($user["UF_MAGIC_ID"]);

				if($res[0]->ClientName == $name &&
					$res[0]->SecondName == $secondName /*&&
					$res[0]->Phones == $phone*/)
					$res = true;
				else
					$res = false;

				if($res) echo "YYY";
				else echo "NNN";
			}
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
			[1, 'Анастасия','', "72222222221", "Address"],
			[1, '','Павловна', "72222222221", "Address"],
			[-1, 'Name','', "72222222221", "Address"],
		);
	}

	// карты
	/** 
		* @dataProvider cardAddProvider
	*/
	public function testCardAdd($card, $crypto, $type, $maincard, $expected_result)
	{
		echo "<br/>Добавляем карту: " . $card . "</br>";
		global $DB;
		$DB->Connect($this->DBHost, $this->DBName, $this->DBusername, $this->DBpassword);
		
		$data = array(
			"Amount" => 1,
			"InvoiceId" => 1001,
			"Description" => "Тест оплаты услуг SuzyWong - Visa без 3-D Secure",
			"AccountId" => '1',
			"Name" => "Cardholder",
			"CardCryptogramPacket" => $crypto,
		);

		$result = cloudpayments::directPayment($data);

		if($result["Success"] == "true")
		{
			if(floatval($result["PaymentAmount"]) == 1)
			{
				// добавляем карту к тестовому пользователю
				$USER_ID = 125;// 125 - ID тестового пользователя miniuser
			    $user = cloudpayments::getUser($USER_ID); 
			    $card_ids = array();
			    $card_exist = false;
			    foreach ($user["BANK_CARDS"] as $key => $value) {
			      	if($value["NAME"] == $number)
			      	{
			        	$card_exist = true;
			        	break;
			      	}
			      	$card_ids[] = $value["ID"];
			    }
			    // card already exist and we dont create new row in DB
			    if(!$card_exist)
			    {
			      	$id = cloudpayments::saveCardData($card, $token, $type);
			      	$card_ids[] = $id;
			      	// attach new card to current user
				  	$user = new CUser;
				  	$user->Update($USER_ID, Array("UF_BANKCARDS" => $card_ids));
				  	echo "Карта добавлена.<br/>";
			    }
			    // делаем карту основной
			    if($maincard)
			    {
			    	CIBlockElement::SetPropertyValuesEx($id, false, array("MAIN" => 9)); // 9 - да, 10 - нет
			    	echo "Сделали карту основной.<br/>";
			    }
			    else
			    {
			    	CIBlockElement::SetPropertyValuesEx($id, false, array("MAIN" => 10)); // 9 - да, 10 - нет
			    	echo "Карта не основная.<br/>";
			    }
			    
				echo "Тест прошел.<br/>";
				$result = true;
			}
			else
			{
				echo "Сумма платежа не равна сумме заказа.<br/>";
				$result = false;
			}
		}
		else
		{
			echo "Ошибка запроса платежа.<br/>";
			$result = false;
		}

		$this->assertEquals($result, $expected_result);
	}

	public function cardAddProvider()
	{
		return array(["4111111111111111", "014111111111901202b4bL/m4fv+vXOSeqplEMEel12tmwcXfI8vESjk2erwVSp2TkXVB7huagfKUFlipjgVyspnRcABCjmxGyRN7jNYXMe4T4bYX1pLZ+GbsaiJJThJjboC0mKFd4n6Ils+eqCAdQO7AzFl2RdHmy1yt/Nu0TIvRDyHRK3RVjQBSkkbHtMUrg65E6ltwj2ztPKw3n9vicMncWbSgDElligY23+kW3ka1mfQoaraM6q1FJJH9QZ4k6QGq0rqJTXQVDkfgWPZ3ZHZ5uUun2J4ILls7MechxG7hh1mBRUvX/lyrfyFu3SRKZ/8N3Q3dS7/enE3Zd+6crox6bymzgXvqYihia+w==", 8, false, true],
					 ["5200828282828210", "015200828210311202hgxkRcR41SxOTN6pLpe410qHH5PFL5t2VDH0ld2NBpyHhFxmbDuTnkncAOm4a6Q/DYVDtmoRMt772d9LhgmEs+Wv5vyHjL7Gge31qyDVpzaeg9h8Zyl0rRlU5YFS5aW99ObgKhPZrwHLwkeAylFWvngnr1CJyBdThM0VQ0/zTdE45eiopdsHiIhWCgkNVO5YNYz35Cm8InBgSW3U9jtPNWKJUkpWEGbsXGhGKy9i1fi/X+Rr+BStcyuUa3MVCvDQ/t8rUxyBCh8meCMIStcsJVzfWiCQfJDuiIE3qh0mbOY0BYAKf3+f3KJl9rLjDua2GaBdRAR+D9A5HSBuhTwsyw==", 7, true, true]);
	}

	public function testCardAddClearData()
	{
		// получаем все карты miniadmin
		$res = cloudpayments::getUser(125);
		foreach ($res["BANK_CARDS"] as $k => $v) {
			if($v["NAME"] == "5200828282828210" &&
				$v["PROPERTY_MAIN_ENUM_ID"] == 9)
			{
				echo "<br/>Номер основной карты: ".$v["NAME"]."<br/>";
				echo "Тест прошел<br/>";
				$result = true;
				break;
			}
			else 
				$result = false;
		}

		// очищаем карты miniadmin
		foreach($res["UF_BANKCARDS"] as $k => $v)
			// удаляем все карты miniadmin
			CIBlockElement::Delete($v);
		
		$this->assertEquals($result, true);
	}

	public function testEventAdd()
	{
		CModule::IncludeModule("iblock");
		$USER_ID = 125;
		$notification_count = 0;
		$new_notification_count = 0;
		// получаем текущее количество уведомлений пользователя
		$arSelect = Array("ID", "NAME", "IBLOCK_ID", "PROPERTY_USER");
		$arFilter = Array("IBLOCK_ID" => 16, "PROPERTY_USER" => $USER_ID);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNext())
		{
		  $notification_count++;
		}
		echo "<br/>Текущее количество уведомлений пользователя: ".$notification_count."<br/>";
		$ids = array();
		$el = new CIBlockElement;

		$PROP = array();
		$PROP["USER"] = $USER_ID;

		$arLoadProductArray = Array(
			"IBLOCK_SECTION_ID" => false,
			"IBLOCK_ID"      => 16,
			"PROPERTY_VALUES"=> $PROP,
			"NAME"           => "Test",
		);

		$ids[] = $el->Add($arLoadProductArray);
		$ids[] = $el->Add($arLoadProductArray);

		// получаем новое количество уведомлений пользователя
		$arSelect = Array("ID", "NAME", "IBLOCK_ID", "PROPERTY_USER");
		$arFilter = Array("IBLOCK_ID" => 16, "PROPERTY_USER" => $USER_ID);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNext())
		{
		  $new_notification_count++;
		}
		echo "<br/>Новое количество уведомлений пользователя: ".$new_notification_count."<br/>";
		foreach($ids as $k => $v)
			// удаляем все карты miniadmin
			CIBlockElement::Delete($v);
		if($notification_count + 2 == $new_notification_count)
		{
			$result = true;
			echo "</br>Тест успешно прошел.";
		}
		else
		{
			$result = false;
			echo "</br>Тест НЕ прошел.";
		}

		$this->assertEquals($result, true);
	}
}
?>