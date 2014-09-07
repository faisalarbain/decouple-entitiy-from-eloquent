<?php


namespace Acme\Adapter;

use Acme\Student;
use Acme\StudentsRepository;

class EloquentStudentsRepository implements StudentsRepository {

	/**
	 * @var EloquentStudentProxy
	 */
	private $proxy;
	/**
	 * @var EloquentStudent
	 */
	private $eloquentStudent;

	function __construct(EloquentStudentProxy $proxy, EloquentStudent $eloquentStudent)
	{
		$this->proxy = $proxy;
		$this->eloquentStudent = $eloquentStudent;
	}

	public function save(Student $student)
	{
		$model = $this->proxy->toEloquent($student);
		$model->save();
	}

	public function find($id)
	{
		$model = $this->eloquentStudent->find($id);
		return $this->proxy->toEntity($model);
	}

	public function all()
	{
		return $this->eloquentStudent->all()->map(function($model){
			return $this->proxy->toEntity($model);
		});
	}
}