<?php

require_once '../config/db.php';
require_once 'libraries/fpdf/fpdf.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
    "SELECT * FROM shipments WHERE id='$id'");

$shipment = mysqli_fetch_assoc($query);

$pdf = new FPDF();
$pdf->AddPage();

/* COLORS */
$pdf->SetFillColor(15, 23, 42);
$pdf->SetTextColor(255,255,255);

/* HEADER */
$pdf->SetFont('Arial','B',20);
$pdf->Cell(190,20,'NexFreight Shipment Invoice',0,1,'C',true);

$pdf->Ln(10);

/* RESET COLOR */
$pdf->SetTextColor(0,0,0);

/* SHIPMENT INFO */
$pdf->SetFont('Arial','B',14);

$pdf->Cell(95,12,'Tracking Number:',1,0);
$pdf->SetFont('Arial','',14);
$pdf->Cell(95,12,$shipment['tracking_number'],1,1);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(95,12,'Sender Name:',1,0);
$pdf->SetFont('Arial','',14);
$pdf->Cell(95,12,$shipment['sender_name'],1,1);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(95,12,'Receiver Name:',1,0);
$pdf->SetFont('Arial','',14);
$pdf->Cell(95,12,$shipment['receiver_name'],1,1);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(95,12,'Origin:',1,0);
$pdf->SetFont('Arial','',14);
$pdf->Cell(95,12,$shipment['origin'],1,1);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(95,12,'Destination:',1,0);
$pdf->SetFont('Arial','',14);
$pdf->Cell(95,12,$shipment['destination'],1,1);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(95,12,'Shipping Method:',1,0);
$pdf->SetFont('Arial','',14);
$pdf->Cell(95,12,$shipment['shipping_method'],1,1);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(95,12,'Current Location:',1,0);
$pdf->SetFont('Arial','',14);
$pdf->Cell(95,12,$shipment['current_location'],1,1);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(95,12,'Shipment Status:',1,0);
$pdf->SetFont('Arial','',14);
$pdf->Cell(95,12,$shipment['shipment_status'],1,1);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(95,12,'Shipment Date:',1,0);
$pdf->SetFont('Arial','',14);
$pdf->Cell(95,12,$shipment['shipment_date'],1,1);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(95,12,'Estimated Delivery:',1,0);
$pdf->SetFont('Arial','',14);
$pdf->Cell(95,12,$shipment['estimated_delivery'],1,1);

$pdf->Ln(20);

/* FOOTER MESSAGE */
$pdf->SetFont('Arial','I',12);

$pdf->MultiCell(
    190,
    10,
    "Thank you for choosing NexFreight Logistics. This shipment document serves as an official shipment confirmation and tracking invoice."
);

$pdf->Ln(15);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,'Authorized By NexFreight Logistics',0,1,'R');

$pdf->Output();

?>