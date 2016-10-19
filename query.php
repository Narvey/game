<?php //Call this the Model if you like, it should be the only file accessing the database (the tiny stuff in index is temporarily exempt).
class SQL
{
private static $instance;
private static $conn;

public static function getInstance()
{
    if (null === self::$instance) 
    {
        self::$instance = new self();
        self::$conn = new mysqli("localhost", "nkhx10ho_auto", "u70L-2r+i9", "nkhx10ho_game");
        if (self::$conn->connect_error) 
        {
            die("Connection failed: " . self::$conn->connect_error);
        }
        
    }
    
    return self::$instance;
}

protected function __construct()
{
}
public function __destruct()
{
self::$conn->close();
}

////////////////////////Query Functions/////////////////////////////

///getMapRange returns an array for a particular map section, generating any tiles that haven't been generated yet.
///Precondition: n1 is less than n2, w1 is less than w2
///Postcondition: a 2D array of tile objects is returned that looks like the requested map.
///	Note that the indices of the array are for puposes of printing and are NOT equal to 
///	n and w from the database. n2,w2 in the query becomes 0,0 in the printable array.
///Params:	n1/w1: the coords of the bottom right corner of the map area to retrieve
///			n2/w2: the coords of the second corner (upper left) to retrieve
function getMapRange($n1,$w1,$n2,$w2)
{
$mapWidth = $w2 - $w1 + 1;
$mapHeight = $n2 - $n1 + 1;

$query = "SELECT Map.*, Objects.id";
$query .= " FROM Map left outer join Objects on n = posN and w = posW";
$query .= " WHERE n BETWEEN " . $n1 . " and " . $n2 . " and w BETWEEN " . $w1 . " and " . $w2;
$res = self::$conn->query($query);
//TODO: check result for connection errors
$arr = [[]];
while ($row = $res->fetch_array(MYSQLI_ASSOC))
{
	$tile = new tile($row["n"],$row["w"],bin2hex($row["groundColor"]),$row["terrain"],$row["altitude"],$row["objectId"]);
	$arr[$n2 - $tile->getn()][$w2 - $tile->getw()] = $tile;
}
for ($y = 0; $y < $mapHeight; $y++)
{
	for ($x = 0; $x < $mapWidth; $x++)
	{
	$tile = $arr[$y][$x];
	if(!isset($tile))
	{
		//make a new tile and color it f0e68c (khaki)
		$tile = new tile($n2 - $y,$w2 - $x,"f0e68c") ;
		$arr[$y][$x] = $tile;
		$insert = "INSERT INTO Map (n,w,groundColor,terrain) VALUES({$tile->getn()},{$tile->getw()},X'{$tile->getgroundColor()}','{$tile->getterrain()}')";
		self::$conn->query($insert) or die("Map generation Error: " . $conn->error);
	}
	}
}
$res->free();
return $arr;
}

///getObject returns the robot, structure, etc. that has the given ID.
///Precondition: 
///Postcondition: 
///Params:	id: the id column of the Object you would like to look up.
function getObject($id)
{
	try
	{
		$result = self::$conn->query("SELECT id,posN,posW from Objects where id = $id")->fetch_array(MYSQLI_ASSOC);
	}
	catch (Exception $e)
	{
		return NULL;
	}
	if (isset($result))
	{
		switch ($result["className"])
		{
			case "robot":
				return new robot($result["id"],$result["posN"],$result["posW"]);
				break;
			default:
				return NULL;//TODO: do something more useful such as return a generic Object?
		}
	} else return NULL;
}

///getObject returns the robot, structure, etc. that has the given ID.
///Precondition: caller has validated that this object is moveable and can "make it" to the target space.
///Postcondition: re
///Params: 	obj: the id column of the Object you would like to move. TODO: change to accepting objects?
///			n,w: the coordinates of the target space (where to move TO).
function moveObject($obj,$n,$w){
	//attempt move if there isn't anything there.
	$result = self::$conn->query("UPDATE Map SET objectId='$obj' WHERE ");
	if(self::$conn->error) return self::$conn->error;
}

function insert() { $i=8; }//TODO: actually make this function?

}//end of class SQL

class tile
{
private $n;
private $w;
private $groundColor;
private $terrain;
private $altitude;
private $objectId;
private $object;

public function getn() {return $this->n;}
public function getw() {return $this->w;}
public function getgroundColor() {return $this->groundColor;}
public function getterrain() {return $this->terrain;}
public function getaltitude() {return $this->altitude;}

function tile ($n = 0, $w = 0, $groundColor = "f0e68c", $terrain = "plain", $altitude = 1, $objectId = NULL)
{
	$this->n = $n;
	$this->w = $w;
	$this->groundColor = $groundColor;
	$this->terrain = $terrain;
	$this->altitude = $altitude;
	if (!is_null($objectId)) $this->objectId = $objectId;
}

function getobject() //not your typical getter because it requires a query.
{
	if(isset($this->object)) return $this->object;
	if(isset($this->objectId)) return SQL::getInstance()->getObject($this->objectId);
	return NULL; //TODO: only if the query returned no rows. otherwise return appropriate object (robot, structure, etc.)
}

}//end of class tile

class robot
{
private $id;
private $token;//token here isn't necessarily correct, it is the one given by the user.
private $posN;
private $posW;

public function getposN() {return $this->posN;}
public function getposW() {return $this->posW;}

public function robot($id = NULL, $posN = NULL, $posW = NULL)
{
	if (is_null($id))
	{
		SQL::getInstance()->insert();//get the new ID from self::conn->insert_id();
		$id = NULL;//TODO: generate a new robot, save to DB.
	} /*else
	{
	this->id = $id;
	this->posN = $posN;
	this->posW = $posW;
	}*/
}

public function runCommand($command, ...$params)
{
	//TODO: I don't know right now!
	//but $params is passed as a variable-length argument list, so use it as an array. :)
}
}//end of class robot


/////// if this page is called directly with GET parameters.
$query = $_GET["query"];
if (!empty($query))
{
$c = new mysqli("localhost", "nkhx10ho_auto", "u70L-2r+i9", "nkhx10ho_game");

$result = $c->query($query);
$table = array();
if ($c->error) 
{
    die("SQL Error: " . $c->error);
} else 
{
while ($row = $result->fetch_row())
{
	var_dump($row);
	echo "<br>";
}
}
$c->close();
}
?>