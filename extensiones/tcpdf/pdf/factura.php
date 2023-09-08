<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "codigo";
$valorVenta = $this->codigo;

$respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);

$fecha = substr($respuestaVenta["fecha"],0,-8);
$productos = json_decode($respuestaVenta["productos"], true);
$neto = number_format($respuestaVenta["neto"],2);
$impuesto = number_format($respuestaVenta["impuesto"],2);
$total = number_format($respuestaVenta["total"],2);

//TRAEMOS LA INFORMACIÓN DEL CLIENTE

$itemCliente = "id";
$valorCliente = $respuestaVenta["id_cliente"];

$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR

$itemVendedor = "id";
$valorVendedor = $respuestaVenta["id_vendedor"];

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();
$pdf->SetMargins(10, 10, 10); 





$imagenURL = 'https://scontent.fmlm3-1.fna.fbcdn.net/v/t39.30808-6/296442149_5267192306697873_5685084400771114106_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=a2f6c7&_nc_eui2=AeGvnHIx_mNSBgyrNZj8uMmA7NB_MyUCc4_s0H8zJQJzj2MGlitOWL71cFCT2gDEFnogymsNBtluHey8EdKNUYdR&_nc_ohc=__vbVW1GYbAAX_IWvcG&_nc_oc=AQn8Nlj6FJ3kkeLzwrxKWU8vG0YOPACfUZEvKM7oQmBNmW6dcb0OFb7M1amwKw31L2aLCy-oXdBv0rdBPTA1-MvS&_nc_ht=scontent.fmlm3-1.fna&oh=00_AfCmGXIwkCv-rHAmUPZ2dOYphHkunEQoBtkf9kTjkAYWuQ&oe=64FF713E';

$pdf->Image($imagenURL, 10, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
	<tr>
    <td>
        <img src="https://scontent.fmlm3-1.fna.fbcdn.net/v/t39.30808-6/296442149_5267192306697873_5685084400771114106_n.jpg" width="30" height="30">
    </td>
</tr>
<tr>
    <td style="text-align:right;">
        <strong>FERRETERA EL FOCO</strong>
    </td>
</tr>


<br><br><br>

		<tr>
			
		<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
				

					<br>
					Dirección: Calle Av Padre Hidalgo 224, Sta Ana Pacueco

				</div>


				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					
					Teléfono: 352 526 1470
					
					
				</div>

		<p><strong>RFC emisor:</strong> <span style="font-size:10px;">MASG680124B34</span></p>
<p><strong>Nombre emisor:</strong> <span style="font-size:3px">GRACIELA MARTINEZ SANDOVAL</span></p>
<p><strong>RFC receptor:</strong> <span style="font-size:6.5px;">“PUBLICO EN GENERAL”</span></p>
<p><strong>Codigo postal del receptor:</strong> <span style="font-size:6.5px;">36910</span></p>
<p><strong>Regimen fiscal receptor:</strong> <span style="font-size:6.5px;">Sin obligaciones fiscales</span></p>
<p><strong>Uso CFDI:</strong> <span style="font-size:6.5px;">Sin efectos fiscales</span></p>

		


<br><br>

<p><strong>Folio fiscal::</strong> <span style="font-size:6.5px;">MASG680124B34</span></p>
<p><strong>Codigo Postal, fecha :</strong> <span style="font-size:6.5px"> 36910  $fecha</span></p>
<p><strong>RFC receptor:</strong> <span style="font-size:6.5px;"></span></p>
<p><strong>Nombre receptor:</strong> <span style="font-size:6.5px;">“PUBLICO EN GENERAL”</span></p>
<p><strong>Efecto de comprobante:</strong> <span style="font-size:6.5px;">Ingreso</span></p>
<p><strong>Regimen fiscal receptor:</strong> <span style="font-size:6.5px;">Incorporacion Fiscal</span></p>
<p><strong>Exportancion:</strong> <span style="font-size:6.5px;">No aplica</span></p>


			<td style="background-color:white; width:140px">
				
				

			</td>

			<td style="background-color:white; width:140px">

				
				
			</td>

			<td style="background-color:white; width:110px; text-align:center; color:red"><br><br>FACTURA N.<br>$valorVenta</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------

$bloque2 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>
		

	</table>




	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:390px">

				Cliente: $respuestaCliente[nombre]

			</td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
			
				Fecha: $fecha

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:540px">Vendedor: $respuestaVendedor[nombre]</td>

		</tr>

		<tr>
		
		<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Cantidad</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Unit.</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Total</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($productos as $key => $item) {

$itemProducto = "descripcion";
$valorProducto = $item["descripcion"];
$orden = null;

$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);

$valorUnitario = number_format($respuestaProducto["precio_venta"], 2);

$precioTotal = number_format($item["total"], 2);

$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">
				$item[descripcion]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$item[cantidad]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$valorUnitario
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$precioTotal
			</td>


		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

// ---------------------------------------------------------

$bloque5 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>

			<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>

		</tr>
		
		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				Neto:
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $neto
			</td>

		</tr>

		<tr>

			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				Impuesto:
			</td>
		
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $impuesto
			</td>

		</tr>

		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				Total:
			</td>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $total
			</td>

		</tr>

<br><br><br><br><br><br><br><br><br><br>
		





	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');



// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

//$pdf->Output('factura.pdf', 'D');
$pdf->Output('factura.pdf');

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();

?>