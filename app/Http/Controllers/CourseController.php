<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseCRUDRequest;
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

    public function cloneMaterial($id)
    {
        $html = view('clones.material-clone', compact('id'))->render();
        return response()->json(['html' => $html]);
    }

    public function cloneQuestion($id, $index)
    {
        $html = view('clones.question-clone', compact('id', 'index'))->render();
        return response()->json(['html' => $html]);
    }

    public function cloneModule($id)
    {
        $html = view('clones.module-clone', compact('id'))->render();
        return response()->json(['html' => $html]);
    }

    public function store(CourseCRUDRequest $request)
    {
        DB::beginTransaction();
        try {
            $course = new Course();
            $course->title = $request->course_title;
            $course->description = $request->course_description;
            $course->status = $request->course_status;
            $course->save();

            foreach ($request->module as $md) {
                $module = new Module();
                $module->course_id = $course->id;
                $module->title = $md['module_title'];
                $module->description = $md['module_description'];
                $module->status = $md['module_status'];
                $module->is_testable = $md['is_testable'];
                $module->test_title = $md['course_test_title'];
                $module->duration = $md['duration'];
                $module->instruction = $md['instruction'];
                $module->save();

                foreach ($md['material_types'] as $type_key => $type) {
                    $module_material = new ModuleMaterial();
                    $module_material->module_id = $module->id;
                    $module_material->type = $type;
                    $module_material->link = $md['material_links'][$type_key];
                    $module_material->save();
                }

                $answers = array_values($md['answer']);
                foreach ($md['questions'] as $question_key => $question) {
                    $questionObj = new ModuleQuestion();
                    $questionObj->module_id = $module->id;
                    $questionObj->question = $question;
                    $questionObj->status = $md['question_statuses'][$question_key];
                    $questionObj->answer = $answers[$question_key];
                    $questionObj->save();

                    $answer = new QuestionOption();
                    $answer->question_id = $questionObj->id;
                    $answer->title = array_values($md['option1'])[$question_key];
                    $answer->save();

                    $answer = new QuestionOption();
                    $answer->question_id = $questionObj->id;
                    $answer->title = array_values($md['option2'])[$question_key];
                    $answer->save();


                    $answer = new QuestionOption();
                    $answer->question_id = $questionObj->id;
                    $answer->title = array_values($md['option3'])[$question_key];
                    $answer->save();

                    $answer = new QuestionOption();
                    $answer->question_id = $questionObj->id;
                    $answer->title = array_values($md['option4'])[$question_key];
                    $answer->save();
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

    public function edit($id)
    {
        $course = Course::whereId($id)->with(['modules'])->first();
        return view('courses.edit', compact('course'));
    }

    public function update($id, CourseCRUDRequest $request)
    {
        DB::beginTransaction();
        try {
            $course = Course::find($id);
            $modules = Module::where('course_id', $course->id)->get();
            foreach ($modules as $module) {
                $module->materials()->delete();
                $questions = ModuleQuestion::where('module_id', $module->id)->get();
                foreach ($questions as $question) {
                    QuestionOption::where('question_id', $question->id)->delete();
                    $question->delete();
                }
                $module->delete();
            }

            $course->title = $request->course_title;
            $course->description = $request->course_description;
            $course->status = $request->course_status;
            $course->save();

            foreach ($request->module as $md) {
                $module = new Module();
                $module->course_id = $course->id;
                $module->title = $md['module_title'];
                $module->description = $md['module_description'];
                $module->status = $md['module_status'];
                $module->is_testable = $md['is_testable'];
                $module->test_title = $md['course_test_title'];
                $module->duration = $md['duration'];
                $module->instruction = $md['instruction'];
                $module->save();

                foreach ($md['material_types'] as $type_key => $type) {
                    $module_material = new ModuleMaterial();
                    $module_material->module_id = $module->id;
                    $module_material->type = $type;
                    $module_material->link = $md['material_links'][$type_key];
                    $module_material->save();
                }

                $answers = array_values($md['answer']);
                foreach (array_values($md['questions']) as $question_key => $question) {
                    $questionObj = new ModuleQuestion();
                    $questionObj->module_id = $module->id;
                    $questionObj->question = $question;
                    $questionObj->status = array_values($md['question_statuses'])[$question_key];
                    $questionObj->answer = $answers[$question_key];
                    $questionObj->save();

                    $answer = new QuestionOption();
                    $answer->question_id = $questionObj->id;
                    $answer->title = array_values($md['option1'])[$question_key];
                    $answer->save();

                    $answer = new QuestionOption();
                    $answer->question_id = $questionObj->id;
                    $answer->title = array_values($md['option2'])[$question_key];
                    $answer->save();


                    $answer = new QuestionOption();
                    $answer->question_id = $questionObj->id;
                    $answer->title = array_values($md['option3'])[$question_key];
                    $answer->save();

                    $answer = new QuestionOption();
                    $answer->question_id = $questionObj->id;
                    $answer->title = array_values($md['option4'])[$question_key];
                    $answer->save();
                }
            }

            DB::commit();
            session()->flash('success', 'Course updated successfully.');
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

    public function destroy($id)
    {
        $course = Course::find($id);
        $modules = Module::where('course_id', $course->id)->get();
        foreach ($modules as $module) {
            $module->materials()->delete();
            $questions = ModuleQuestion::where('module_id', $module->id)->get();
            foreach ($questions as $question) {
                QuestionOption::where('question_id', $question->id)->delete();
                $question->delete();
            }
            $module->delete();
        }
        $course->delete();
        session()->flash('success', 'Course deleted successfully');
        return response()->json(['status' => true]);
    }
}
