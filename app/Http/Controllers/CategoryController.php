<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('doctor.list')) {
            $role = $user->roles[0]->slug;
            $user = Sentinel::getUser();



            $searchName = $request['search_name'] ? : "";
            $searchAbb = $request['search_abbreviation'] ? : "";

            if ($searchName != '' OR $searchAbb != '') {
                $category = Category::where('name', $searchName)->orWhere('abbreviation', $searchAbb)->get();
            } else {
                $category= Category::all();
            }

            return view('exam.category', compact('user', 'role', 'category'));

        } else {
            return view('error.403');
        }
    }
    public function create()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('doctor.list')) {
            $role = $user->roles[0]->slug;
            $user = Sentinel::getUser();

            return view('exam.createcategory', compact('user', 'role'));
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
                    'category_name'=>'',
                ],
            );
            try {
                $category = new Category();
                $category->name = $request->category_name;
                $category->abbreviation = $request->abbreviation;
                $category->save();

                return redirect('category')->with('success', 'Category created successfully!');

            } catch (Exception $e) {
                return redirect('category')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

}
