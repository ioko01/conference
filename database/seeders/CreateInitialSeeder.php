<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\Kota;
use App\Models\Faculty;
use App\Models\Branch;
use App\Models\Degree;
use App\Models\Present;

class CreateInitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            ['name' => 'บุคคลภายในมหาวิทยาลัยราชภัฏเลย'],
            ['name' => 'บุคคลภายนอก'],
            ['name' => 'โควต้าเจ้าภาพร่วม'],
        ];
        foreach ($positions as $key => $value) {
            Position::create($value);
        }

        $faculties = [
            ['name' => 'กลุ่มมนุษยศาสตร์/สังคมศาสตร์'],
            ['name' => 'กลุ่มครุศาสตร์/ศึกษาศาสตร์'],
            ['name' => 'กลุ่มวิทยาศาสตร์และเทคโนโลยี'],
            ['name' => 'กลุ่มบริหารธุรกิจ การบริการ และการท่องเที่ยว'],
            ['name' => 'กลุ่มวิศวกรรม และอุตสาหกรรม'],
        ];
        foreach ($faculties as $key => $value) {
            Faculty::create($value);
        }

        $branches = [
            ['พัฒนาชุมชนและสังคม', 'ศิลปกรรมศาสตร์/ดนตรี', 'นิติศาสตร์/รัฐประศาสนศาสตร์', 'ภาษาศาสตร์/บรรณารักษศาสตร์'],
            ['วิจัยและประเมินผลการศึกษา', 'หลักสูตรและการสอน', 'เทคโนโลยีการศึกษา', 'การบริหารการศึกษา'],
            ['วิทยาศาสตร์สุขภาพ', 'วิทยาศาสตร์ชีวภาพ', 'วิทยาศาสตร์กายภาพ', 'วิทยาศาสตร์คอมฯ'],
            ['เศรษฐศาสตร์และการบัญชี', 'บริหารธุรกิจและการจัดการ', 'การท่องเที่ยวและการโรงแรม', 'คอมพิวเตอร์ธุรกิจ', 'นิเทศศาสตร์'],
            ['วิศวกรรมไฟฟ้า', 'วิศวกรรมเครื่องกล', 'วิศวกรรมอุตสาหการ', 'วิศวกรรมและเทคโนโลยี']
        ];
        $faculties = [
                        Faculty::select('id')->where('name', 'กลุ่มมนุษยศาสตร์/สังคมศาสตร์')->first(),
                        Faculty::select('id')->where('name', 'กลุ่มครุศาสตร์/ศึกษาศาสตร์')->first(),
                        Faculty::select('id')->where('name', 'กลุ่มวิทยาศาสตร์และเทคโนโลยี')->first(),
                        Faculty::select('id')->where('name', 'กลุ่มบริหารธุรกิจ การบริการ และการท่องเที่ยว')->first(),
                        Faculty::select('id')->where('name', 'กลุ่มวิศวกรรม และอุตสาหกรรม')->first()
                    ];
        $i=0;
        foreach ($branches as $key => $branch) {
            foreach ($branch as $key => $value) {
                Branch::create(['name' => $value, 'faculty_id' => $faculties[$i]->id]);
            }
            $i++;
        }

        $degrees = [
            ['name' => 'บทความวิจัย'],
            ['name' => 'บทความวิชาการ'],
            ['name' => 'บทความวิทยานิพนธ์'],
        ];
        foreach ($degrees as $key => $value) {
            Degree::create($value);
        }

        $presents = [
            ['name' => 'Oral (นำเสนอปากเปล่า)'],
            ['name' => 'Poster (การนำเสนอแบบโปสเตอร์)'],
        ];
        foreach ($presents as $key => $value) {
            Present::create($value);
        }

        $kotas = [
            ['name' => 'มหาวิทยาลัยราชภัฏมหาสารคาม'],
            ['name' => 'มหาวิทยาลัยราชภัฏร้อยเอ็ด'],
            ['name' => 'มหาวิทยาลัยราชภัฏสกลนคร'],
            ['name' => 'มหาวิทยาลัยราชภัฏอุดรธานี'],
        ];
        foreach ($kotas as $key => $value) {
            Kota::create($value);
        }
    }
}