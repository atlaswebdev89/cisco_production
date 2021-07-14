<?php


namespace Wifi;

class ExcelReports
{
    protected $model;
    protected $ArrayData = [];
    protected $garant;
    public function __construct($model)
    {
        $this->model = $model;
        $this->garant = '100';
    }

    public  function getExcel ($request, $response, $args) {

            // Создаем объект класса PHPExcel
            $xls = new \PHPExcel();
            // Устанавливаем индекс активного листа
            $xls->setActiveSheetIndex(0);
            // Получаем активный лист
            $aSheet = $xls->getActiveSheet();
            // Подписываем лист
            $aSheet->setTitle('Отчет CiscoWifi');

            //ШАПКА ОТЧЕТА ПО CISCO WIFI
            $aSheet->setCellValue("A1",'Квартальный справка-отчет о показателях качества услуги "Предоставление в пользование сети  Wi-Fi" Брестского ЗУЭС за 3 квартал  2019 года');
            $aSheet->mergeCells('A1:H1');
            // Шрифт Times New Roman
            $aSheet->getDefaultStyle()->getFont()->setName('Times New Roman');
            // Размер шрифта 18
            $aSheet->getDefaultStyle()->getFont()->setSize(12);
        
            //Жирный 
            $aSheet->getStyle("A1")->getFont()->setBold(true);
           
            //Высота строк
            $aSheet->getRowDimension('1')->setRowHeight(30);
            $aSheet->getRowDimension('2')->setRowHeight(70);
            $aSheet->getRowDimension('3')->setRowHeight(20);
                     
            $aSheet->setCellValue("A2",' № п/п');  
            $aSheet->getColumnDimension('A')->setWidth(5); 
            $aSheet->mergeCells('A2:A3');

            $aSheet->setCellValue("B2",'Заказчик точек доступа, N точек');
            $aSheet->getColumnDimension('B')->setWidth(70);         
            $aSheet->mergeCells('B2:B3');
            
            $aSheet->getColumnDimension('C')->setWidth(12);           
                $aSheet->setCellValue("C2",'Пропускная способность, Рi');
                $aSheet->mergeCells('C2:C3');
            $aSheet->getColumnDimension('D')->setWidth(12); 
                $aSheet->setCellValue("D2",'Время восстановления связи,   мин');
                $aSheet->mergeCells('D2:D3');
            
            $aSheet->setCellValue("E2",'Коэффициент восстановления связи');
            $aSheet->getColumnDimension('E')->setWidth(10);
            $aSheet->mergeCells('E2:G2');

            $aSheet->getStyle("E3:G3")->getFont()->setBold(true);
                $aSheet->setCellValue("E3",'N');          
                $aSheet->setCellValue("F3",'N заяв.');                               
                $aSheet->setCellValue("G3",'К вос.');   
                      
            $aSheet->setCellValue("H2", 'Коэффициент готовности соединения с сетью Интернет (для  заказчика), Кг (%)');
                $aSheet->getColumnDimension('H')->setWidth(20);
                $aSheet->mergeCells('H2:H3');
    
            //Параметры для ПЕЧАТИ
            // Формат
            $aSheet->getPageSetup()->SetPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
 
            // Ориентация
            // ORIENTATION_PORTRAIT — книжная
            // ORIENTATION_LANDSCAPE — альбомная
            $aSheet->getPageSetup()->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $aSheet->getPageSetup()->setScale(87);
               
            // Поля
            $aSheet->getPageMargins()->setTop(0.2);
            $aSheet->getPageMargins()->setRight(0.2);
            $aSheet->getPageMargins()->setLeft(0.6);
            $aSheet->getPageMargins()->setBottom(0.6);
          
            // Нижний колонтитул
            $aSheet->getHeaderFooter()->setOddFooter('&L&B CiscoWifi &R Страница &P из &N');
            //--------------------------------------------------------------//

            //Получаем данные из БД по всем точкам и формируем массив для отчета

            //Список всех организаций
            $bussinnes = $this->model->getBusinessForSelect();
            //Получение всех точек для отчета
            $points = $this->model->getDataPoints();

            //Формирование массива с данными точек. Массив содежржит массивы точек объединенных по организациям 
            foreach ($bussinnes as $key=>$item) {
                $j=0;
                foreach ($points as $point) {
                    if ($point['id_business'] == $item['id']){
                            $this->ArrayData[$key][$j]['point'] = $item['name'].'  '.$point['address'];
                            $this->ArrayData[$key][$j]['speed'] = $point['speed_download'].'/'.$point['speed_upload'];
                            $j++;
                    }
                }
            }
            //Заполнение Excel документа данными точек с раннее сформированного массива
            $startLine = 4;  $i = 1;
            foreach ($this->ArrayData as $items){               
                $j =0;
                foreach ($items as $item) {
                        $aSheet->setCellValue("A".$startLine, $i);
                        $aSheet->setCellValue("B".$startLine, $item['point']);
                        $aSheet->setCellValue("C".$startLine, $item['speed']);
                        $i++; $j++;
                        //Высота строки 
                        $aSheet->getRowDimension($startLine)->setRowHeight(30);
                        $startLine++;
                }
                $start = $startLine-$j;
                $aSheet->setCellValue("H".$start, $this->garant);
                //Объединение ячеек при двух и более точек одной фирмы
                if ($j > 1) {
                    $aSheet->mergeCells('H'.$start.':H'.($startLine-1));
                }
            }
            $endLine = $startLine -1;

            //Границы для таблицы
            $border = array(
                'borders'=>array(
                    'outline' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
                        'color' => array('rgb' => '000000')
                    ),
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            $aSheet->getStyle("A2:H".$endLine)->applyFromArray($border);
            $aSheet->getStyle("A2:H".$endLine)->getAlignment()->setWrapText(true);
            $aSheet->getStyle("A4:H".$endLine)->getFont()->setSize(10);

            // Выравнивание по горизонтале и вертикали.  По центру
            $aSheet->getStyle("A1:H".$endLine)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $aSheet->getStyle("B4:B".$endLine)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            //Жирный
            $aSheet->getStyle("B4:H".$endLine)->getFont()->setBold(true);

            //Футер Excel документа 
            $aSheet->getStyle("A".($endLine+1))->getFont()->setBold(true);
            $aSheet->setCellValue("A".($endLine+1),'Начальник ЛТЦ  _____________ А. М. Гречный');
            $aSheet->mergeCells('A'.($endLine+1).':B'.($endLine+1));
            $aSheet->getRowDimension(($endLine+1))->setRowHeight(20);

            $aSheet->getStyle("A".($endLine+3))->getFont()->setBold(true);
            $aSheet->setCellValue("A".($endLine+3),'Отчет подготовил____________  Д.В.  Дорошук  тел. 8(0162)213100');
            $aSheet->mergeCells('A'.($endLine+3).':B'.($endLine+3));
            $aSheet->getRowDimension(($endLine+3))->setRowHeight(20);
            
            //Сохранение Excel документа 
            $objWriter = \PHPExcel_IOFactory::createWriter($xls, 'Excel5');
            $objWriter->save('php://output');

            return $response
                            ->withHeader('Content-Description', 'File Transfer')
                            ->withHeader('Content-Type', 'application/octet-stream')
                            ->withHeader('Accept-Ranges', 'bytes')
                            ->withHeader('Content-Transfer-Encoding', 'binary')
                            ->withHeader('Expires', '0')
                            ->withHeader('Cache-Control', 'must-revalidate')
                            ->withHeader('Pragma', 'public')
                            //->withHeader('Content-Length', '1215152')
                            ->withHeader('Content-Disposition', 'attachment; filename=wifiReport.xls');

        }

        public function getCsv ($request, $response, $args) {
            $string = '';
            $replace = array(',', ';');
                    $data = $this->model->getDataPoint();
                        foreach ($data as $key=>$item) {
                            $string.= $item['latitude'].";".$item['longitude'].";".str_replace($replace, ' ', $item['name']).";".$item['ssid'].";".$key."\n";
                    }
                        echo $string;

            return $response
                    ->withHeader('Content-Description', 'File Transfer')
                    ->withHeader('Content-Type', 'application/octet-stream')
                    ->withHeader('Accept-Ranges', 'bytes')
                    ->withHeader('Content-Transfer-Encoding', 'binary')
                    ->withHeader('Expires', '0')
                    ->withHeader('Cache-Control', 'must-revalidate')
                    ->withHeader('Pragma', 'public')
                    ->withHeader('Content-Disposition', 'attachment; filename=WifiPoint.csv');
            }
}