<?php


namespace Acme\Adapter;


use Acme\EmailAddress;
use Acme\Score;
use Acme\Student;

class EloquentStudentProxy extends Student{

	/**
	 * @var EloquentStudent
	 */
	private $eloquentStudent;

	function __construct(EloquentStudent $eloquentStudent)
	{
		$this->eloquentStudent = $eloquentStudent;
	}

	public function toEloquent($student)
	{
		$model =  $this->eloquentStudent->findOrNew($student->id);

		$model->fill([
			"name" => $student->name,
			"email" => (string) $student->email,
			"score" => (string) $student->score
		]);

		return $model;
	}

	public function toEntity($model)
	{
		$student = new Student($model->name, new EmailAddress($model->email));
		$student->score = new Score($model->score);
		$student->id = $model->id;
		return $student;
	}
}