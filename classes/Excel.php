<?php

class Excel
{
    public $excelobj;

    public function __construct($excelobj)
    {
        $this->excelobj = $excelobj;
    }
        
    public function set_stock_header()
    {
        $this->excelobj->getActiveSheet()->setCellValue("A" . "1", "السمك");
        $this->excelobj->getActiveSheet()->setCellValue("B" . "1", "نوع الزجاج");
        $this->excelobj->getActiveSheet()->setCellValue("C" . "1", "العرض");
        $this->excelobj->getActiveSheet()->setCellValue("D" . "1", "الطول");
        $this->excelobj->getActiveSheet()->setCellValue("E" . "1", "الكمية");
        $this->excelobj->getActiveSheet()->setCellValue("F" . "1", "المتر المربع");
        $this->excelobj->getActiveSheet()->setCellValue("G" . "1", "اخر تحديث");
    }


    public function set_operation_header()
    {
        $this->excelobj->getActiveSheet()->setCellValue("A" . "1", "القسم");
        $this->excelobj->getActiveSheet()->setCellValue("B" . "1", "القطعة");
        $this->excelobj->getActiveSheet()->setCellValue("C" . "1", "العميل");
        $this->excelobj->getActiveSheet()->setCellValue("D" . "1", "سمك");
        $this->excelobj->getActiveSheet()->setCellValue("E" . "1", "الطول");
        $this->excelobj->getActiveSheet()->setCellValue("F" . "1", "العرض");
        $this->excelobj->getActiveSheet()->setCellValue("G" . "1", "المتر");
        $this->excelobj->getActiveSheet()->setCellValue("H" . "1", "عدد الكسر");
        $this->excelobj->getActiveSheet()->setCellValue("I" . "1", "الكسر");
        $this->excelobj->getActiveSheet()->setCellValue("J" . "1", "الشغل");
        $this->excelobj->getActiveSheet()->setCellValue("K" . "1", "الطلبية");
        $this->excelobj->getActiveSheet()->setCellValue("L" . "1", "اللون");
        $this->excelobj->getActiveSheet()->setCellValue("M" . "1", "تاريخ التشغيل");
        $this->excelobj->getActiveSheet()->setCellValue("N" . "1", "تاريخ الانتاج");
        $this->excelobj->getActiveSheet()->setCellValue("O" . "1", "وقت الانتاج");
        $this->excelobj->getActiveSheet()->setCellValue("P" . "1", "المنتج");
        $this->excelobj->getActiveSheet()->setCellValue("Q" . "1", "التفاصيل");
        $this->excelobj->getActiveSheet()->setCellValue("R" . "1", "نوع");
    }

    public function set_scratch_header()
    {
        $this->excelobj->getActiveSheet()->setCellValue("A" . "1", "القسم");
        $this->excelobj->getActiveSheet()->setCellValue("B" . "1", "المتر المربع");
        $this->excelobj->getActiveSheet()->setCellValue("C" . "1", "طول");
        $this->excelobj->getActiveSheet()->setCellValue("D" . "1", "عرص");
        $this->excelobj->getActiveSheet()->setCellValue("E" . "1", "سبب الكسر");
        $this->excelobj->getActiveSheet()->setCellValue("F" . "1", "المتسبب");
        $this->excelobj->getActiveSheet()->setCellValue("G" . "1", "القسم من النظام");
        $this->excelobj->getActiveSheet()->setCellValue("H" . "1", "المتسبب من النظام");
        $this->excelobj->getActiveSheet()->setCellValue("I" . "1", " السمك");

        $this->excelobj->getActiveSheet()->setCellValue("J" . "1", "رقم القطعة");
    }


    public function set_salesreport_header()
    {
        $this->excelobj->getActiveSheet()->setCellValue("A" . "1", "العميل");
        $this->excelobj->getActiveSheet()->setCellValue("B" . "1", "العميلية");
        $this->excelobj->getActiveSheet()->setCellValue("C" . "1", "البون");
        $this->excelobj->getActiveSheet()->setCellValue("D" . "1", "العدد");
        $this->excelobj->getActiveSheet()->setCellValue("E" . "1", "الامتار");
        $this->excelobj->getActiveSheet()->setCellValue("F" . "1", "التخانة");
        $this->excelobj->getActiveSheet()->setCellValue("G" . "1", "اللون");
        $this->excelobj->getActiveSheet()->setCellValue("H" . "1", "النوع");
        $this->excelobj->getActiveSheet()->setCellValue("I" . "1", " التاريخ");
        $this->excelobj->getActiveSheet()->setCellValue("J" . "1", " التشغيل");
    }

    public function set_salesreportdetails_header()
    {
        $this->excelobj->getActiveSheet()->setCellValue("A" . "1", "العميل");
        $this->excelobj->getActiveSheet()->setCellValue("B" . "1", "العميلية");
        $this->excelobj->getActiveSheet()->setCellValue("C" . "1", "البون");
        $this->excelobj->getActiveSheet()->setCellValue("D" . "1", "العدد");
        $this->excelobj->getActiveSheet()->setCellValue("E" . "1", "الطول");
        $this->excelobj->getActiveSheet()->setCellValue("F" . "1", "العرض");
        $this->excelobj->getActiveSheet()->setCellValue("G" . "1", "الامتار");
        $this->excelobj->getActiveSheet()->setCellValue("H" . "1", "التخانة");
        $this->excelobj->getActiveSheet()->setCellValue("I" . "1", "اللون");
        $this->excelobj->getActiveSheet()->setCellValue("J" . "1", "النوع");
        $this->excelobj->getActiveSheet()->setCellValue("K" . "1", "ملاحظات 1");
        $this->excelobj->getActiveSheet()->setCellValue("L" . "1", "ملاحظات 2");
        $this->excelobj->getActiveSheet()->setCellValue("M" . "1", " التشغيل");
        $this->excelobj->getActiveSheet()->setCellValue("N" . "1", " التاريخ");
        $this->excelobj->getActiveSheet()->setCellValue("O" . "1", " نوع التشغيل");
    }


    public function set_late_delivery_header()
    {
        $this->excelobj->getActiveSheet()->setCellValue("A" . "1", "العميل");
        $this->excelobj->getActiveSheet()->setCellValue("B" . "1", "رقم القطعة");
        $this->excelobj->getActiveSheet()->setCellValue("C" . "1", "تاريخ التسليم");
        $this->excelobj->getActiveSheet()->setCellValue("D" . "1", "طول");
        $this->excelobj->getActiveSheet()->setCellValue("E" . "1", "عرض");
        $this->excelobj->getActiveSheet()->setCellValue("F" . "1", "سمك");
        $this->excelobj->getActiveSheet()->setCellValue("G" . "1", "لون");
        $this->excelobj->getActiveSheet()->setCellValue("H" . "1", "طباعة");
        $this->excelobj->getActiveSheet()->setCellValue("I" . "1", "مسطح");
        $this->excelobj->getActiveSheet()->setCellValue("J" . "1", "سنفرة");
        $this->excelobj->getActiveSheet()->setCellValue("K" . "1", "تخليع");
        $this->excelobj->getActiveSheet()->setCellValue("L" . "1", "التفاصيل");
        $this->excelobj->getActiveSheet()->setCellValue("M" . "1", "تقطيع");
        $this->excelobj->getActiveSheet()->setCellValue("N" . "1", "شطف");
        $this->excelobj->getActiveSheet()->setCellValue("O" . "1", "فرن");
        $this->excelobj->getActiveSheet()->setCellValue("P" . "1", "توريد");
        $this->excelobj->getActiveSheet()->setCellValue("Q" . "1", "تسليم");
    }
}
