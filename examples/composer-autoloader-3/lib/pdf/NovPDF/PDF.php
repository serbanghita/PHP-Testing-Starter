<?php
namespace NovPDF;

class PDF
{
	public function generateLocalPDF($html)
	{
		return uniqid().'.pdf';
	}
}