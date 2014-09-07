<?php


namespace Acme\Adapter;

use Acme\Student;
use Acme\StudentsRepository;

class EloquentStudentsRepository implements StudentsRepository {

	public function save(Student $student)
	{
		$model = EloquentStudentProxy::toEloquent($student);
		$model->save();
	}

	public function find($id)
	{
		$model = EloquentStudent::find($id);
		return EloquentStudentProxy::toEntity($model);
	}

	public function all()
	{
		return EloquentStudent::all()->map(function($model){
			return EloquentStudentProxy::toEntity($model);
		});
	}
}