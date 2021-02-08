<?php

class ManejadorBD {

	private $db;
	private $host;
	private $user;
	private $pass;
	private $result;
	private $id_table;

	function __construct() {
		$this->db = 'bgu9smpsgbze7uldszfh';
		$this->host = 'bgu9smpsgbze7uldszfh-mysql.services.clever-cloud.com';
		$this->user = 'u5hxsa95ooee2c9t';
		$this->pass = 'XKkP2VXnLok5u4Dh5ipd';

		$this->result = new \stdClass();
		$this->result->code = 200;
		$this->result->msg = 'Success';
		$this->result->output = array();
	}

	private function open() {
		$link = mysqli_connect($this->host, $this->user, $this->pass, $this->db) or die('Error connecting to DB');
		return $link;
	}

	private function close($link) {
		return mysqli_close($link);
	}

	public function showAll($table) {
		try {
			$link = $this->open();

			$qry = "SELECT * FROM ".$table;

			$r = mysqli_query($link, $qry);

			while( $result[] = mysqli_fetch_array( $r, MYSQLI_ASSOC ) );

			foreach ($result as $value) {
				if($value) {
					array_push($this->result->output, $value);
				}
			}

			$this->close($link);
		} catch (Exception $e) {
			$this->result->code = 500;
			$this->result->msg = 'Failed: '.$e;
		}

		return $this->result;
	}

	public function getCatalogo() {
		try {
			$link = $this->open();

			$qry = "SELECT P.id_pelicula,P.nombre_pelicula,P.duracion_minutos,P.categoria,P.fecha_estreno,G.genero,P.director,P.Sinopsis FROM peliculas P INNER JOIN generos G ON P.id_genero = G.id_genero";

			$r = mysqli_query($link, $qry);

			while( $result[] = mysqli_fetch_array( $r, MYSQLI_ASSOC ) );

			foreach ($result as $value) {
				if($value) {
					array_push($this->result->output, $value);
				}
			}

			$this->close($link);
		} catch (Exception $e) {
			$this->result->code = 500;
			$this->result->msg = 'Failed: '.$e;
		}

		return $this->result;
	}


	public function findByID($id,$table) {
		try {
			$link = $this->open();
			
			if($table == "usuarios"){
				$id_table = "usuario";
			}
			else if($table == "funciones"){
				$id_table = "funcion";
			} 
			else if($table == "boletos"){
				$id_table = "boleto";
			} 
			else if($table == "generos"){
				$id_table = "genero";
			} 
			else if($table == "peliculas"){
				$id_table = "pelicula";
			} 
			else if($table == "salas"){
				$id_table = "sala";
			} 
			else if($table == "sucursales"){
				$id_table = "sucursal";
			} 

			$qry = "SELECT * FROM ".$table." WHERE id_".$id_table." = ".$id;

			$r = mysqli_query($link, $qry);

			while( $result[] = mysqli_fetch_array( $r, MYSQLI_ASSOC ) );

			foreach ($result as $value) {
				if($value) {
					array_push($this->result->output, $value);
				}
			}

			$this->close($link);
		} catch (Exception $e) {
			$this->result->code = 500;
			$this->result->msg = 'Failed: '.$e;
		}

		return $this->result;
	}

	public function findUser($usuario,$clave) {
		try {
			$link = $this->open();
			
			//$qry = "SELECT * FROM usuarios WHERE usuario = '".$usuario."' AND contrasenia = MD5('".$clave."')";
			$qry = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contrasenia=MD5('$clave')";

			$r = mysqli_query($link, $qry);
			
			while( $result[] = mysqli_fetch_array( $r, MYSQLI_ASSOC ) );

			foreach ($result as $value) {
				if($value) {
					array_push($this->result->output, $value);
				}
			}

			$this->close($link);
		} catch (Exception $e) {
			$this->result->code = 500;
			$this->result->msg = 'Failed: '.$e;
		}

		return $this->result;
	}
		
	public function findByQuery($qry) {
		try {
			$link = $this->open();

			$r = mysqli_query($link, $qry);
			
			while( $result[] = mysqli_fetch_array( $r, MYSQLI_ASSOC ) );

			foreach ($result as $value) {
				if($value) {
					array_push($this->result->output, $value);
				}
			}

			$this->close($link);
		} catch (Exception $e) {
			$this->result->code = 500;
			$this->result->msg = 'Failed: '.$e;
		}

		return $this->result;
	}

	public function findHistorial($id_user) {
		try {
			$link = $this->open();

			$qry="SELECT B.id_boleto AS numero_boleto, B.asiento, P.nombre_pelicula, F.dia, F.hora_inicio, SL.nombre AS nombre_sala, S.nombre AS nombre_sucursal FROM boletos B INNER JOIN funciones F ON B.id_funcion = F.id_funcion INNER JOIN peliculas P ON F.id_pelicula = P.id_pelicula INNER JOIN salas SL ON F.id_sala = SL.id_sala INNER JOIN sucursales_has_funciones SHF ON SHF.id_funcion = F.id_funcion INNER JOIN sucursales S ON S.id_sucursal = SHF.id_sucursal WHERE B.id_usuario = $id_user GROUP BY B.id_boleto ORDER BY B.id_boleto";

			$r = mysqli_query($link, $qry);
			
			while( $result[] = mysqli_fetch_array( $r, MYSQLI_ASSOC ) );

			foreach ($result as $value) {
				if($value) {
					array_push($this->result->output, $value);
				}
			}

			$this->close($link);
		} catch (Exception $e) {
			$this->result->code = 500;
			$this->result->msg = 'Failed: '.$e;
		}

		return $this->result;
	}

	public function findHorarios($id_pelicula) {
		try {
			$link = $this->open();
			$qry = "SELECT F.id_funcion, S.id_sucursal, P.nombre_pelicula,F.dia, F.hora_inicio ,sl.nombre AS nombre_sala, F.precio, S.nombre AS nombre_sucursal FROM sucursales_has_funciones shf INNER JOIN sucursales S ON S.id_sucursal = shf.id_sucursal INNER JOIN funciones F ON shf.id_funcion = F.id_funcion INNER JOIN salas sl ON F.id_sala = sl.id_sala INNER JOIN peliculas P ON P.id_pelicula = F.id_pelicula WHERE P.id_pelicula = $id_pelicula";
			$r = mysqli_query($link, $qry);
			
			while( $result[] = mysqli_fetch_array( $r, MYSQLI_ASSOC ) );

			foreach ($result as $value) {
				if($value) {
					array_push($this->result->output, $value);
				}
			}

			$this->close($link);
		} catch (Exception $e) {
			$this->result->code = 500;
			$this->result->msg = 'Failed: '.$e;
		}

		return $this->result;
	}

	public function buyTicket($id_funcion,$id_sucursal,$id_usuario,$asiento) {
		try {
			$link = $this->open();

			$qry = "INSERT INTO boletos VALUES(NULL,$id_funcion,$id_sucursal,$id_usuario,NULL,TRUE)";

			$r = mysqli_query($link, $qry);
			
			while( $result[] = mysqli_fetch_array( $r, MYSQLI_ASSOC ) );

			foreach ($result as $value) {
				if($value) {
					array_push($this->result->output, $value);
				}
			}

			$this->close($link);
		} catch (Exception $e) {
			$this->result->code = 500;
			$this->result->msg = 'Failed: '.$e;
		}

		return $this->result;
	}

	

}

?>