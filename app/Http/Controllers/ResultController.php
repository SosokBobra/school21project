<?php

namespace App\Http\Controllers;

use App\Teachers;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Psr7\str;
use App\Predmet;
use App\Students;
use Lavary\Menu\Menu;

class ResultController extends Controller
{
    protected function getMenu()
    {
        $menuObj = (new Menu())->make('MyNavigate', function ($menu) {
            $menu->add('Відобразити всю таблицю', './results/0');
            $menu->add('Відобразити найуспішніших учнів школи', './results/1');
            $menu->add('Відобразити учнів 9Г класу за успішністю', './results/2');
            $menu->add('Відобразити всіх учнів усіх 9 класів за успішністю', './results/3');
            $menu->add('Відобразити всіх вчителів школи за успішністю', './results/4');
            $menu->add('Пошук спортсменів', './results/5');
        });
        return $menuObj;
    }
    protected function clearArray(Array &$array)
    {
        while (true) {
            $firstKey = key($array);
            $firstRow = key($array[$firstKey]);
            if ($array[$firstKey][$firstRow] == null) {
                unset($array[$firstKey]);
            } else {
                break;
            }
        }
    }

    protected function getHeaders(Array $array)
    {
        $firstElementKey = key($array);
        $firstRow = $array[$firstElementKey];
        return $firstRow;
    }

    protected function getTeachers($headers)
    {
        $firstArticle = key($headers);
        next($headers);
        $secondArticle = key($headers);

        unset($headers[$firstArticle]);
        unset($headers[$secondArticle]);
        return $headers;
    }

    protected function getStudents($array)
    {
        foreach ($array as $item) {
            $students[$item['A']] = $item['B'];
        }
        $key = key($students);
        unset($students[$key]);
//        dd($students);
        return $students;
    }


    protected function toDb($teachers, $students)
    {
        DB::table('teachers')->delete();
        DB::table('students')->delete();

        $i = 1;
        foreach ($teachers as $teacher) {
            $nameTeacher = explode(' ', $teacher);
            /* --------Teacher To DB-------------- */
            $teachers = new Teachers();
            $teachers->create([
                'id' => $i++,
                'Name' => $nameTeacher[0],
                'Surname' => $nameTeacher[1]
            ]);

            $teachers->save();
//            $lastTeacherId[] = $teachers->id;
        }
        /* ----------Student to DB---------------- */
        $i = 1;
        foreach ($students as $key=>$value) {
            $arrStudent = explode(' ', $key);

            $student = new Students();
            $student->create([
                'id' => $i++,
                'Name' => $arrStudent[1],
                'Surname' => $arrStudent[0],
                'Class' => $value,
            ]);
            $student->save();
            $lastStudentId[] = $student->id;
        }
        /* ---------------------------------------- */

    }

    /*protected function getFirstScore($array)
    {
        for ($i = 1; $i <= count($array); $i++)
        {
            foreach ($array[$i] as $item) {
                if ($i == 3)
                {
                    return $item;
                } else {
                    $i++;
                }
            }
        }
    }*/
    protected function getElement($item, $number)
    {
        $i = 0;
        foreach ($item as $it) {
            if ($i == $number) {
                return $it;
            } else {
                $i++;
            }
        }
    }

    protected function undefined($reader)
    {
        $menuObj = $this->getMenu();
        $lastRow = $reader->getActiveSheet()->getHighestRow();

        $select = DB::select('SELECT students.Surname as student, students.class, predmet.score, teachers.Surname as teacher FROM predmet,students,teachers WHERE predmet.name_id=students.id AND predmet.teacher_id=teachers.id ORDER BY student ASC');
        return view('results.index', ['data' => $select, 'menu' => $menuObj, 'lastRow' => $lastRow]);
    }

    protected function first($reader)
    {
        $menuObj = $this->getMenu();
        $lastRow = $reader->getActiveSheet()->getHighestRow();

        $select = DB::select('SELECT students.surname as student, students.class, SUM(predmet.score) as score FROM predmet,students,teachers WHERE predmet.name_id=students.id AND predmet.teacher_id=teachers.id GROUP BY students.id ORDER BY score DESC, student ASC');
        return view('results.index', ['data' => $select, 'menu' => $menuObj, 'lastRow' => $lastRow]);
    }

