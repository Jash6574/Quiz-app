<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\QnaExam;

class ExamController extends Controller
{
    //
    public function loadExamDashboard($id)
    {
        $qnaExam = Exam::where('enterance_id', $id)->with('getQnaExam')->get();
        if (count($qnaExam) > 0) {



            if ($qnaExam[0]['date'] == date('Y-m-d')) {
                if (count($qnaExam[0]['getQnaExam']) > 0) {

                    $qna = QnaExam::where('exam_id',$qnaExam[0]['id'])->with('question','answers')->inRandomOrder()->get();
                    return view('student.exam-dashboard', ['success' => true,'exam' => $qnaExam,'qna'=>$qna]);

                } else {
                    return view('student.exam-dashboard', ['success' => false, 'msg' => 'This Exam is not available for now!!', 'exam' => $qnaExam]);
                }
            } else if ($qnaExam[0]['date'] > date('Y-m-d')) {
                return view('student.exam-dashboard', ['success' => false, 'msg' => 'This Exam Will be start on ' . $qnaExam[0]['date'], 'exam' => $qnaExam]);
            } else {
                return view('student.exam-dashboard', ['success' => false, 'msg' => 'Sorry!! This Exam has been Expired on ' . $qnaExam[0]['date'], 'exam' => $qnaExam]);
            }
        } else {
            return view('404');
        }
    }
}