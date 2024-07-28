<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\ModuleMaterial;
use App\Models\ModuleQuestion;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use function Ramsey\Uuid\v1;

class CourseController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Course::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button type="button" class="edit btn btn-success btn-sm" onclick="editCourse(' . $row->id . ')">Edit</button> ';
                    $actionBtn .= '<button type="button" class="delete btn btn-danger btn-sm" onclick="deleteCourse(' . $row->id . ')">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">In-Active</span>';
                    }
                })
                ->addColumn('created_by', function ($row) {
                    return Auth::user()->name;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M, Y');
                })
                ->rawColumns(['action', 'created_by', 'created_at', 'status'])
                ->make(true);
        }
        return view('courses.index');
    }

    public function create()
    {
        return view('courses.create');
    }

    public function cloneMaterial()
    {
        $html = view('clones.material-clone')->render();
        return response()->json(['html' => $html]);
    }

    public function cloneQuestion($id)
    {
        $html = view('clones.question-clone', compact('id'))->render();
        return response()->json(['html' => $html]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_title' => 'required|min:2',
            'course_description' => 'required',
            'module_title.*' => 'required',
            'module_status.*' => 'required',
            'is_testable.*' => 'required',
            'module_description.*' => 'required',
            'material_types.*' => 'required',
            'material_links.*' => 'required',
            'course_test_title.*' => "required_if:is_testable,==,1",
            'duration.*' => "required_if:is_testable,==,1",
            'instruction.*' => "required_if:is_testable,==,1",
            'questions.*' => "required_if:is_testable,==,1",
            'question_statuses.*' => "required_if:is_testable,==,1",
            'option1.*' => "required_if:is_testable,==,1",
            'option2.*' => "required_if:is_testable,==,1",
            'option3.*' => "required_if:is_testable,==,1",
            'option4.*' => "required_if:is_testable,==,1",
            'answer.*' => "required_if:is_testable,==,1",
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => "You missed you some fields, please check the inputs.",
            ), 200);
        } else {
            DB::beginTransaction();
            try {
                $course = new Course();
                $course->title = $request->course_title;
                $course->description = $request->course_description;
                $course->status = $request->course_status;
                $course->save();

                foreach ($request->module_title as $key => $title) {
                    $module = new Module();
                    $module->course_id = $course->id;
                    $module->title = $title;
                    $module->description = $request->module_description[$key];
                    $module->status = $request->module_status[$key];
                    $module->is_testable = $request->is_testable;
                    $module->test_title = $request->course_test_title[$key];
                    $module->duration = $request->duration[$key];
                    $module->instruction = $request->instruction[$key];
                    $module->save();

                    foreach ($request->material_types as $type_key => $type) {
                        $module_material = new ModuleMaterial();
                        $module_material->module_id = $module->id;
                        $module_material->type = $type;
                        $module_material->link = $request->material_links[$type_key];
                        $module_material->save();
                    }
                    if (!empty($request->questions)) {
                        foreach ($request->questions as $question_key => $question) {
                            $questionObj = new ModuleQuestion();
                            $questionObj->module_id = $module->id;
                            $questionObj->question = $question;
                            $questionObj->status = $request->question_statuses[$question_key];
                            $questionObj->answer = $request->answer[$question_key];
                            $questionObj->save();

                            $answer = new QuestionOption();
                            $answer->question_id = $questionObj->id;
                            $answer->title = $request->option1[$question_key];
                            $answer->save();

                            $answer = new QuestionOption();
                            $answer->question_id = $questionObj->id;
                            $answer->title = $request->option2[$question_key];
                            $answer->save();

                            $answer = new QuestionOption();
                            $answer->question_id = $questionObj->id;
                            $answer->title = $request->option3[$question_key];
                            $answer->save();

                            $answer = new QuestionOption();
                            $answer->question_id = $questionObj->id;
                            $answer->title = $request->option4[$question_key];
                            $answer->save();
                        }
                    }
                }
                DB::commit();
                session()->flash('success', 'Course created successfully.');
                return Response::json(array(
                    'success' => true
                ), 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return Response::json(array(
                    'success' => false,
                    'errors' => "Error occurred while saving the course at Line ." . $e->getMessage() . ' ' . $e->getLine(),
                ), 200);
            }
        }
    }

    public function edit($id)
    {
        $course = Course::whereId($id)->with(['modules'])->first();
        return view('courses.edit', compact('course'));
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_title' => 'required|min:2',
            'course_description' => 'required',
            'module_title.*' => 'required',
            'module_status.*' => 'required',
            'is_testable.*' => 'required',
            'module_description.*' => 'required',
            'material_types.*' => "required",
            'material_links.*' => "required",
            'course_test_title.*' => "required_if:is_testable,==,1",
            'duration.*' => "required_if:is_testable,==,1",
            'instruction.*' => "required_if:is_testable,==,1",
            'questions.*' => "required_if:is_testable,==,1",
            'question_statuses.*' => "required_if:is_testable,==,1",
            'option1.*' => "required_if:is_testable,==,1",
            'option2.*' => "required_if:is_testable,==,1",
            'option3.*' => "required_if:is_testable,==,1",
            'option4.*' => "required_if:is_testable,==,1",
            'answer.*' => "required_if:is_testable,==,1",
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => "You missed you some fields, please check the inputs.",
            ), 200);
        } else {
            $course = Course::find($id);
            DB::beginTransaction();
            try {
                $course->title = $request->course_title;
                $course->description = $request->course_description;
                $course->status = $request->course_status;
                $course->save();

                Module::where('course_id', $course->id)->delete();
                foreach ($request->module_title as $key => $title) {
                    $module = new Module();
                    $module->course_id = $course->id;
                    $module->title = $title;
                    $module->description = $request->module_description[$key];
                    $module->status = $request->module_status[$key];
                    $module->is_testable = $request->is_testable;
                    $module->test_title = $request->course_test_title[$key];
                    $module->duration = $request->duration[$key];
                    $module->instruction = $request->instruction[$key];
                    $module->save();

                    ModuleMaterial::where('module_id', $module->id)->delete();
                    foreach ($request->material_types as $type_key => $type) {
                        $module_material = new ModuleMaterial();
                        $module_material->module_id = $module->id;
                        $module_material->type = $type;
                        $module_material->link = $request->material_links[$type_key];
                        $module_material->save();
                    }

                    $moduleQuestions = ModuleQuestion::where('module_id', $module->id)->get();
                    foreach ($moduleQuestions as $m_question) {
                        QuestionOption::where('question_id', $m_question->id)->delete();
                        $m_question->delete();
                    }
                    foreach ($request->questions as $question_key => $question) {
                        $questionObj = new ModuleQuestion();
                        $questionObj->module_id = $module->id;
                        $questionObj->question = $question;
                        $questionObj->status = $request->question_statuses[$question_key];
                        $questionObj->answer = $request->answer[$question_key];
                        $questionObj->save();

                        $answer = new QuestionOption();
                        $answer->question_id = $questionObj->id;
                        $answer->title = $request->option1[$question_key];
                        $answer->save();

                        $answer = new QuestionOption();
                        $answer->question_id = $questionObj->id;
                        $answer->title = $request->option2[$question_key];
                        $answer->save();

                        $answer = new QuestionOption();
                        $answer->question_id = $questionObj->id;
                        $answer->title = $request->option3[$question_key];
                        $answer->save();

                        $answer = new QuestionOption();
                        $answer->question_id = $questionObj->id;
                        $answer->title = $request->option4[$question_key];
                        $answer->save();
                    }
                    DB::commit();
                    session()->flash('success', 'Course updated successfully.');
                    return Response::json(array(
                        'success' => true
                    ), 200);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return Response::json(array(
                    'success' => false,
                    'errors' => "Error occurred while updating the course at Line ." . $e->getMessage() . ' ' . $e->getLine(),
                ), 200);
            }
        }
    }

    public function destroy($id)
    {
        $course = Course::find($id);
        $modules = Module::where('course_id', $course->id)->get();
        foreach ($modules as $module) {
            $moduleQuestions = ModuleQuestion::where('module_id', $module->id)->get();
            foreach ($moduleQuestions as $m_question) {
                QuestionOption::where('question_id', $m_question->id)->delete();
                $m_question->delete();
            }
            ModuleMaterial::where('module_id', $module->id)->delete();
            $module->delete();
        }
        $course->delete();
        session()->flash('success', 'Course deleted successfully');
        return response()->json(['status' => true]);
    }
}
