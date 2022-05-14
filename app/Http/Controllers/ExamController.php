<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Exam;


class ExamController extends Controller
{
    public function index()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('doctor.list')) {
            $role = $user->roles[0]->slug;
            $user = Sentinel::getUser();

            $exam = Exam::all();


            return view('exam.examlist', compact('user','role', 'exam'));
        } else {
            return view('error.403');
        }
    }
    public function create(){
        $user = Sentinel::getUser();
        if ($user->hasAccess('doctor.list')) {
            $role = $user->roles[0]->slug;
            $user = Sentinel::getUser();

            return view('exam.registerexam', compact('user', 'role'));
        } else {
            return view('error.403');
        }
    }

    public function store(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('doctor.list')) {
            $validatedData = $request->validate(
                [
                    'abbreviation' => '',
                    'name'=>'',
                    'category'=>'',
                    'team'=>'',
                    'destiny'=>'',
                    'label_group' => '',
                    'quantity_label' => '',
                    'exam_kit',
                    'exam_support',
                    'exam_price',
                    'exam_editor',
                ],
            );
            try {
                $exam = new Exam();
                $exam->abbreviation = $request->abbreviation;
                $exam->name = $request->name;
                $exam->category = $request->category;
                $exam->team = $request->team;
                $exam->destiny = $request->destiny;
                $exam->label_group = $request->label_group;
                $exam->quantity_label = $request->quantity_label;
                $exam->exam_kit = $request->exam_kit;
                $exam->exam_support = $request->exam_support;
                $exam->exam_price = $request->exam_price;
                $exam->exam_editor = $request->exam_editor;


                $exam->save();

                return redirect('exam')->with('success', 'Exam created successfully!');

            } catch (Exception $e) {
                return redirect('exam')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

}
