<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Blog;
use Validator, Redirect, Toastr, DB, File, Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::where('status', '!=', '3')->orderBy('created_at', 'desc');
        $queries = [];
        $columns = [
            'title', 'status'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                
                $blogs = $blogs->where($column, 'like', "%".request($column)."%");

                $queries[$column] = request($column);
            }
        }

        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }
        $blogs = $blogs->paginate($per_page)->appends($queries);
        return view('backend.blogs.index', ['blogs'=>$blogs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }

        $input = $request->all();


        if(!empty($request->image)){
            
            $files = $request->file('image'); 
            $name = $files->getClientOriginalName();
            $exp = explode(".", $name);
            $file_ext = end($exp);
            $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;

            $input['image'] = "uploads/blogs/".$name;
            $files->move("uploads/blogs/", $name);
        }

        $input['title'] = trim($request->title);
        $input['description'] = trim($request->description);
        $input['blog_date']= date('Y-m-d', strtotime($request->blog_date));

        $blog = Blog::create($input);

        Toastr::success("$blog->title Create Successfully!");
        return redirect()->route('blog.blogs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('backend.blogs.edit', ['blog'=>$blog]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }

        $input = $request->all();


        if(!empty($request->image)){
            
            $files = $request->file('image'); 
            $name = $files->getClientOriginalName();
            $exp = explode(".", $name);
            $file_ext = end($exp);
            $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;

            $input['image'] = "uploads/blogs/".$name;
            $files->move("uploads/blogs/", $name);
        }else{
            $input = $request->except(['image']);
        }

        $input['title'] = trim($request->title);
        $input['description'] = trim($request->description);
        $input['blog_date']= date('Y-m-d', strtotime($request->blog_date));

        $update = Blog::find($id);
        $title = $update->title;
        $update = $update->update($input);

        Toastr::success("Blog $title Update Successfully!");
        return redirect()->route('blog.blogs.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