    protected function second($reader)
    {
        $menuObj = $this->getMenu();
        $lastRow = $reader->getActiveSheet()->getHighestRow();
        $s_str='9Г';
        $select = DB::select('SELECT students.surname as student, students.class, SUM(predmet.score) as score FROM predmet,students,teachers WHERE predmet.name_id=students.id AND predmet.teacher_id=teachers.id AND students.class=? GROUP BY students.id ORDER BY score DESC, student ASC', [$s_str]);
        return view('results.index', ['data' => $select, 'menu' => $menuObj, 'lastRow' => $lastRow]);

    }

    protected function third($reader)
    {
        $menuObj = $this->getMenu();
        $lastRow = $reader->getActiveSheet()->getHighestRow();
        $s_str='9';
        $select = DB::select('SELECT students.surname as student, students.class, SUM(predmet.score) as score FROM predmet,students,teachers WHERE predmet.name_id=students.id AND predmet.teacher_id=teachers.id AND students.class LIKE ? GROUP BY students.id ORDER BY score DESC, student ASC', [$s_str.'%']);
        return view('results.index', ['data' => $select, 'menu' => $menuObj, 'lastRow' => $lastRow]);

    }

    protected function fourth($reader)
    {
        $menuObj = $this->getMenu();
        $lastRow = $reader->getActiveSheet()->getHighestRow();

        $select = DB::select('SELECT "всі", "-", SUM(predmet.score) as score, teachers.surname as teacher FROM predmet, teachers WHERE predmet.teacher_id=teachers.id GROUP BY teachers.id ORDER BY score DESC, teacher ASC');
        return view('results.index', ['data' => $select, 'menu' => $menuObj, 'lastRow' => $lastRow]);

    }

    protected function fifth($reader)
    {
        $menuObj = $this->getMenu();
        $lastRow = $reader->getActiveSheet()->getHighestRow();

        $select = DB::select('SELECT students.surname as student, students.class, SUM(predmet.score) as score FROM predmet,students,teachers WHERE predmet.name_id=students.id AND predmet.teacher_id=teachers.id GROUP BY students.id ORDER BY score ASC, student ASC');
        return view('results.index', ['data' => $select, 'menu' => $menuObj, 'lastRow' => $lastRow]);

    }

    protected function sixth()
    {

    }

    public function show($mode = '')
    {
        if (file_exists('Upload.xlsx')) {
            $reader = IOFactory::createReaderForFile('Upload.xlsx')->load('Upload.xlsx');
            $array = $reader->getActiveSheet()->toArray(null, true, true, true);

            $lastRow = $reader->getActiveSheet()->getHighestRow();

            $this->clearArray($array);

            $headers = $this->getHeaders($array);

            $teachers = $this->getTeachers($headers);

            $students = $this->getStudents($array);

            $this->toDb($teachers, $students);

            $stuedntId = null;


            unset($array[key($array)]);
            DB::table('predmet')->delete();

            foreach ($array as $key => $item) {
                $fistBukva = key($item);
//            $secondElement = $this->getElement($item, 2);


                $row = $item[$fistBukva];

                $superrow = explode(' ', $row);
                $stuedntId = Students::select('id')->where('Surname', '=', $superrow[0])->first();


                if ($stuedntId != null) {
                    for ($i = 1; $i <= count($teachers); $i++) {
                        Predmet::create([
                            'name_id' => $stuedntId['id'],
                            'teacher_id' => $i,
                            'score' => $this->getElement($item, $i + 1)
                        ]);
                    }
                }
            }
            $select = DB::select('SELECT students.Surname as student, students.class, predmet.score, teachers.Surname as teacher FROM predmet,students,teachers WHERE predmet.name_id=students.id AND predmet.teacher_id=teachers.id ORDER BY student ASC');


            $menuObj = $this->getMenu();

            if (file_exists('Upload.xlsx')) {
                switch ($mode) {
                    case 0:
                        $view = $this->undefined($reader);
                        break;
                    case 1:
                        $view = $this->first($reader);
                        break;
                    case 2:
                        $view = $this->second($reader);
                        break;
                    case 3:
                        $view = $this->third($reader);
                        break;
                    case 4:
                        $view = $this->fourth($reader);
                        break;
                    case 5:
                        $view = $this->fifth($reader);
                        break;
                    case 6:
                        $view = $this->sixth($reader);
                        break;
                    default:
                        $view = $this->undefined($reader);
                }
            } else {
                return view('form.index');
            }


            return $view->with('mode', $mode);
        } else {
            return redirect()->route('showForm')->with('status', 'Будь ласка, спочатку завантажте файл!');
        }
    }
}

