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

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 20, 'FERRETERA EL FOCO', 0, 1, 'C'); 
$pdf->SetFont('helvetica', 14);

$pdf->SetFont('helvetica', '', 10);



$pdf->MultiCell(0, 0, '', 0, 'L');
$pdf->MultiCell(0, 0, '', 0, 'L');
$pdf->MultiCell(0, 0, '', 0, 'L');
$pdf->MultiCell(0, 0, '', 0, 'L');
$pdf->MultiCell(0, 0, '', 0, 'L');
$pdf->MultiCell(0, 0, '', 0, 'L');
$pdf->MultiCell(0, 0, '', 0, 'L');
$pdf->MultiCell(0, 0, '', 0, 'L');




$pdf->SetY(60);
// $pdf->MultiCell(0, 0, 'Folio fiscal: MASG680124B34', 0, 'L');
$pdf->SetX(115); // Ajusta manualmente la posición X para alinear a la derecha

$pdf->SetFont('', 'B', 10);
$pdf->Cell(47, 0, 'Codigo Postal, fecha :', 0, 0, 'L'); // Ancho de 60 para el primer Cell

$pdf->SetFont('', '', 10);
$pdf->Cell(0, 0, '36910 ' . $fecha, 0, 1, 'L');; // Ajusta el último parámetro a 1 para que avance a la siguiente línea

$pdf->SetX(115);
$pdf->SetFont('', 'B', 10);  // Ajusta manualmente la posición X para alinear a la derecha
$pdf->MultiCell(0, 0, 'RFC receptor:', 0, 'L');

$pdf->SetFont('', '', 10);
$pdf->SetX(115);
$pdf->SetFont('', 'B', 10); 
$pdf->MultiCell(0, 0, 'Nombre receptor:', 0, 'L');
$pdf->SetX(115);


$pdf->SetFont('', '', 10); 
$pdf->SetFont('', 'B', 10);
$pdf->Cell(40, 0, 'Efecto de comprobante:', 0, 0, 'L'); // Establece un ancho específico para la primera celda

$pdf->SetFont('', '', 10);

// Espacio entre las celdas
$pdf->Cell(5); // Ajusta el valor según el espacio deseado

$pdf->Cell(0, 0, ' Ingreso', 0, 1, 'L'); // Establece un ancho flexible para la segunda celda y usa '1' para forzar un salto de línea



$pdf->SetX(115);

$pdf->SetFont('', 'B', 10);

// Imprime el primer Cell
$pdf->Cell(0, 0, 'Regimen fiscal receptor:', 0, 0, 'L'); // El último 0 en el cuarto parámetro evita que se añada un salto de línea

$pdf->SetFont('', '', 10);

// Establece manualmente la posición X para el segundo Cell
$pdf->SetX($pdf->GetX() - 39); // Puedes ajustar el valor negativo según tus necesidades

// Imprime el segundo Cell
$pdf->Cell(0, 0, 'Incorporacion Fiscal', 0, 1, 'L');



$pdf->SetX(115);


$anchoPrimeraCelda = 40; // Define el ancho de la primera celda
$alturaPrimeraCelda = $pdf->GetY();
$pdf->SetFont('', 'B', 10);
$pdf->Cell($anchoPrimeraCelda, 0, 'Exportacion:', 0, 'L');
$pdf->SetFont('', '', 10);
$pdf->SetXY(100 + $anchoPrimeraCelda, $alturaPrimeraCelda); // Establece posición X e Y para la segunda celda
$pdf->Cell(0, 0, 'No aplica', 0, 'L');


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




<br><br><br>

		<tr>
			
		<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
				

					<br>
					Dirección: Calle Av Padre Hidalgo 224, Sta Ana Pacueco

				</div>


				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					
					Teléfono: 352 526 1470
					
					
				</div>
<br><br>
<table style="font-size:10px; padding:5px 10px;">
<tr>
<td style="width:200px; margin-bottom: 5px;">
<strong>RFC emisor:</strong>&nbsp;&nbsp;&nbsp;MASG680124B34
</td>

    </tr>
    <tr>
        <td style="width:200px; margin-bottom: 5px;"><strong>Nombre emisor:</strong>&nbsp;&nbsp;&nbsp; GRACIELA MARTINEZ SANDOVAL</td>
    </tr>
    <tr>
        <td style="margin-bottom: 50px;"><strong>RFC receptor:</strong> </td>
    </tr>
	<tr>
	<td style="margin-bottom: 70px;"><strong>Nombre receptor:</strong>&nbsp;&nbsp;&nbsp;"PUBLICO GENERAL" </td>
</tr>
    <tr>
        <td style="margin-bottom: 10px;"><strong>Codigo postal del receptor:</strong>&nbsp;&nbsp;&nbsp; 36910</td>
    </tr>
    <tr>
        <td style="margin-bottom: 5px;"><strong>Regimen fiscal receptor:</strong>&nbsp;&nbsp;&nbsp; Sin obligaciones fiscales</td>
    </tr>
    <tr>
        <td style="margin-bottom: 5px;"><strong>Uso CFDI:</strong>&nbsp;&nbsp;&nbsp; Sin efectos fiscales</td>
    </tr>
</table>
		





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

<table style="font-size:10px; padding:5px 10px; margin-bottom: -5px;">
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
		
		<td style="border: 1px solid #666; background-color:white; width:260px; text-align:center"><strong>Producto</strong></td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><strong>Cantidad</strong></td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"><strong>Valor Unit.</strong></td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"><strong>Valor Total</strong></td>

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


<table style="font-size:10px; padding:5px 10px; border-collapse: collapse;">

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
<BR><BR><BR><BR><BR><BR>


	<table style="font-size:10px; padding:5px 10px;">

		<tr>
<BR><BR>
			<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>

		</tr>
		
		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
			<strong>Neto:</strong>
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:right">
				$ $neto
			</td>

		</tr>

		<tr>

			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
			<strong>Impuesto:</strong>
			</td>
		
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $impuesto
			</td>

		</tr>

		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
			<strong>Total:</strong>
			</td>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
			<strong>$ $total</strong>
			</td>
			
		</tr>
		

<br><br><br><br><br><br><br><br><br><br>
		





	</table>

	<table style="font-size: 10px; padding: 5px 10px;">
   <BR><BR><BR><BR><BR>
    <!-- Nueva fila para alinear a la izquierda -->
    <tr>
	<td colspan="4" style="border: none; text-align: justify; padding-left: 10px;">
    <strong>Moneda:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Peso Mexicano<br>
    <strong>Forma de pago:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tarjeta de crédito<br>
    <strong>Método de pago:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pago en una sola exhibición<br>
    <strong>Condiciones de pago:</strong>&nbsp;&nbsp;&nbsp;CONTADO
</td>

    </tr>
    <!-- Resto de la segunda tabla -->
    <tr>
        <td></td> <!-- Espacio en blanco -->
        <td style="border-bottom: 1px solid #666; background-color: white; width: 100px; text-align: center"></td>
        <td style="border-bottom: 1px solid #666; color: #333; background-color: white; width: 100px; text-align: center"></td>
    </tr>
    <tr>

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