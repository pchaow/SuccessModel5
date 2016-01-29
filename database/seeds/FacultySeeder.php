<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Faculty;

class FacultySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        DB::table('faculties')->delete();


        $faculties = [
            "คณะเกษตรศาสตร์และทรัพยากรธรรมชาติ",
            "คณะเทคโนโลยีสารสนเทศและการสื่อสาร",
            "คณะพยาบาลศาสตร์",
            "คณะเภสัชศาสตร์",
            "คณะวิทยาศาสตร์",
            "คณะวิศวกรรมศาสตร์",
            "คณะสถาปัตยกรรมศาสตร์และศิลปกรรมศาสตร์",
            "คณะทันตแพทยศาสตร์",
            "คณะนิติศาสตร์",
            "คณะแพทยศาสตร์",
            "คณะรัฐศาสตร์และสังคมศาสตร์",
            "คณะวิทยาการจัดการและสารสนเทศศาสตร์",
            "คณะวิทยาศาสตร์การแพทย์",
            "คณะศิลปศาสตร์",
            "คณะสหเวชศาสตร์",
            "วิทยาลัยการศึกษา",
            "วิทยาลัยพลังงานและสิ่งแวดล้อม",
            "วิทยาลัยการจัดการ กรุงเทพมหานคร"
        ];

        foreach($faculties as $faculty){
            $f = new Faculty();
            $f->name_th = $faculty;
            $f->save();
        }


    }

}
