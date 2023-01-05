<?php

namespace App\Exports;

use App\Models\Research;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportResearch implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{

    public function collection()
    {
        $researchs = Research::select(
            'researchs.topic_id AS topic_id',
            DB::raw(
                'CONCAT(users.prefix, users.fullname) AS user'
            ),
            DB::raw(
                '(
                    CASE 
                        WHEN users.sex = "male" THEN "ชาย"
                        WHEN users.sex = "female" THEN "หญิง"
                    END
                ) AS sex'
            ),
            DB::raw(
                '"" AS note'
            ),
            'researchs.topic_th AS topic_th',
            'researchs.topic_en AS topic_en',
            'status_researchs.name AS topic_status',
            DB::raw(
                'REPLACE(researchs.presenter , "|", ", ") AS presenter'
            ),
            'faculties.name AS faculty',
            'branches.name AS branch',
            'degrees.name AS degree',
            'presents.name AS present',
            'researchs.created_at AS created_at_research',
            'slips.name AS slip',
            'slips.address AS slip_address',
            'users.address AS user_address',
            'slips.date AS slip_date',
            DB::raw(
                '(
                    CASE 
                        WHEN users.check_requirement = "before" THEN "ก่อนวันจัดประชุม"
                        WHEN users.check_requirement = "after" THEN "หลังวันจัดประชุม"
                    END
                ) AS check_requirement'
            ),
            'words.name AS word',
            'words.created_at AS word_date',
            'pdf.name AS pdf',
            'pdf.created_at AS pdf_date',
            'users.phone AS phone',
            'users.institution AS institution',
            'positions.name AS position_name',
            'kotas.name AS kota_name',
            'users.email AS email'
        )
            ->leftjoin('status_researchs', 'status_researchs.id', '=', 'researchs.topic_status')
            ->leftjoin('faculties', 'faculties.id', '=', 'researchs.faculty_id')
            ->leftjoin('branches', 'branches.id', '=', 'researchs.branch_id')
            ->leftjoin('degrees', 'degrees.id', '=', 'researchs.degree_id')
            ->leftjoin('presents', 'presents.id', '=', 'researchs.present_id')
            ->leftjoin('users', 'users.id', '=', 'researchs.user_id')
            ->leftjoin('conferences', 'conferences.id', '=', 'researchs.conference_id')
            ->leftjoin('slips', 'slips.topic_id', '=', 'researchs.topic_id')
            ->leftjoin('words', 'words.topic_id', '=', 'researchs.topic_id')
            ->leftjoin('pdf', 'pdf.topic_id', '=', 'researchs.topic_id')
            ->leftjoin('positions', 'positions.id', '=', 'users.position_id')
            ->leftjoin('kotas', 'kotas.id', '=', 'users.kota_id')
            ->where('conferences.status', 1)
            ->where('users.person_attend', 'send')
            ->orderBy('researchs.topic_id')
            ->get();

        return $researchs;
    }

    public function headings(): array
    {
        return [
            'รหัสบทความ',
            'ชื่อผู้ส่งบทความ',
            'เพศ',
            'หมายเหตุ',
            'ชื่อบทความ (ภาษาไทย)',
            'ชื่อบทความ (ภาษาอังกฤษ)',
            'สถานะบทความ',
            'ชื่อผู้นำเสนอ',
            'บทความนี้อยู่ในคณะ',
            'บทความนี้อยู่ในสาขา',
            'ประเภทบทความ',
            'ชนิดการนำเสนอ',
            'วันที่ส่งบทความ',
            'สลิปชำระเงิน',
            'ที่อยู่ผู้ชำระเงิน',
            'ชื่อ/ที่อยู่ (ใช้ในการออกใบเสร็จรับเงิน และส่งเอกสาร)',
            'วันที่ชำระเงิน',
            'ความต้องการใบเสร็จรับเงิน',
            'ไฟล์ WORD',
            'วันที่อัพโหลดไฟล์ WORD',
            'ไฟล์ PDF',
            'วันที่อัพโหลดไฟล์ PDF',
            'เบอร์โทร',
            'สังกัด/หน่วยงาน',
            'สถานะบุคลากร',
            'โควต้าเจ้าภาพร่วม',
            'อีเมล'
        ];
    }

    public function title(): string
    {
        return 'รายละเอียดผู้ส่งบทความ';
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $highestColumn = $event->sheet->getDelegate()->getHighestColumn();

                $columnLoopLimiter = $highestColumn;
                ++$columnLoopLimiter;

                for ($row = 1; $row <= $highestRow; $row++) {
                    for ($column = 'A'; $column !== $columnLoopLimiter; ++$column) {
                        $allCol = 'A1:' . $column . '1';
                        // $allRow = 'A1:' . 'A' . $row;
                        $allCell = 'A1:' . $column . $row;


                        $active_sheet = $event->sheet->getDelegate();
                        // $slip = $active_sheet->getCell('N' . $row)->getValue();
                        // if ($row != 1) {
                        //     if (isset($slip)) {
                        //         $active_sheet->getCell('N' . $row)->getHyperlink()->setUrl(config('app.url') . '/storage/public/ประชุมวิชาการ%202566/บทความ/สลิปชำระเงิน/' . $slip);
                        //         $active_sheet->getStyle('N' . $row)->applyFromArray([
                        //             'font' => [
                        //                 'color' => [
                        //                     'rgb' => '0000ff'
                        //                 ]
                        //             ]
                        //         ]);
                        //     }
                        // }

                        $active_sheet->getStyle($allCol)->getFont()->setBold(true);
                        $active_sheet->getStyle($allCol)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('1F497D');
                        $active_sheet->getStyle($allCol)->applyFromArray([
                            'font' => [
                                'color' => [
                                    'rgb' => 'ffffff'
                                ]
                            ]
                        ]);
                        $active_sheet->getStyle($allCell)->getFont()->setSize(14);
                        $active_sheet->getStyle($allCell)->getFont()->setName('TH SarabunPSK');
                        $active_sheet->getStyle($allCell)->applyFromArray([
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ]
                        ]);
                    }

                    $get_values[$row - 1] = $active_sheet->getCell('E' . $row)->getValue();
                    $get_ids[$row - 1] = $active_sheet->getCell('A' . $row)->getValue();
                    $name_duplicated = [];
                    $get_first_name = [];
                    $ids = [];
                    foreach ($get_values as $key => $get_value) {
                        if (!array_search(trim($get_value), $get_first_name)) {
                            array_push($get_first_name, trim($get_value));
                            array_push($ids, $get_ids[$key]);
                        } else {
                            array_push($name_duplicated, trim($get_value));
                        }
                    }
                }

                for ($row = 1; $row <= $highestRow; $row++) {
                    foreach ($name_duplicated as $key => $name_duplicate) {
                        if (trim($active_sheet->getCell('E' . $row)->getValue()) == $name_duplicate) {
                            if ($id = array_search($name_duplicate, $get_first_name, true)) {
                                if ($ids[$id] != $active_sheet->getCell('A' . $row)->getValue()) {
                                    $active_sheet->getCell('E' . $row)->setValue($name_duplicate);
                                    $active_sheet->getCell('D' . $row)->setValue("บทความนี้ชื่อบทความซ้ำกับบทความที่ " . $ids[$id]);
                                    $active_sheet->getStyle('D' . $row)->applyFromArray([
                                        'font' => [
                                            'color' => [
                                                'rgb' => 'FF0000'
                                            ],
                                            'bold' => true
                                        ]
                                    ]);
                                    for ($column = 'A'; $column !== $columnLoopLimiter; ++$column) {
                                        $active_sheet->getStyle('A' . $active_sheet->getCell('E' . $row)->getRow() . ':' . $column . $active_sheet->getCell('E' . $row)->getRow())->getFill()
                                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                            ->getStartColor()
                                            ->setARGB('FFFF66');
                                    }
                                }
                            }
                        }
                    }
                }
            },
        ];
    }
}
