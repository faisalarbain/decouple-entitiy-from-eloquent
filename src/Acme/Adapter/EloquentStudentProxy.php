<?php


namespace Acme\Adapter;


use Acme\EmailAddress;
use Acme\Score;
use Acme\Student;

class EloquentStudentProxy extends Student{

	public static function toEloquent($student)
	{
		$model =  EloquentStudent::findOrNew($student->id);

		$model->fill([
			"name" => $student->name,
			"email" => (string) $student->email,
			"score" => (string) $student->score
		]);

		return $model;
	}

	public static function toEntity($model)
	{
		$student = new Student($model->name, new EmailAddress($model->email));
		$student->score = new Score($model->score);
		$student->id = $model->id;
		return $student;
	}
}