<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportUser implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = User::select(
            DB::raw(
                '(ROW_NUMBER() OVER(ORDER BY users.id)) AS ROW_NUMBER'
            ),
            'users.prefix AS prefix',
            'users.fullname AS fullname',
            DB::raw(
                '(
                    CASE 
                        WHEN users.sex = "male" THEN "ชาย"
                        WHEN users.sex = "female" THEN "หญิง"
                    END
                ) AS sex'
            ),
            'users.phone AS phone',
            'users.address AS address',
            'users.institution AS institution',
            'positions.name AS positions_name',
            'kotas.name AS kotas_name',
            'users.email AS email',
            'users.created_at AS users_created_at',
            'users.updated_at AS users_updated_at',
            DB::raw(
                '(
                    CASE 
                        WHEN users.check_requirement = "before" THEN "ก่อนวันจัดประชุม"
                        WHEN users.check_requirement = "after" THEN "หลังวันจัดประชุม"
                    END
                ) AS check_requirement,
                (
                    CASE
                        WHEN users.person_attend = "send" THEN "ลงทะเบียนส่งผลงาน"
                        WHEN users.person_attend = "attend" THEN "ลงทะเบียนเข้าร่วมงานทั่วไป"
                    END
                ) AS person_attend'
            )
        )
            ->leftjoin('positions', 'users.position_id', 'positions.id')
            ->leftjoin('kotas', 'users.kota_id', 'kotas.id')
            ->leftjoin('conferences', 'users.conference_id', 'conferences.id')
            ->where('conferences.status', 1)
            ->get();

        return $data;
    }

    public function headings(): array
    {
        return [
            'ลำดับที่',
            'คำนำหน้า',
            'ชื่อ - นามสกุล',
            'เพศ',
            'เบอร์โทร',
            'ที่อยู่ (ใช้ในการออกใบเสร็จรับเงิน และส่งเอกสาร)',
            'สังกัด/หน่วยงาน',
            'สถานะบุคลากร',
            'โควต้าเจ้าภาพร่วม',
            'อีเมล',
            'สร้างเมื่อ',
            'แก้ไขล่าสุดเมื่อ',
            'ความต้องการใบเสร็จรับเงิน',
            'สถานะการเข้าร่วมงาน'
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
                        $allRow = 'A1:' . 'A' . $row;
                        $allCell = 'A1:' . $column . $row;

                        $active_sheet = $event->sheet->getDelegate();
                        $active_sheet->getStyle($allCol)->getFont()->setBold(true);
                        $active_sheet->getStyle($allCol)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('FFFF00');
                        $active_sheet->getStyle($allCell)->getFont()->setSize(14);
                        $active_sheet->getStyle($allCell)->getFont()->setName('TH SarabunPSK');
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
                }
            },
        ];
    }
}
